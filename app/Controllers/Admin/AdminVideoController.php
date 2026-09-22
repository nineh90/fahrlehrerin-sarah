<?php
declare(strict_types=1);

/**
 * Videos für die Startseite (SAR-129): per TikTok-Link eintragen,
 * ausblenden, umbenennen, löschen.
 */
final class AdminVideoController
{
    public function index(): void
    {
        Auth::require();

        render('admin/videos/index', [
            'title'  => 'Videos',
            'videos' => Video::all(),
        ], 'admin/layout');
    }

    public function store(): void
    {
        Auth::require();
        verify_csrf();

        try {
            $video = Video::addFromTikTok((string) ($_POST['link'] ?? ''));
            set_flash('success', $video['visible']
                ? 'Übernommen – das Video steht jetzt auf der Startseite.'
                : 'Übernommen.');
        } catch (RuntimeException $e) {
            set_flash('error', $e->getMessage());
        }

        redirect('/admin/videos');
    }

    public function update(string $id): void
    {
        Auth::require();
        verify_csrf();

        Video::updateTitle((int) $id, (string) ($_POST['title'] ?? ''));
        set_flash('success', 'Überschrift gespeichert.');

        redirect('/admin/videos');
    }

    public function toggle(string $id): void
    {
        Auth::require();
        verify_csrf();

        Video::toggleVisible((int) $id);

        redirect('/admin/videos');
    }

    public function destroy(string $id): void
    {
        Auth::require();
        verify_csrf();

        Video::delete((int) $id);
        set_flash('success', 'Video entfernt. Auf TikTok bleibt es natürlich stehen.');

        redirect('/admin/videos');
    }
}
