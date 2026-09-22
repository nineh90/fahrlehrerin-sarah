<?php
declare(strict_types=1);

/**
 * TIKTOK-VIDEOS PER LINK ÜBERNEHMEN (SAR-129, Variante B).
 *
 * Sarah (oder Nils) fügt im Admin den Link zu einem ihrer Videos ein. Diese
 * Klasse fragt TikToks öffentliche oEmbed-Schnittstelle nach Titel und
 * Vorschaubild und lädt das Bild herunter. Keine Anmeldung, kein Schlüssel,
 * keine App-Prüfung bei TikTok – das ist der ganze Grund für Variante B.
 *
 * WARUM DAS BILD AUF UNSEREN SERVER KOMMT und nicht von TikTok verlinkt wird:
 * 1. Die Vorschau-Adressen sind signiert und laufen ab (`x-expires`). Ein
 *    verlinktes Bild wäre nach ein paar Wochen ein kaputtes.
 * 2. Die Datenschutzerklärung sagt zu, dass die Seite keine Verbindung nach
 *    außen aufbaut. Ein Bild von tiktokcdn.com gäbe die IP jedes Besuchers an
 *    TikTok weiter, ohne dass jemand irgendwo geklickt hat.
 *
 * Aus demselben Grund gibt es hier kein Embed: Das oEmbed-HTML, das TikTok
 * mitschickt, lädt `embed.js` – genau der Fremdcode, der in CLAUDE.md unter
 * „Bewusst zurückgestellt" steht. Wir nehmen nur Titel und Bild.
 *
 * Kommt später die echte Schnittstelle dazu (Variante A), ersetzt sie nur das
 * Einsammeln der Links. Was danach passiert – Bild holen, speichern, zeigen –
 * bleibt dasselbe.
 */
final class TikTok
{
    private const OEMBED   = 'https://www.tiktok.com/oembed?url=';
    private const TIMEOUT  = 8;
    /** Ein Vorschaubild hat rund 50–150 KB. Alles deutlich darüber ist keins. */
    private const MAX_BILD = 3_000_000;

    /** Endung je erlaubtem Bildformat. Alles andere wird abgelehnt. */
    private const BILDTYPEN = [
        'image/jpeg' => 'jpg',
        'image/webp' => 'webp',
        'image/png'  => 'png',
    ];

    /**
     * Holt die Daten zu einem Videolink.
     *
     * @return array{external_id:string, url:string, caption:string,
     *               bild:string, bild_typ:string, breite:int, hoehe:int}
     * @throws RuntimeException mit einer Meldung, die so im Admin stehen kann
     */
    public static function fetch(string $link): array
    {
        $link = self::resolveShortLink(trim($link));

        if (!preg_match('~^https://(www\.|m\.)?tiktok\.com/@([\w.]+)/video/(\d{8,25})~i', $link, $m)) {
            throw new RuntimeException(
                'Das ist kein Link zu einem TikTok-Video. Er sieht so aus: '
                . 'https://www.tiktok.com/@' . config('social.tiktok_handle') . '/video/1234…'
            );
        }
        $id  = $m[3];
        $url = 'https://www.tiktok.com/@' . $m[2] . '/video/' . $id;

        $json = self::get(self::OEMBED . rawurlencode($url), 'application/json');
        $data = $json !== null ? json_decode($json, true) : null;
        if (!is_array($data) || ($data['type'] ?? '') !== 'video') {
            throw new RuntimeException(
                'TikTok kennt dieses Video nicht (gelöscht, privat oder nur für Freunde sichtbar?).'
            );
        }

        /* NUR SARAHS EIGENE VIDEOS. Die Startseite ist ihr Schaufenster – ein
           versehentlich eingefügter Link zu einem fremden Kanal stünde dort
           sonst unter ihrem Namen. Verglichen wird der Kanal, den TikTok
           selbst nennt, nicht der im Link: Der Handle im Link ist beliebig,
           TikTok leitet jede Schreibweise auf das richtige Video um. */
        $handle = strtolower((string) config('social.tiktok_handle'));
        $autor  = strtolower((string) ($data['author_unique_id'] ?? ''));
        if ($autor !== $handle) {
            throw new RuntimeException(
                'Das Video stammt von @' . ($autor ?: 'unbekannt') . ', nicht von @' . $handle
                . '. Auf der Startseite stehen nur eigene Videos.'
            );
        }

        $bildUrl = (string) ($data['thumbnail_url'] ?? '');
        $host    = strtolower((string) parse_url($bildUrl, PHP_URL_HOST));
        if (!str_starts_with($bildUrl, 'https://')
            || !preg_match('~(^|\.)tiktokcdn(-[a-z]+)?\.com$~', $host)) {
            throw new RuntimeException('TikTok hat kein Vorschaubild zu diesem Video geliefert.');
        }

        $bild = self::get($bildUrl, 'image/*', self::MAX_BILD);
        $typ  = $bild !== null ? (new finfo(FILEINFO_MIME_TYPE))->buffer($bild) : false;
        if ($bild === null || !isset(self::BILDTYPEN[$typ])) {
            throw new RuntimeException('Das Vorschaubild ließ sich nicht laden. Später noch einmal versuchen.');
        }
        [$bild, $typ] = self::shrink($bild, $typ);
        $masse = @getimagesizefromstring($bild) ?: [576, 1024];

        return [
            'external_id' => $id,
            'url'         => 'https://www.tiktok.com/@' . $handle . '/video/' . $id,
            'caption'     => trim((string) ($data['title'] ?? '')),
            'bild'        => $bild,
            'bild_typ'    => self::BILDTYPEN[$typ],
            'breite'      => (int) $masse[0],
            'hoehe'       => (int) $masse[1],
        ];
    }

    /**
     * VERKLEINERN, BEVOR ES GESPEICHERT WIRD. TikTok liefert das Vorschaubild
     * in voller Videoauflösung – nachgemessen 2160 × 3840 px und 600 KB. Auf der
     * Startseite ist eine Kachel höchstens rund 280 px breit; vier Originale
     * wären 2,4 MB für vier Briefmarken. 640 px reichen auch für doppelte
     * Pixeldichte und landen bei rund 100 KB (nachgemessen: 101 KB).
     *
     * Braucht GD. Das Container-Image bringt es seit SAR-129 mit
     * (deploy/Dockerfile). Fehlt es, wird das Original gespeichert – zu schwer,
     * aber nicht kaputt.
     *
     * @return array{0:string, 1:string} Bilddaten und MIME-Typ
     */
    private static function shrink(string $bild, string $typ): array
    {
        $ziel = 640;
        if (!function_exists('imagecreatefromstring') || !function_exists('imagejpeg')) {
            error_log('TikTok::shrink: GD fehlt, Vorschaubild bleibt in Originalgröße.');
            return [$bild, $typ];
        }
        $quelle = @imagecreatefromstring($bild);
        if ($quelle === false) {
            return [$bild, $typ];
        }
        $breite = imagesx($quelle);
        $hoehe  = imagesy($quelle);
        if ($breite <= $ziel) {
            return [$bild, $typ];
        }

        /* imagecopyresampled statt imagescale: Letzteres gibt je nach
           GD-Build für IMG_BICUBIC stumm `false` zurück (lokal so passiert). */
        $zielHoehe = (int) round($hoehe * $ziel / $breite);
        $neu = imagecreatetruecolor($ziel, $zielHoehe);
        if ($neu === false
            || !imagecopyresampled($neu, $quelle, 0, 0, 0, 0, $ziel, $zielHoehe, $breite, $hoehe)) {
            return [$bild, $typ];
        }
        imageinterlace($neu, true);
        ob_start();
        imagejpeg($neu, null, 80);

        return [(string) ob_get_clean(), 'image/jpeg'];
    }

    /**
     * Veröffentlichungszeitpunkt aus der Video-ID.
     *
     * TikTok liefert über oEmbed kein Datum. Die ID trägt es aber in sich:
     * Die oberen 32 Bit sind der Unix-Zeitstempel des Hochladens. Damit lässt
     * sich „die neuesten zuerst" sortieren, ohne dass jemand ein Datum eintippt.
     */
    public static function postedAt(string $externalId): DateTimeImmutable
    {
        $sekunden = intdiv((int) $externalId, 2 ** 32);

        return (new DateTimeImmutable('@' . $sekunden))
            ->setTimezone(new DateTimeZone(date_default_timezone_get()));
    }

    /**
     * Die Beschreibung ohne Hashtags. Auf TikTok helfen sie beim Gefundenwerden,
     * als Überschrift auf der Startseite sind sie Rauschen.
     */
    public static function cleanCaption(string $caption): string
    {
        $text = preg_replace('/(^|\s)#[^\s#]+/u', ' ', $caption) ?? $caption;

        return trim(preg_replace('/\s+/u', ' ', $text) ?? $text);
    }

    /**
     * Kurzlinks aus der App (vm.tiktok.com/…) zeigen auf keine Video-ID.
     * Sie werden einmal aufgelöst; wohin sie führen, prüft danach dieselbe
     * Regel wie bei einem langen Link.
     */
    private static function resolveShortLink(string $link): string
    {
        $host = strtolower((string) parse_url($link, PHP_URL_HOST));
        if (!in_array($host, ['vm.tiktok.com', 'vt.tiktok.com'], true) || !function_exists('curl_init')) {
            return $link;
        }

        $ch = curl_init($link);
        curl_setopt_array($ch, [
            CURLOPT_NOBODY         => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_MAXREDIRS      => 5,
            CURLOPT_PROTOCOLS      => CURLPROTO_HTTPS,
            CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTPS,
            CURLOPT_TIMEOUT        => self::TIMEOUT,
            CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; fahrlehrerinsarah.de)',
        ]);
        curl_exec($ch);
        $ziel = (string) curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);

        return $ziel !== '' ? $ziel : $link;
    }

    /** GET mit Zeitlimit. Gibt null zurück statt zu werfen – der Aufrufer formuliert die Meldung. */
    private static function get(string $url, string $accept, int $maxBytes = 1_000_000): ?string
    {
        if (function_exists('curl_init')) {
            $ch = curl_init($url);
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_MAXREDIRS      => 3,
                CURLOPT_PROTOCOLS      => CURLPROTO_HTTPS,
                CURLOPT_REDIR_PROTOCOLS => CURLPROTO_HTTPS,
                CURLOPT_TIMEOUT        => self::TIMEOUT,
                CURLOPT_HTTPHEADER     => ['Accept: ' . $accept],
                CURLOPT_USERAGENT      => 'Mozilla/5.0 (compatible; fahrlehrerinsarah.de)',
            ]);
            $body   = curl_exec($ch);
            $status = (int) curl_getinfo($ch, CURLINFO_RESPONSE_CODE);
            } else {
            $context = stream_context_create(['http' => [
                'timeout'       => self::TIMEOUT,
                'header'        => "Accept: $accept\r\nUser-Agent: Mozilla/5.0 (compatible; fahrlehrerinsarah.de)\r\n",
                'ignore_errors' => true,
            ]]);
            $body   = @file_get_contents($url, false, $context, 0, $maxBytes + 1);
            $status = preg_match('~^HTTP/\S+ (\d{3})~', $http_response_header[0] ?? '', $s) ? (int) $s[1] : 0;
        }

        if (!is_string($body) || $status !== 200 || $body === '' || strlen($body) > $maxBytes) {
            return null;
        }

        return $body;
    }
}
