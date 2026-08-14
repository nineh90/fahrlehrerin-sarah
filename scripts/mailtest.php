<?php
declare(strict_types=1);

/**
 * Versand einmal ausprobieren, ohne eine Buchung auszulösen.
 *
 *   php scripts/mailtest.php empfaenger@example.de
 *
 * Auf dem Server läuft PHP im Container, also von /docker/fahrlehrerin-sarah:
 *
 *   docker compose -f deploy/docker-compose.yml exec app \
 *       php scripts/mailtest.php empfaenger@example.de
 *
 * Zeigt vorher, womit gesendet wird. Das Passwort wird dabei NICHT ausgegeben,
 * nur ob eines gesetzt ist – die Ausgabe landet sonst irgendwann in einem
 * Ticket oder einem Chat.
 */

require __DIR__ . '/../app/config.php';
require __DIR__ . '/../app/Mailer.php';

$empfaenger = $argv[1] ?? '';

if ($empfaenger === '') {
    fwrite(STDERR, "Aufruf: php scripts/mailtest.php empfaenger@example.de\n");
    exit(1);
}

$treiber = (string) config('mail.driver');

echo "Versand-Einstellungen\n";
echo str_repeat('-', 60) . "\n";
printf("  Treiber      %s\n", $treiber);
printf("  Absender     %s\n", (string) config('mail.from'));

$antwortAn = (string) config('mail.reply_to', '');
if ($antwortAn !== '') {
    printf("  Antwort an   %s\n", $antwortAn);
}

if ($treiber === 'smtp') {
    printf("  Server       %s:%d\n", (string) config('mail.smtp.host'), (int) config('mail.smtp.port'));
    printf("  Verfahren    %s\n", (string) config('mail.smtp.security'));
    printf("  Benutzer     %s\n", (string) config('mail.smtp.user'));
    printf("  Passwort     %s\n", config('mail.smtp.password') !== '' ? 'gesetzt' : 'FEHLT');
}

printf("  Empfänger    %s\n", $empfaenger);
echo str_repeat('-', 60) . "\n\n";

if ($treiber === 'log') {
    echo "Hinweis: Treiber ist 'log' – es wird nur nach storage/mail.log geschrieben,\n";
    echo "         es geht nichts wirklich raus. Für einen echten Test MAIL_DRIVER=smtp.\n\n";
}

// Umlaute mit Absicht: Genau daran zeigt sich, ob der Betreff richtig
// kodiert ankommt. Steht im Postfach "M?ller" oder wirres Zeug, stimmt
// etwas mit der Kopfzeilen-Kodierung nicht.
$betreff = 'Testmail von fahrlehrerinsarah.de – Grüße für Müller';
$text    = "Diese Nachricht kommt von scripts/mailtest.php.\n\n"
    . "Wenn sie lesbar ankommt – Betreff mit Umlauten, Text mit Umlauten:\n"
    . "Fahrstunde, Grüße, Straße, Prüfung – dann stimmt die Kodierung.\n\n"
    . 'Gesendet am ' . date('d.m.Y \u\m H:i:s') . " Uhr.\n";

$start = microtime(true);
$ok    = Mailer::send($empfaenger, $betreff, $text);
$dauer = round((microtime(true) - $start) * 1000);

if ($ok) {
    printf("✓ Rausgegangen (%d ms).\n", $dauer);
    if ($treiber === 'log') {
        echo "  Nachsehen in storage/mail.log.\n";
    } else {
        echo "  Jetzt im Postfach nachsehen – auch im Spam-Ordner.\n";
    }
    exit(0);
}

printf("✗ Fehlgeschlagen (%d ms).\n", $dauer);
printf("  Grund: %s\n", Mailer::lastError());
exit(1);
