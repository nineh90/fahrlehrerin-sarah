<?php
declare(strict_types=1);

/**
 * Front Controller – Einstiegspunkt für alle Requests.
 *
 * Neue Seite hinzufügen: hier eine Route registrieren, Controller-Methode
 * ergänzen, View unter app/Views/ anlegen. Mehr braucht es nicht.
 */

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/helpers.php';

// Einfacher Autoloader für app/ (Klassen, auch in Unterordnern Controllers/, Models/).
spl_autoload_register(static function (string $class): void {
    foreach (['', 'Controllers/', 'Controllers/Admin/', 'Models/'] as $dir) {
        $file = APP_ROOT . '/app/' . $dir . $class . '.php';
        if (is_file($file)) {
            require $file;
            return;
        }
    }
});

ensure_session();

$router = new Router();

// ---------------------------------------------------------------------------
// Öffentliche Seiten
// ---------------------------------------------------------------------------
$router->get('/',                    [HomeController::class, 'index']);
$router->get('/ueber-mich',          [PageController::class, 'about']);
$router->get('/fahren-mit-handicap', [PageController::class, 'handicap']);
$router->get('/kontakt',             [PageController::class, 'contact']);
/* Die Wegbegleiter – eine Route für alle. Der Slug wird in app/Partners.php
   nachgeschlagen, unbekannte enden mit 404. Eine Übersichtsseite unter
   /wegbegleiter gibt es bewusst nicht: Die Übersicht ist der Abschnitt unten
   auf der Startseite. */
$router->get('/wegbegleiter/{slug}', [PartnerController::class, 'show']);
$router->get('/impressum',           [PageController::class, 'impressum']);
$router->get('/datenschutz',         [PageController::class, 'datenschutz']);
$router->get('/robots.txt',          [RobotsController::class, 'index']);

// ---------------------------------------------------------------------------
// Schüler-Bereich: Login + Terminbuchung
// ---------------------------------------------------------------------------
$router->get('/login',   [StudentAuthController::class, 'showLogin']);
$router->post('/login',  [StudentAuthController::class, 'login']);
$router->post('/logout', [StudentAuthController::class, 'logout']);

$router->get('/termine',                [SlotController::class, 'index']);
$router->post('/termine/{id}/buchen',   [BookingController::class, 'store']);

$router->get('/meine-termine',                 [BookingController::class, 'index']);
$router->post('/buchung/{id}/stornieren',      [BookingController::class, 'cancel']);
$router->get('/buchung/{id}/verschieben',      [BookingController::class, 'showReschedule']);
$router->post('/buchung/{id}/verschieben',     [BookingController::class, 'reschedule']);

// ---------------------------------------------------------------------------
// Admin-Bereich (Sarah)
// ---------------------------------------------------------------------------
$router->get('/admin/login',   [AdminAuthController::class, 'showLogin']);
$router->post('/admin/login',  [AdminAuthController::class, 'login']);
$router->post('/admin/logout', [AdminAuthController::class, 'logout']);

$router->get('/admin', [AdminDashboardController::class, 'index']);

$router->get('/admin/passwort',  [AdminAccountController::class, 'edit']);
$router->post('/admin/passwort', [AdminAccountController::class, 'update']);

$router->get('/admin/termine',                 [AdminSlotController::class, 'index']);
$router->get('/admin/termine/neu',             [AdminSlotController::class, 'create']);
$router->post('/admin/termine',                [AdminSlotController::class, 'store']);
$router->get('/admin/termine/serie',           [AdminSlotController::class, 'createSeries']);
$router->post('/admin/termine/serie',          [AdminSlotController::class, 'storeSeries']);
$router->post('/admin/termine/{id}/loeschen',  [AdminSlotController::class, 'destroy']);
$router->post('/admin/termine/{id}/sperren',   [AdminSlotController::class, 'toggleBlocked']);
$router->post('/admin/termine/{id}/zuweisen',  [AdminSlotController::class, 'assign']);

$router->get('/admin/schueler',                [AdminStudentController::class, 'index']);
$router->get('/admin/schueler/neu',            [AdminStudentController::class, 'create']);
$router->post('/admin/schueler',               [AdminStudentController::class, 'store']);
$router->get('/admin/schueler/{id}/bearbeiten', [AdminStudentController::class, 'edit']);
$router->post('/admin/schueler/{id}',          [AdminStudentController::class, 'update']);
$router->post('/admin/schueler/{id}/pin',      [AdminStudentController::class, 'resetPin']);
$router->post('/admin/schueler/{id}/loeschen', [AdminStudentController::class, 'destroy']);

$router->get('/admin/buchungen',                    [AdminBookingController::class, 'index']);
$router->post('/admin/buchungen/{id}/stornieren',   [AdminBookingController::class, 'cancel']);

$router->get('/admin/benachrichtigungen',                  [AdminNotificationController::class, 'index']);
$router->post('/admin/benachrichtigungen/gelesen',         [AdminNotificationController::class, 'markAllRead']);
$router->post('/admin/benachrichtigungen/{id}/gelesen',    [AdminNotificationController::class, 'markRead']);

try {
    $router->dispatch();
} catch (Throwable $e) {
    if (config('app_debug')) {
        http_response_code(500);
        header('Content-Type: text/plain; charset=utf-8');
        echo 'Fehler: ' . $e->getMessage() . "\n\n" . $e->getTraceAsString();
    } else {
        error_log($e->getMessage());
        http_response_code(500);
        render('errors/500', ['title' => 'Serverfehler']);
    }
}
