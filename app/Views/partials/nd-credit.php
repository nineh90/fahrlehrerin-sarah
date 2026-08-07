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
                <h2>Diese Website wurde von Nils-Digital gebaut</h2>
                <p>
                    Websites für kleine Betriebe und Selbstständige – handgemacht,
                    schnell und ohne Baukasten. Gefällt dir, was du hier siehst?
                    Dann lass uns über deine Seite sprechen.
                </p>
            </div>

            <div class="nd-credit-actions">
                <a class="btn btn-primary" href="https://nils-digital.de"
                   target="_blank" rel="noopener">nils-digital.de</a>
                <a class="link-more" href="<?= url('/meine-website') ?>">Wie es dazu kam &rarr;</a>
            </div>
        </div>
    </div>
</section>
