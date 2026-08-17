<?php
/**
 * NILS-DIGITAL CREDIT-BAND – Teil der ND-Signatur.
 *
 * Sichtbarer Hinweis auf die Urheberschaft, absichtlich NACH dem Abschluss-CTA
 * der Kundin platziert: Das Letzte, was über sie gesagt wird, bleibt ihr Angebot.
 * Das Band setzt sich optisch klar vom Kundeninhalt ab, damit niemand rätselt,
 * wessen Seite er gerade liest.
 *
 * Projektübergreifend identisch – nutzt nur Tokens aus theme.css und färbt sich
 * damit automatisch in die Farbwelt der jeweiligen Kundin ein.
 *
 * IN DIESEM PROJEKT NICHT EINGEBUNDEN, siehe layout.php. Die Datei liegt hier
 * als Vorlage. Neben dem Knopf stand ein zweiter Link „Wie es dazu kam →" auf
 * /meine-website; die Seite gibt es hier seit dem 17.08.2026 nicht mehr, also
 * ist der Link raus – sonst holt ihn sich der Nächste mitsamt einem 404 zurück.
 * Wo es die Referenzseite gibt, gehört er wieder in die nd-credit-actions.
 */
?>
<section class="nd-credit-band">
    <div class="container">
        <div class="nd-credit">
            <a class="nd-credit-brand" href="https://nils-digital.de" target="_blank" rel="noopener">
                <img class="nd-credit-mark" src="<?= asset('img/nils-digital-logo.png') ?>"
                     alt="" width="320" height="233" loading="lazy" decoding="async">
                <span class="nd-credit-word">Nils-Digital</span>
            </a>

            <div class="nd-credit-text">
                <h2>Diese Website wurde von Nils-Digital erstellt</h2>
                <p>
                    Websites für kleine Betriebe und Selbstständige – handgemacht,
                    schnell und ohne Baukasten. Gefällt dir, was du hier siehst?
                    Dann lass uns über deine Seite sprechen.
                </p>
            </div>

            <div class="nd-credit-actions">
                <a class="btn btn-primary" href="https://nils-digital.de"
                   target="_blank" rel="noopener">nils-digital.de</a>
            </div>
        </div>
    </div>
</section>
