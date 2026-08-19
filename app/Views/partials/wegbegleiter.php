<?php
/* WEGBEGLEITER: die Logo-Reihe ganz unten auf der Startseite.
 *
 * Steht NUR hier und nicht im Layout: Es ist ein Abschnitt der Startseite,
 * keine Fußzeile. Auf jeder Unterseite mitzulaufen hieße, unter Sarahs
 * Infoseiten fremde Logos zu setzen, und auf der Seite eines Wegbegleiters
 * stünde er unter sich selbst.
 *
 * Ganz unten und nicht weiter oben, weil die Reihenfolge eine Aussage ist:
 * Erst Sarahs Angebot, dann ihr Abschluss-CTA, dann die Betriebe, die dahinter
 * stehen. Ein Logo-Band im oberen Drittel liest sich wie Sponsoring.
 *
 * NUR ÜBERSCHRIFT UND LOGO, sonst nichts (Kevin, 19.08.2026). Hier standen bis
 * dahin eine grüne Versalzeile „WEGBEGLEITER" über der Überschrift, ein
 * Einordnungssatz und in jeder Kachel Rolle, Name und ein Satz zum Betrieb.
 * Das war eine dritte Selbstauskunft kurz vor dem Fuß; direkt darunter sagt
 * `site-note.php` ohnehin, dass Sarah angestellt ist. Die Erklärung, wer der
 * Betrieb ist, gehört auf seine Unterseite und nicht in die Kachel davor.
 *
 * Die Überschrift heißt seither „Wegbegleiter" und nicht mehr „Mit wem ich
 * zusammenarbeite": Das Wort stand vorher als Versalzeile darüber und ist
 * Sarahs eigenes. Es soll die Überschrift sein und nicht ihre Beschriftung.
 *
 * DESHALB TRÄGT DAS LOGO JETZT EINEN ECHTEN alt-TEXT. Vorher war er leer, weil
 * der Name als Text daneben stand; ohne diesen Text wäre der Link für
 * Vorlesesoftware namenlos, also ein „Link" ohne Ziel. Der Name im alt ist das,
 * was der Link heißt.
 */
$wegbegleiter = Partners::all();
?>
<?php if ($wegbegleiter !== []): ?>
<section class="section section--alt" id="wegbegleiter">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <h2>Wegbegleiter</h2>
            </div>
        </div>

        <ul class="partner-grid">
            <?php foreach ($wegbegleiter as $slug => $partner): ?>
                <li>
                    <a class="partner-card" href="<?= e(Partners::path($slug)) ?>">
                        <img class="partner-logo"
                             src="<?= asset('img/' . $partner['logo']) ?>"
                             alt="<?= e($partner['name']) ?>"
                             width="<?= (int) $partner['logo_width'] ?>"
                             height="<?= (int) $partner['logo_height'] ?>"
                             loading="lazy" decoding="async">
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php endif; ?>
