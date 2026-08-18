<?php
/**
 * SARAHS KANÄLE ALS FESTE LEISTE AM LINKEN RAND (SAR-36).
 *
 * Sie sitzen dort, wo auch der Barrierefreiheits-Knopf klebt, und bilden mit ihm
 * optisch eine Spalte. Die Ausrichtung läuft über `--rand-tab-h` in theme.css –
 * beide Bausteine lesen dieselbe Zahl, damit sie nicht auseinanderrutschen.
 *
 * WARUM DAS MARKUP TROTZDEM WEIT UNTEN IM DOKUMENT STEHT und nicht neben dem
 * Barrierefreiheits-Knopf: Der ist mit Absicht der zweite Tab-Stopp der Seite –
 * wer ihn braucht, soll ihn nicht suchen. Zwei Links auf fremde Plattformen
 * haben diesen Rang nicht. Vor der eigenen Navigation eingehängt wären sie das
 * Erste, was eine Vorlesesoftware nach dem Sprunglink anbietet: „TikTok,
 * Instagram" – und dann erst die Seite. Deshalb steht die Leiste am Ende des
 * Körpers und ist damit der LETZTE Tab-Stopp. Wo sie zu sehen ist, entscheidet
 * das CSS; in welcher Reihenfolge sie bedient wird, entscheidet das Markup.
 *
 * Die Adressen kommen aus der Konfiguration (TIKTOK_HANDLE, INSTAGRAM_HANDLE in
 * der .env) – dieselben Ziele wie im Fuß, auf /kontakt und im TikTok-Band der
 * Startseite. Ändert Sarah einen Handle, ändert sie ihn an einer Stelle.
 */
?>
<nav class="social-rail" aria-label="Sarah auf Social Media">
    <?php /* Der Name jedes Reiters steht in EINEM Element und ist zweigeteilt:
             sichtbar der kurze Plattformname, unsichtbar der Rest. Sichtbar wird
             er bei Hover UND bei Tastaturfokus (Regel in theme.css) – vorher war
             er nur für Vorlesesoftware da, und wer das Zeichen sah, musste raten.

             Bewusst kein title-Attribut: Das erscheint nur bei der Maus, nicht
             bei der Tastatur und nicht auf dem Touchscreen, und Screenreader
             lesen es gern zusätzlich zum Namen vor, also doppelt.

             „öffnet in neuem Tab" gehört in den Namen, weil target="_blank" den
             Besucher aus der Seite trägt, ohne ihn zu fragen. Sichtbar steht es
             nicht da – ein Reiter am Bildschirmrand hat für den Satz keinen
             Platz, und für die Maus verrät es die Statusleiste ohnehin. */ ?>
    <a class="rand-tab social-rail-tab" href="<?= e(tiktok_url()) ?>"
       target="_blank" rel="noopener noreferrer">
        <?= icon('tiktok') ?>
        <span class="rand-tab-name">TikTok<span class="sr-only"> – Sarahs Kanal, öffnet in neuem Tab</span></span>
    </a>
    <a class="rand-tab social-rail-tab" href="<?= e(instagram_url()) ?>"
       target="_blank" rel="noopener noreferrer">
        <?= icon('instagram') ?>
        <span class="rand-tab-name">Instagram<span class="sr-only"> – Sarahs Kanal, öffnet in neuem Tab</span></span>
    </a>
</nav>
