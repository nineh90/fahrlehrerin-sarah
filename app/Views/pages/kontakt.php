<?php $school = (string) config('school.name'); ?>
<section class="page-head">
    <div class="container">
        <h1>Kontakt</h1>
        <p class="page-lead">
            Am schnellsten geht ein Anruf. Wenn ich gerade fahre, gehe ich nicht ran –
            schreib mir dann einfach, ich melde mich zurück.
        </p>
    </div>
</section>

<section class="section">
    <div class="container split-grid">
        <div class="card">
            <h2 style="margin-top:0;">So erreichst du mich</h2>
            <ul class="contact-list">
                <li>
                    <span class="contact-label">Telefon</span>
                    <a href="tel:<?= e(preg_replace('/\s+/', '', (string) config('contact.phone'))) ?>">
                        <?= e(config('contact.phone')) ?>
                    </a>
                </li>
                <li>
                    <span class="contact-label">E-Mail</span>
                    <a href="mailto:<?= e(config('contact.email')) ?>"><?= e(config('contact.email')) ?></a>
                </li>
                <li>
                    <span class="contact-label">TikTok</span>
                    <a href="<?= e(tiktok_url()) ?>" target="_blank" rel="noopener noreferrer">
                        @<?= e(config('social.tiktok_handle')) ?>
                    </a>
                </li>
                <li>
                    <span class="contact-label">Instagram</span>
                    <a href="<?= e(instagram_url()) ?>" target="_blank" rel="noopener noreferrer">
                        @<?= e(config('social.instagram_handle')) ?>
                    </a>
                </li>
                <li>
                    <span class="contact-label">Unterwegs in</span>
                    <span><?= e(implode(' · ', config('contact.area'))) ?></span>
                </li>
            </ul>
        </div>

        <div>
            <div class="notice" style="--card-accent: var(--c-blue); margin-bottom: 1.6rem;">
                <?= icon('shield') ?>
                <div>
                    <h3>
                        Anmelden musst du dich
                        <?= $school !== '' ? 'bei der ' . e($school) : 'bei der Fahrschule' ?>
                    </h3>
                    <p>
                        Ich bin angestellte Fahrlehrerin<?= $school !== '' ? ' bei der ' . school_link() : '' ?>.
                        Vertrag, Anmeldung, Theorieunterricht und Preise laufen dort –
                        mich fragst du, wenn es ums Fahren geht. Sag bei der Anmeldung
                        einfach, dass du bei mir fahren möchtest.
                    </p>
                </div>
            </div>

            <h2>Was mir beim ersten Anruf hilft</h2>
            <ul class="facts">
                <li>
                    <?= icon('car') ?>
                    <span>
                        <strong>Worum es geht</strong>
                        <span>Erster Führerschein, Klasse BE, Wiedereinstieg oder Ausbildung mit Handicap</span>
                    </span>
                </li>
                <li>
                    <?= icon('clock') ?>
                    <span>
                        <strong>Wann du kannst</strong>
                        <span>Vormittags, nachmittags, nur samstags – dann sehe ich sofort, ob das passt</span>
                    </span>
                </li>
                <li>
                    <?= icon('pin') ?>
                    <span>
                        <strong>Wo du wohnst</strong>
                        <span>Damit wir einen sinnvollen Treffpunkt finden</span>
                    </span>
                </li>
            </ul>

            <?php /* Der Absatz für alle, die schon bei ihr fahren – seit SAR-54
                     nur noch bei eingeschalteter Terminplanung (21.08.2026).
                     Er verspricht „dafür musst du mich nicht anrufen"; ohne den
                     Weg dahinter wäre das ein Versprechen ins Leere, und genau
                     auf der Kontaktseite fällt das auf. */ ?>
            <?php if (termine_oeffentlich()): ?>
                <p class="muted" style="margin-top:1.6rem;">
                    Du fährst schon bei mir? Dann trag dich für deine nächste Stunde direkt in
                    <a href="<?= url('/termine') ?>">meinen Zeiten</a> ein – dafür musst du mich nicht anrufen.
                </p>
            <?php endif; ?>
        </div>
    </div>
</section>
