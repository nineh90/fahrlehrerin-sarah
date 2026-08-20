<?php
declare(strict_types=1);

/**
 * Strukturierte Daten (JSON-LD) für die öffentlichen Seiten – SAR-10.
 *
 * DER TYP IST HIER DIE EIGENTLICHE ENTSCHEIDUNG, und er ist `Person`.
 *
 * Naheliegend wären `DrivingSchool` oder `LocalBusiness`: Beide bringen in der
 * Suche mehr Anzeigefläche mit, Öffnungszeiten, Bewertungssterne, einen
 * Kartenpunkt. Genau deshalb wären sie falsch. Sarah ist angestellte
 * Fahrlehrerin und kein Betrieb – ein Betriebs-Markup würde Google genau das
 * erzählen, was die ganze Seite sorgfältig vermeidet: dass hier eine
 * Fahrschule stünde, bei der man sich anmelden, Preise erfragen und einen
 * Vertrag schließen kann. Aus demselben Grund gibt es hier weder `priceRange`
 * noch `openingHours` noch `aggregateRating`.
 *
 * Der Betrieb steht stattdessen dort, wo er hingehört: als `worksFor` – und
 * nur, wenn SCHOOL_NAME gefüllt ist. Dieselbe Prüfung wie in allen Templates.
 *
 * Was hier steht, steht auch sichtbar auf der Seite. Strukturierte Daten, die
 * mehr behaupten als die Seite zeigt, sind ein Verstoß gegen Googles
 * Richtlinien und fliegen im Zweifel ganz raus.
 */
final class Seo
{
    /**
     * Sarah als Person, mit ihrem Schwerpunkt und ihrer Fahrschule.
     *
     * @return array<string, mixed>
     */
    public static function person(): array
    {
        $daten = [
            '@context'    => 'https://schema.org',
            '@type'       => 'Person',
            '@id'         => absolute_url('/') . '#sarah',
            'name'        => 'Fahrlehrerin Sarah',
            'jobTitle'    => 'Fahrlehrerin',
            'url'         => absolute_url('/'),
            /* BEWUSST DAS LOGO UND NICHT IHR FOTO. Dieses Bild ist das, was
               Google in einem Wissenspanel neben ihren Namen stellen kann –
               dieselbe Frage wie beim og:image, und dort hat Sarah am
               07.08.2026 entschieden, dass kein Bild von ihr ungefragt
               anderswo auftaucht. Nicht ohne Rücksprache mit ihr ändern. */
            'image'       => absolute_url('/assets/img/logo-sarah-teilen.jpg'),
            'description' => 'Fahrlehrerin für die Klassen B und BE mit Schwerpunkt '
                . 'auf der Ausbildung von Menschen mit Handicap.',
            /* Ihr Alleinstellungsmerkmal, in der Sprache der Suchenden. Die
               Begriffe stehen alle sichtbar auf /fahren-mit-handicap. */
            'knowsAbout'  => [
                'Fahrausbildung Klasse B',
                'Fahrausbildung Klasse BE',
                'Führerschein mit Handicap',
                'Fahren mit Handbedienung',
                'Fahren mit Lenkhilfe',
                'Fahren mit Pedalverlängerung',
            ],
        ];

        /* Die Klassen als Qualifikation. `EducationalOccupationalCredential`
           ist der Typ für „darf das ausbilden", nicht für „hat den Schein". */
        $daten['hasCredential'] = [
            '@type'                => 'EducationalOccupationalCredential',
            'credentialCategory'   => 'Fahrlehrerlaubnis',
            'name'                 => 'Fahrlehrerlaubnis der Klassen B und BE',
        ];

        $telefon = (string) config('contact.phone', '');
        if ($telefon !== '') {
            $daten['telephone'] = $telefon;
        }
        $mail = (string) config('contact.email', '');
        if ($mail !== '') {
            $daten['email'] = $mail;
        }

        /* Einzugsgebiet. `areaServed` und nicht `address`: Sarah hat auf
           dieser Seite keine Anschrift, und sie soll auch keine bekommen –
           die Frage, ob ihre Privatadresse ins Netz gehört, ist offen und
           ihre Entscheidung (siehe CLAUDE.md, Impressum). */
        $gebiet = (array) config('contact.area', []);
        if ($gebiet !== []) {
            $daten['areaServed'] = array_map(
                static fn (string $ort): array => ['@type' => 'Place', 'name' => $ort],
                $gebiet
            );
        }

        /* Die Fahrschule – nur wenn sie genannt wird. Bleibt SCHOOL_NAME
           leer, verschwindet sie hier genauso wie in den Templates. */
        $schule = (string) config('school.name', '');
        if ($schule !== '') {
            $arbeitgeber = ['@type' => 'DrivingSchool', 'name' => $schule];
            $schulUrl = (string) config('school.url', '');
            if ($schulUrl !== '') {
                $arbeitgeber['url'] = $schulUrl;
            }
            $daten['worksFor'] = $arbeitgeber;
        }

        /* Ihre Kanäle. `sameAs` ist die Zeile, mit der Google „Sarah auf
           TikTok" und „Sarah hier" als dieselbe Person zusammenführt – bei
           ihr die stärkste Verbindung, die die Seite anzubieten hat. */
        $kanaele = [];
        $tiktok = (string) config('social.tiktok_handle', '');
        if ($tiktok !== '') {
            $kanaele[] = 'https://www.tiktok.com/@' . $tiktok;
        }
        $instagram = (string) config('social.instagram_handle', '');
        if ($instagram !== '') {
            $kanaele[] = 'https://www.instagram.com/' . $instagram . '/';
        }
        if ($kanaele !== []) {
            $daten['sameAs'] = $kanaele;
        }

        return $daten;
    }

    /**
     * Die Website selbst, verknüpft mit Sarah. Nur für die Startseite.
     *
     * KEINE `SearchAction` – die Seite hat keine Suche. Ein Markup dafür
     * einzubauen, weil es „gut aussieht", wäre eine Behauptung über eine
     * Funktion, die es nicht gibt.
     *
     * @return array<string, mixed>
     */
    public static function website(): array
    {
        return [
            '@context'  => 'https://schema.org',
            '@type'     => 'WebSite',
            '@id'       => absolute_url('/') . '#website',
            'url'       => absolute_url('/'),
            'name'      => 'Fahrlehrerin Sarah',
            'inLanguage' => 'de-DE',
            'publisher' => ['@id' => absolute_url('/') . '#sarah'],
        ];
    }

    /**
     * Ein Wegbegleiter als Organisation – für /wegbegleiter/{slug}.
     *
     * Die Unterseite handelt von einem fremden Betrieb, also steht dort auch
     * dessen Markup und nicht Sarahs. Verknüpft wird über `knows`: Sarah
     * kennt sie, sie gehören nicht zu ihr.
     *
     * @param array<string, mixed> $partner
     * @return array<string, mixed>
     */
    public static function partner(array $partner): array
    {
        $daten = [
            '@context' => 'https://schema.org',
            '@type'    => 'Organization',
            'name'     => (string) ($partner['name'] ?? ''),
        ];
        if (!empty($partner['url'])) {
            $daten['url'] = (string) $partner['url'];
        }
        if (!empty($partner['meta'])) {
            $daten['description'] = (string) $partner['meta'];
        }

        return $daten;
    }

    /**
     * JSON-LD als fertiges <script>-Tag.
     *
     * `JSON_UNESCAPED_UNICODE` ist hier wichtig: Ohne das stünde in der
     * Quelle „Neu Wulmstorf" mit \u-Folgen – gültig, aber unlesbar, und
     * niemand prüft nach, was er nicht lesen kann.
     *
     * @param array<string, mixed> $daten
     */
    public static function script(array $daten): string
    {
        /* JSON_HEX_TAG ist die Zeile, die hier Sicherheit macht: Sie schreibt
           jedes < und > als \u003C/\u003E. Ohne sie würde ein "</script>"
           mitten in den Daten den Block beenden, und alles dahinter wäre
           plötzlich HTML. Heute steht in den Daten nichts dergleichen – aber
           `partner['meta']` und die Konfiguration sind Text von Menschen,
           und der ändert sich. */
        $json = json_encode(
            $daten,
            JSON_HEX_TAG | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
        );
        if ($json === false) {
            return '';
        }

        return '<script type="application/ld+json">' . "\n" . $json . "\n" . '</script>';
    }
}
