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
 * Das war eine dritte Selbstauskunft kurz vor dem Fuß; darunter sagte damals
 * `site-note.php` ohnehin, dass Sarah angestellt ist (die Fußnote ist am
 * 22.08.2026 von allen Seiten entfallen). Die Erklärung, wer der Betrieb ist,
 * gehört auf seine Unterseite und nicht in die Kachel davor.
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

        <?php /* DIE GRÖSSE DER KACHELN HÄNGT NICHT MEHR AN DIESER ZEILE:
                 Seit dem 21.08.2026 (SAR-75) sind alle gleich breit und gleich
                 hoch, egal wie viele in ihrer Zeile stehen. Hier stand vorher
                 ein Modifier, der genau das für fünf Kacheln herstellte; er ist
                 entfallen, weil es jetzt für jede Anzahl gilt.

                 GEBLIEBEN IST DIE FRAGE, WIE DIE ZEILEN AUFGEHEN. Normal
                 stehen drei nebeneinander. Bleibt danach genau eine übrig,
                 steht sie allein in der letzten Zeile – bei 4, 7 oder 10
                 Wegbegleitern, also immer dann, wenn die Anzahl durch drei
                 geteilt den Rest 1 lässt. Dann rücken vier in die Zeile: aus
                 3 + 1 wird 4, aus 3 + 3 + 1 wird 4 + 3.

                 Die Rechnung steht hier und nicht im CSS, weil CSS die Anzahl
                 der Kacheln nicht kennt. Was der Modifier tut, steht bei
                 `.partner-grid--cols-4` in nd-base.css. */ ?>
        <ul class="partner-grid<?= count($wegbegleiter) % 3 === 1 ? ' partner-grid--cols-4' : '' ?>">
            <?php foreach ($wegbegleiter as $slug => $partner): ?>
                <li>
                    <?php /* SEIT SAR-102 (30.08.2026) FÜHREN DIE MEISTEN KACHELN
                             NACH DRAUSSEN, nur Nils-Digital hat noch eine eigene
                             Unterseite. `Partners::path()` entscheidet das, die
                             Kachel fragt nur nach.

                             Externe Ziele öffnen in einem neuen Tab, damit
                             Sarahs Seite dabei offen bleibt – dieselbe
                             Entscheidung wie beim Fahrschul-Knopf im Menü. Der
                             Pfeil ist `aria-hidden`, weil Vorlesesoftware ihn
                             sonst als „Nordostpfeil" ansagt; was er bedeutet,
                             steht als Text daneben und nur für sie. */ ?>
                    <?php $extern = !Partners::seite($slug); ?>
                    <a class="partner-card" href="<?= e(Partners::path($slug)) ?>"<?= $extern ? ' target="_blank" rel="noopener"' : '' ?>>
                        <?php /* Die Klasse kommt aus `Partners`, weil sie von den
                                 Maßen der Datei abhängt und nicht von der Seite:
                                 Quadratische Marken bekommen mehr Höhe als
                                 Wortmarken, sonst stehen sie verloren daneben.
                                 Die Unterseiten fragen dieselbe Stelle. */ ?>
                        <img class="<?= e(Partners::logoClass($partner, 'partner-logo')) ?>"<?= Partners::logoPlateAttr($partner) ?>
                             src="<?= asset('img/' . $partner['logo']) ?>"
                             alt="<?= e($partner['name']) ?>"
                             width="<?= (int) $partner['logo_width'] ?>"
                             height="<?= (int) $partner['logo_height'] ?>"
                             loading="lazy" decoding="async">
                        <?php /* DER SATZ ZUM ÜBERFAHREN (Nils, 21.08.2026). Er liegt
                                 IMMER im Markup und wird nur nicht angezeigt – das
                                 ist der Unterschied zu einem `title`-Attribut, das
                                 kein Touchgerät und keine Tastatur je zu sehen
                                 bekommt. So gehört er zum Namen des Links: Wer die
                                 Seite vorlesen lässt, hört „Fahrschule Sander,
                                 meine Fahrschule" statt nur den Namen.

                                 Sichtbar wird er beim Überfahren und beim
                                 Tastatur-Fokus, siehe `.partner-hint` in
                                 nd-base.css. */ ?>
                        <?php $hint = trim((string) ($partner['hint'] ?? '')); ?>
                        <?php if ($hint !== ''): ?>
                            <span class="partner-hint"><?= e($hint) ?></span>
                        <?php endif; ?>
                        <?php if ($extern): ?>
                            <?php /* Ohne den Namen: Der steht schon im alt-Text des
                                     Logos, und der Name des Links setzt sich aus
                                     beidem zusammen – sonst hört man ihn zweimal.
                                     Wortlaut wie im Menü bei der Fahrschule. */ ?>
                            <span class="sr-only"> – öffnet in neuem Tab</span>
                        <?php endif; ?>
                    </a>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
<?php endif; ?>
