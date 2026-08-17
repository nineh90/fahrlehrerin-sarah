<?php
/**
 * NILS-DIGITAL BANNER – Teil der ND-Signatur.
 *
 * Ein schmaler Streifen UNTERHALB des Fußes, auf jeder öffentlichen Seite.
 * Seit dem 17.08.2026 (Ticket SAR-32) der einzige Nils-Digital-Auftritt im
 * Seitengerüst: Davor gab es zwei – das große Credit-Band zwischen Inhalt und
 * Fuß (partials/nd-credit.php, liegt weiter im Ordner) und die Zeile „Gemacht
 * mit ♥ von Nils-Digital" unten im Fuß selbst.
 *
 * Warum unter und nicht im Fuß: Der Fuß gehört Sarah – ihr Logo, ihre Wege,
 * ihr Impressum. Was darunter steht, liest sich als Signatur des Handwerkers
 * und nicht als Teil ihres Angebots. Deshalb auch der helle Grund: Der Fuß
 * darüber ist dunkel, die Kante dazwischen macht sichtbar, wo ihre Seite
 * aufhört.
 *
 * Er steht jetzt auch dort, wo das alte Band bewusst schwieg – auf Login,
 * Terminkalender und „Meine Stunden". Das ist vertretbar, weil er nichts
 * verkauft und niemandem im Weg steht: eine Zeile am Ende, nach allem anderen.
 * Ein Werbeblock mitten im Eintragen einer Fahrstunde wäre etwas anderes.
 *
 * Projektübergreifend identisch – nutzt nur Tokens aus theme.css und färbt
 * sich damit automatisch in die Farbwelt der jeweiligen Kundin ein.
 */
?>
<aside class="nd-banner" aria-label="Hinweis zur Urheberschaft dieser Website">
    <div class="container nd-banner-inner">
        <a class="nd-banner-brand" href="https://nils-digital.de" target="_blank" rel="noopener">
            <?php /* alt="": Der Name steht direkt daneben im Text. Vorgelesen
                     wäre er sonst doppelt. */ ?>
            <img class="nd-banner-mark" src="<?= asset('img/nils-digital-logo.png') ?>"
                 alt="" width="320" height="233" loading="lazy" decoding="async">
            <span>Diese Website wurde von <strong>Nils-Digital</strong> erstellt</span>
        </a>

        <?php /* Zweites Ziel, nicht dasselbe noch einmal: Der Satz links führt
                 zu nils-digital.de, dieser Link zu Sarahs eigener Schilderung
                 auf /meine-website. Zwei Links nebeneinander auf dieselbe
                 Adresse bringen niemandem etwas. */ ?>
        <a class="nd-banner-more" href="<?= url('/meine-website') ?>">Wie es dazu kam &rarr;</a>
    </div>
</aside>
