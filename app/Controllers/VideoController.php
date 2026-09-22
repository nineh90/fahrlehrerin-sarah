<?php
declare(strict_types=1);

/**
 * Liefert die Vorschaubilder der Videos aus storage/videos/ aus (SAR-129).
 *
 * Die Bilder liegen nicht in public/, weil der Container nur storage/
 * beschreiben darf. Der Umweg über PHP kostet bei vier Bildern nichts, und
 * der lange Cache sorgt dafür, dass er pro Besucher nur einmal anfällt.
 */
final class VideoController
{
    private const TYPEN = ['jpg' => 'image/jpeg', 'webp' => 'image/webp', 'png' => 'image/png'];

    public function thumb(string $id): void
    {
        $video = ctype_digit($id) ? Video::find((int) $id) : null;
        $datei = $video ? Video::thumbDir() . '/' . basename($video['thumb_file']) : '';
        $typ   = self::TYPEN[pathinfo($datei, PATHINFO_EXTENSION)] ?? null;

        if (!$video || !$typ || !is_file($datei)) {
            http_response_code(404);
            header('Content-Type: text/plain; charset=utf-8');
            echo 'Nicht gefunden.';
            return;
        }

        header('Content-Type: ' . $typ);
        header('Content-Length: ' . filesize($datei));
        header('Cache-Control: public, max-age=2592000');
        readfile($datei);
    }
}
