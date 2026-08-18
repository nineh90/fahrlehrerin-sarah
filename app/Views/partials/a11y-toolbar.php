<?php
/**
 * BARRIEREFREIHEITS-LEISTE – Knopf am linken Rand plus Einstellungs-Panel.
 *
 * Übernommen aus „Kein Einzelfall" und auf diese Seite übertragen (SAR-34).
 *
 * Der Knopf ist ein fest an den linken Bildschirmrand geheftetes, senkrecht
 * mittiges Tab: auf jeder Seite und in jeder Scrollposition an derselben Stelle.
 * Im Quelltext steht er GLEICH HINTER dem Sprunglink – damit ist er der zweite
 * Tab-Stopp und für die Tastatur früh erreichbar, was zu seinem Zweck passt.
 *
 * Ein echter <button> mit aria-expanded und aria-controls, kein <div> mit
 * title-Attribut: sonst ist er nicht fokussierbar und hat keinen Namen.
 *
 * Sichtbarkeit über das HTML-Attribut `hidden` und nicht über eine CSS-Klasse.
 * Es wirkt auch, wenn die Stilvorlage nicht geladen hat, und ohne JavaScript
 * bleibt es gesetzt – was richtig ist, denn dann wäre das Panel ohnehin nicht
 * bedienbar. Die Bedienung sitzt in a11y.js und arbeitet ausschließlich über
 * data-Attribute; im Markup steht kein Zeilchen auswertbarer Code.
 *
 * Alle Beschriftungen kommen aus app/darstellung.php und stehen damit im
 * ausgelieferten HTML. Ein Panel, das erst JavaScript zusammenbaut, ist für
 * einen Screenreader vor dem Ausführen des Skripts nicht vorhanden.
 */
$optionen = require APP_ROOT . '/app/darstellung.php';
$optionen = $optionen['optionen'];
?>
<button type="button" class="rand-tab a11y-tab" data-a11y-oeffnen
        aria-expanded="false" aria-controls="a11y-panel">
    <?= icon('accessibility') ?>
    <?php /* SICHTBARES LABEL BEI HOVER UND TASTATURFOKUS (SAR-36).
             Vorher stand hier nur `sr-only`: Für Vorlesesoftware war der Knopf
             benannt, wer ihn SAH, musste das Zeichen deuten. Bewusst kein
             title-Attribut – das erscheint nur bei der Maus, nicht bei der
             Tastatur und nicht auf dem Touchscreen, und Screenreader lesen es
             gern zusätzlich zum Namen vor, also doppelt.

             Der lange Satz bleibt für die Vorlesesoftware, sichtbar wird nur
             ein kurzes Wort – ein Reiter am Bildschirmrand hat keinen Platz
             für einen Satz. Beides steht in EINEM Element, damit der Name des
             Knopfs an einer Stelle steht und nicht an zwei. */ ?>
    <span class="rand-tab-name">Darstellung<span class="sr-only"> und Barrierefreiheit einstellen</span></span>
    <?php /* Der Zähler zeigt, DASS Einstellungen aktiv sind. Ohne ihn wundert man
             sich auf einem fremden oder länger nicht benutzten Gerät über das
             veränderte Aussehen und findet die Ursache nicht. */ ?>
    <span class="a11y-zaehler" data-a11y-zaehler hidden></span>
</button>

<div class="a11y-panel" id="a11y-panel" hidden role="dialog" aria-labelledby="a11y-titel">
    <div class="a11y-panel-kopf">
        <?php /* Bewusst kein <h2>: Die Leiste steht im Quelltext vor der <h1> der
                 Seite. Als Überschrift ausgezeichnet würde sie die Gliederung des
                 Dokuments anführen und Screenreader in die Irre schicken. Über
                 aria-labelledby ist der Dialog trotzdem sauber benannt. */ ?>
        <p class="a11y-titel" id="a11y-titel">Darstellung</p>
        <button type="button" class="a11y-schliessen" data-a11y-schliessen>
            <span class="sr-only">Einstellungen schließen</span>
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <?php foreach ($optionen as $schluessel => $opt): ?>
        <div class="a11y-gruppe">
            <?php if ($opt['typ'] === 'schalter'): ?>
                <button type="button" class="a11y-schalter"
                        data-a11y-umschalten="<?= e($schluessel) ?>" aria-pressed="false">
                    <span><?= e($opt['label']) ?></span>
                    <span class="a11y-schalter-spur" aria-hidden="true"><span></span></span>
                </button>
            <?php else: ?>
                <p class="a11y-label" id="a11y-<?= e($schluessel) ?>-label"><?= e($opt['label']) ?></p>
                <div class="a11y-stufen" role="group" aria-labelledby="a11y-<?= e($schluessel) ?>-label">
                    <?php foreach ($opt['werte'] as $eintrag): ?>
                        <button type="button" class="a11y-stufe"
                                data-a11y-setzen="<?= e($schluessel) ?>"
                                data-a11y-wert="<?= e((string) $eintrag['wert']) ?>"
                                <?= $opt['typ'] === 'stufen' ? 'data-a11y-zahl' : '' ?>
                                aria-pressed="false"><?= e($eintrag['label']) ?></button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>

    <button type="button" class="a11y-reset" data-a11y-zuruecksetzen>Alles zurücksetzen</button>

    <p class="a11y-hinweis">
        Die Einstellungen bleiben auf diesem Gerät gespeichert und gehen an
        niemanden weiter.
        <a href="<?= url('/datenschutz') ?>#darstellung">Was gespeichert wird</a>
    </p>
</div>

<?php /* Die Leselinie. Das Element hängt immer im Dokument, sichtbar ist es nur,
         wenn die Option gesetzt ist (Regel in a11y.css). So braucht das Skript
         nichts zu erzeugen und der Zeiger-Listener kann bedingungslos hängen. */ ?>
<div id="leselinie" aria-hidden="true"></div>
