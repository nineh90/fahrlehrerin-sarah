<?php
declare(strict_types=1);

/**
 * Sarahs Videos für die Startseite (SAR-129).
 *
 * Eingetragen werden sie im Admin unter /admin/videos, per Link. Die Daten
 * holt `TikTok::fetch()`, das Vorschaubild liegt unter storage/videos/ und
 * wird über /video-vorschau/{id} ausgeliefert – nicht aus public/, weil der
 * Container nur storage/ beschreiben darf (Deploy: `chown 33:33 storage`).
 *
 * DIE TABELLE LEGT SICH SELBST AN. Die Produktionsdatenbank ist mit einem
 * älteren Schema entstanden, und `migrate.php` darf dort nie laufen – es
 * beginnt mit DROP TABLE. `CREATE TABLE IF NOT EXISTS` beim ersten Zugriff ist
 * deshalb der einzige Weg, der ohne Handgriff auf dem Server auskommt. Dieselbe
 * Anweisung steht zusätzlich in database/schema.sqlite.sql, damit eine frische
 * Datenbank sie von Anfang an hat.
 */
final class Video
{
    public const PLATFORMS = [
        'tiktok' => 'TikTok',
    ];

    /** So viele stehen auf der Startseite. Vier füllen eine Reihe, gestapelt zwei. */
    public const HOME_LIMIT = 4;

    private static bool $ready = false;

    private static function db(): PDO
    {
        $pdo = Database::connection();
        if (!self::$ready) {
            $pdo->exec(
                "CREATE TABLE IF NOT EXISTS videos (
                    id          INTEGER PRIMARY KEY AUTOINCREMENT,
                    platform    TEXT    NOT NULL DEFAULT 'tiktok' CHECK (platform IN ('tiktok')),
                    external_id TEXT    NOT NULL,
                    url         TEXT    NOT NULL,
                    caption     TEXT    NOT NULL DEFAULT '',
                    title       TEXT,
                    thumb_file  TEXT    NOT NULL,
                    thumb_w     INTEGER NOT NULL,
                    thumb_h     INTEGER NOT NULL,
                    posted_at   TEXT    NOT NULL,
                    visible     INTEGER NOT NULL DEFAULT 1,
                    created_at  TEXT    NOT NULL DEFAULT (datetime('now','localtime')),
                    UNIQUE (platform, external_id)
                )"
            );
            self::$ready = true;
        }

        return $pdo;
    }

    /** Ordner der Vorschaubilder. Liegt außerhalb des Webroots. */
    public static function thumbDir(): string
    {
        return APP_ROOT . '/storage/videos';
    }

    /**
     * Übernimmt ein Video per Link. Gibt die neue Zeile zurück.
     * @throws RuntimeException mit einer Meldung für den Admin
     */
    public static function addFromTikTok(string $link): array
    {
        $daten = TikTok::fetch($link);

        if (self::findByExternal('tiktok', $daten['external_id'])) {
            throw new RuntimeException('Dieses Video steht schon in der Liste.');
        }

        $dir = self::thumbDir();
        if (!is_dir($dir) && !mkdir($dir, 0775, true) && !is_dir($dir)) {
            throw new RuntimeException('Der Ordner für die Vorschaubilder lässt sich nicht anlegen.');
        }
        $datei = 'tiktok-' . $daten['external_id'] . '.' . $daten['bild_typ'];
        if (file_put_contents($dir . '/' . $datei, $daten['bild']) === false) {
            throw new RuntimeException('Das Vorschaubild ließ sich nicht speichern.');
        }

        $pdo = self::db();
        $pdo->prepare(
            'INSERT INTO videos (platform, external_id, url, caption, thumb_file, thumb_w, thumb_h, posted_at)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?)'
        )->execute([
            'tiktok',
            $daten['external_id'],
            $daten['url'],
            $daten['caption'],
            $datei,
            $daten['breite'],
            $daten['hoehe'],
            TikTok::postedAt($daten['external_id'])->format('Y-m-d H:i:s'),
        ]);

        return self::find((int) $pdo->lastInsertId());
    }

    public static function find(int $id): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM videos WHERE id = ?');
        $stmt->execute([$id]);

        return $stmt->fetch() ?: null;
    }

    public static function findByExternal(string $platform, string $externalId): ?array
    {
        $stmt = self::db()->prepare('SELECT * FROM videos WHERE platform = ? AND external_id = ?');
        $stmt->execute([$platform, $externalId]);

        return $stmt->fetch() ?: null;
    }

    /** Alle, die neuesten zuerst – für den Admin. */
    public static function all(): array
    {
        return self::db()->query('SELECT * FROM videos ORDER BY posted_at DESC, id DESC')->fetchAll();
    }

    /**
     * Die sichtbaren für die Startseite. Wirft nie: Eine kaputte Videoliste
     * darf die Startseite nicht mitreißen, dann fehlt eben der Abschnitt.
     */
    public static function latestVisible(int $limit = self::HOME_LIMIT): array
    {
        try {
            $stmt = self::db()->prepare(
                'SELECT * FROM videos WHERE visible = 1 ORDER BY posted_at DESC, id DESC LIMIT ?'
            );
            $stmt->execute([$limit]);

            return $stmt->fetchAll();
        } catch (Throwable $e) {
            error_log('Video::latestVisible: ' . $e->getMessage());
            return [];
        }
    }

    /** Eigene Überschrift setzen. Leer heißt: wieder die Beschreibung von TikTok. */
    public static function updateTitle(int $id, string $title): void
    {
        $title = trim($title);
        self::db()->prepare('UPDATE videos SET title = ? WHERE id = ?')
            ->execute([$title === '' ? null : mb_substr($title, 0, 150), $id]);
    }

    public static function toggleVisible(int $id): void
    {
        self::db()->prepare('UPDATE videos SET visible = 1 - visible WHERE id = ?')->execute([$id]);
    }

    public static function delete(int $id): void
    {
        $video = self::find($id);
        if (!$video) {
            return;
        }
        self::db()->prepare('DELETE FROM videos WHERE id = ?')->execute([$id]);
        @unlink(self::thumbDir() . '/' . basename($video['thumb_file']));
    }

    /**
     * Was als Überschrift unter dem Bild steht: die eigene, sonst die
     * TikTok-Beschreibung ohne Hashtags, sonst ein neutraler Rückfall.
     */
    public static function displayTitle(array $video): string
    {
        $eigene = trim((string) ($video['title'] ?? ''));
        if ($eigene !== '') {
            return $eigene;
        }
        $text = TikTok::cleanCaption((string) $video['caption']);

        return $text !== '' ? $text : 'Video auf TikTok';
    }
}
