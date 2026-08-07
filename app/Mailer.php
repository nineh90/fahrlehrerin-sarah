<?php
declare(strict_types=1);

/**
 * Sehr einfacher Mail-Versand.
 *
 * MAIL_DRIVER=log  -> schreibt nach storage/mail.log (Demo-Betrieb, kein echter Versand)
 * MAIL_DRIVER=mail -> PHP mail() (Produktion)
 *
 * Absichtlich schlank gehalten: sobald echte Bestätigungsmails gebraucht werden,
 * wird hier auf SMTP umgestellt – die Aufrufer bleiben unverändert.
 */
final class Mailer
{
    public static function send(string $to, string $subject, string $body): bool
    {
        $from    = (string) config('mail.from');
        $headers = "From: $from\r\n"
            . "Content-Type: text/plain; charset=UTF-8\r\n";

        if (config('mail.driver') === 'mail') {
            return @mail($to, $subject, $body, $headers);
        }

        $entry = sprintf(
            "[%s] An: %s | Betreff: %s\n%s\n%s\n\n",
            date('Y-m-d H:i:s'),
            $to,
            $subject,
            str_repeat('-', 60),
            $body
        );

        return (bool) @file_put_contents(APP_ROOT . '/storage/mail.log', $entry, FILE_APPEND);
    }
}
