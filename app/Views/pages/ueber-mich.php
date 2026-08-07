<?php $school = (string) config('school.name'); ?>

<?php /* Hero im Stil der Startseite, aber bewusst NICHT dasselbe Lockup:
         Dort steht die Wortmarke im Bogen, hier steht Sarah drin. Der Name
         steht schon im Header und in der Überschrift – ein zweites Mal wäre
         Logo-Doppelung. Anderer Ausschnitt derselben Aufnahme, damit die
         beiden Seiten nicht wie eine Kopie voneinander wirken. */ ?>
<section class="hero">
    <div class="container hero-inner">
        <div class="duo duo--narrow-media">
            <div class="hero-content">
                <h1>Hallo,<br>ich bin Sarah.</h1>
                <p class="hero-lead">
                    Fahren lernt man nicht durch Druck, sondern durch Wiederholung –
                    und durch das Gefühl, dass einem jemand etwas zutraut.
                </p>
                <p class="hero-meta">
                    <?= icon('pin') ?>
                    <span>Unterwegs in <?= e(area_sentence()) ?></span>
                </p>
                <div class="hero-actions">
                    <a class="btn btn-primary btn-lg" href="<?= url('/termine') ?>">Meine freien Zeiten</a>
                    <a class="btn btn-ghost btn-lg" href="<?= url('/kontakt') ?>">Schreib mir</a>
                </div>
            </div>

            <div class="duo-media">
                <div class="hero-arc">
                    <img src="<?= asset('img/sarah-lockup.webp') ?>"
                         alt="Sarah, lächelnd, mit hochgestrecktem Daumen"
                         width="620" height="1130">
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo duo--text-first">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-orange);">
                <figure class="photo">
                    <img src="<?= asset('img/sarah-messe.jpg') ?>"
                         alt="Sarah an einem Messestand, lächelnd, mit hochgestrecktem Daumen"
                         width="640" height="800">
                    <figcaption>Auf einer Messe für Mobilität und Reha</figcaption>
                </figure>
            </div>

            <div class="duo-text">
                <h2>Wie ich dazu gekommen bin</h2>
                <p>
                    Ich bin Fahrlehrerin für die Klassen B und BE und unterrichte rund um
                    <?= e(area_sentence()) ?>.
                    Angestellt<?= $school !== '' ? ' bei der ' . school_link() : '' ?>, nicht
                    selbstständig – diese Seite ist mein persönliches Schaufenster, keine
                    Fahrschul-Website.
                </p>
                <p>
                    Neben dem normalen Führerschein bilde ich Menschen mit Handicap aus.
                    Das kam nicht durch einen Lehrgang, sondern weil jemand vor mir saß,
                    dem drei andere abgesagt hatten. Seitdem ist es der Teil meiner Arbeit,
                    auf den ich am meisten Lust habe.
                </p>

                <ul class="facts">
                    <li>
                        <?= icon('car') ?>
                        <span>
                            <strong>Klasse B und BE</strong>
                            <span>PKW und Gespanne – inklusive Anhänger-Rangieren</span>
                        </span>
                    </li>
                    <li>
                        <?= icon('shield') ?>
                        <span>
                            <strong>Ausbildung mit Handicap</strong>
                            <span>Prothese, Lenkhilfe, Handbedienung für Gas und Bremse</span>
                        </span>
                    </li>
                    <li>
                        <?= icon('pin') ?>
                        <span>
                            <strong>Unterwegs in</strong>
                            <span><?= e(implode(' · ', config('contact.area'))) ?></span>
                        </span>
                    </li>
                    <li>
                        <?= icon('chat') ?>
                        <span>
                            <strong>Auch online</strong>
                            <span>Auf TikTok und Instagram zeige ich, wie der Alltag aussieht</span>
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="section section--alt">
    <div class="container">
        <blockquote class="quote">
            <p>
                „Ich sage niemandem, dass es leicht wird. Aber ich sage auch niemandem,
                dass es nicht geht, bevor wir es nicht probiert haben."
            </p>
            <footer>Sarah</footer>
        </blockquote>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-blue);">
                <figure class="photo photo--right photo--cutout">
                    <img src="<?= asset('img/fahrschulauto.webp') ?>"
                         alt="Das Fahrschulauto: ein weißer VW T-Roc"
                         width="1200" height="637" loading="lazy" decoding="async">
                    <figcaption>Das Auto, in dem wir unterwegs sind</figcaption>
                </figure>
            </div>

            <div class="duo-text">
                <h2>Wie eine Stunde bei mir abläuft</h2>
                <p>
                    Zu Beginn sagen wir beide, was heute dran ist – du, was du üben willst,
                    ich, was ich für nötig halte. Am Ende bekommst du eine ehrliche
                    Einschätzung: was saß, was noch nicht, und was wir beim nächsten Mal
                    machen.
                </p>
                <p>
                    Ich rede während der Fahrt wenig, aber früh. Lieber eine Ansage zwei
                    Sekunden vorher als ein Kommentar hinterher.
                </p>
                <ul class="check-list">
                    <li>Klare Ansagen, kein Anschreien</li>
                    <li>Feste Ansprechpartnerin – du fährst immer mit mir</li>
                    <li>Ehrliche Rückmeldung zu deinem Stand</li>
                    <li>Termine, die zu Schule, Ausbildung oder Schicht passen</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section class="cta-band">
    <div class="container">
        <div class="cta-inner">
            <div class="cta-text">
                <h2>Klingt nach dir?</h2>
                <p>Dann melde dich – am besten kurz telefonisch, das geht am schnellsten.</p>
            </div>
            <a class="btn btn-primary btn-lg" href="<?= url('/kontakt') ?>">Kontakt</a>
        </div>
    </div>
</section>
