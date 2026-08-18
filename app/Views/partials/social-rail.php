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
    <?php /* „(öffnet TikTok)" statt nur „TikTok": Der Link führt von der Seite
             weg, und das gehört in den Namen. Sichtbar ist nur das Zeichen –
             deshalb trägt jeder Link seinen Namen als sr-only-Text und das
             Zeichen selbst ist aria-hidden (das macht icon() von sich aus). */ ?>
    <a class="social-rail-tab" href="<?= e(tiktok_url()) ?>"
       target="_blank" rel="noopener noreferrer">
        <span class="sr-only">Sarah auf TikTok (öffnet in neuem Tab)</span>
        <?= icon('tiktok') ?>
    </a>
    <a class="social-rail-tab" href="<?= e(instagram_url()) ?>"
       target="_blank" rel="noopener noreferrer">
        <span class="sr-only">Sarah auf Instagram (öffnet in neuem Tab)</span>
        <?= icon('instagram') ?>
    </a>
</nav>
