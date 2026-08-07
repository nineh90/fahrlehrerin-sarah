<?php
declare(strict_types=1);

/**
 * Sarahs Posteingang: was sich an ihren Stunden getan hat.
 * Geschrieben wird hier nichts – das macht ausschließlich der Notifier.
 */
final class AdminNotificationController
{
    public function index(): void
    {
        Auth::require();

        $onlyUnread = ($_GET['filter'] ?? '') === 'neu';

        render('admin/benachrichtigungen/index', [
            'title'         => 'Benachrichtigungen',
            'notifications' => Notification::recent(50, $onlyUnread),
            'onlyUnread'    => $onlyUnread,
            'unread'        => Notification::unreadCount(),
        ], 'admin/layout');
    }

    /** Eine einzelne Meldung abhaken. */
    public function markRead(string $id): void
    {
        Auth::require();
        verify_csrf();

        Notification::markRead((int) $id);

        redirect('/admin/benachrichtigungen');
    }

    /** Alles abhaken. */
    public function markAllRead(): void
    {
        Auth::require();
        verify_csrf();

        $count = Notification::markAllRead();
        set_flash('success', $count === 1
            ? 'Eine Meldung als gelesen markiert.'
            : sprintf('%d Meldungen als gelesen markiert.', $count));

        redirect('/admin/benachrichtigungen');
    }
}
