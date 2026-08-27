<?php
/**
 * /kontakt – SAR-95.
 *
 * Das Formular fragt DREI Dinge, nacheinander: worum es geht, ob noch etwas
 * dazu zu sagen ist, und wie Sarah zurückkommt. Mehr nicht. Wann jemand kann
 * und wo er wohnt, stand kurz auch darin und ist wieder heraus (Nils,
 * 27.08.2026): Das klärt sich in Sarahs Antwort. Danach zu fragen, bevor
 * überhaupt feststeht, ob es passt, macht aus einer Nachricht einen
 * Aufnahmebogen – genau der Eindruck, den diese Seite nirgends erwecken darf.
 *
 * Der Kasten „Was mir beim ersten Anruf hilft" steht deshalb unverändert
 * weiter oben: Er gilt dem ANRUF, und der bleibt der erste Weg.
 *
 * SCHRITT FÜR SCHRITT, ABER NICHT ANGEWIESEN AUF JAVASCRIPT. Alle drei
 * Schritte stehen im HTML; erst `initFormSteps()` in main.js blendet sie
 * einzeln ein und hängt „Zurück"/„Weiter" davor. Ohne JavaScript steht das
 * ganze Formular da und lässt sich in einem Rutsch abschicken – dieselbe
 * Bedingung wie bei den Aufklappern auf /ueber-mich: Verstecken darf man
 * nur, was ohne die Mechanik trotzdem erreichbar bleibt.
 *
 * ⚠️ Die Beschriftungen sind ENTWÜRFE und nicht Sarahs Worte – Ausnahme ist
 * die Auswahl unter „Worum geht es": das sind wörtlich ihre sechs Kacheln
 * von der Startseite.
 *
 * @var array<string,mixed>  $values  was schon getippt war (nach einem Fehler)
 * @var array<string,string> $errors  Feldname => Meldung
 */
$school = (string) config('school.name');
$values = $values ?? [];
$errors = $errors ?? [];

/** Fehlermeldung unter einem Feld – gibt nichts aus, wenn alles stimmt. */
$fehler = static function (string $feld) use ($errors): string {
    if (!isset($errors[$feld])) {
        return '';
    }

    return '<span class="form-error" id="fehler-' . e($feld) . '">'
        . e($errors[$feld]) . '</span>';
};

/** Die Attribute, die ein fehlerhaftes Feld mit seiner Meldung verbinden. */
$fehlerAttr = static function (string $feld) use ($errors): string {
    return isset($errors[$feld])
        ? ' aria-invalid="true" aria-describedby="fehler-' . e($feld) . '"'
        : '';
};

/*
 * Was ein Schritt ausgefüllt haben muss, bevor es weitergeht.
 *
 * Die Regeln stehen als JSON am Schritt, damit der Browser dieselben
 * Meldungen zeigt wie der Server – die Sätze kommen aus Contact::MELDUNGEN
 * und stehen nirgends ein zweites Mal. „felder" ist eine Liste, weil eine
 * Regel auch für eine Gruppe gelten kann: E-Mail ODER Telefon reicht.
 */
$pflicht = static function (array $regeln): string {
    return " data-pflicht='" . e(json_encode($regeln, JSON_UNESCAPED_UNICODE | JSON_HEX_APOS)) . "'";
};

/** Trägt dieser Schritt einen Fehler? Dann startet der Browser bei ihm. */
$hatFehler = static function (array $felder) use ($errors): string {
    foreach ($felder as $feld) {
        if (isset($errors[$feld])) {
            return ' data-hat-fehler';
        }
    }

    return '';
};
?>
<section class="page-head">
    <div class="container">
        <h1>Kontakt</h1>
        <p class="page-lead">
            Am schnellsten geht ein Anruf. Wenn ich gerade fahre, gehe ich nicht ran –
            <a href="#schreib-mir">schreib mir dann einfach</a>, ich melde mich zurück.
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

<section class="section section--alt" id="schreib-mir">
    <div class="container">
        <div class="section-head">
            <div class="section-head-text">
                <span class="section-eyebrow">Schreib mir</span>
                <h2>Lieber tippen als telefonieren?</h2>
            </div>
        </div>

        <div class="split-grid split-grid--wide-left">
            <div class="card">
                <?php /* Die Sprungmarke steht IM Formularziel. Sie gilt auch für
                         die Antwort auf das POST – nach einem Fehler steht die
                         Seite damit beim Formular und nicht wieder ganz oben. */ ?>
                <form class="form form-steps" method="post"
                      action="<?= url('/kontakt') ?>#schreib-mir" novalidate data-schritte>
                    <?= csrf_field() ?>

                    <?php /* Honigtopf. Für Menschen unerreichbar (weit außerhalb des
                             Bildschirms, aus der Tab-Reihenfolge genommen und für
                             Vorlesesoftware versteckt), für ein Skript ein Feld wie
                             jedes andere. Der Name ist mit Absicht gewöhnlich. */ ?>
                    <div class="hp-field" aria-hidden="true">
                        <label for="website">Website</label>
                        <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                    </div>

                    <?php if (isset($errors['form'])): ?>
                        <div class="flash flash--error" role="alert" style="margin-bottom:1.2rem;">
                            <?= e($errors['form']) ?>
                        </div>
                    <?php endif; ?>

                    <!-- 1 -->
                    <div class="form-step"<?= $hatFehler(['anliegen']) ?><?= $pflicht([
                        ['felder' => ['anliegen'], 'meldung' => Contact::MELDUNGEN['anliegen']],
                    ]) ?>>
                        <fieldset class="form-fieldset"<?= isset($errors['anliegen']) ? ' aria-invalid="true"' : '' ?>>
                            <legend>Worum geht es?</legend>
                            <?php /* Wörtlich die sechs Karten aus „Wobei ich dich begleite"
                                     (Startseite), plus „Etwas anderes". Keine zweite,
                                     abweichende Leistungsliste – und nichts, was hier
                                     stünde, ohne dass Sarah es geschrieben hat. */ ?>
                            <span class="choice-grid">
                                <?php foreach (Contact::ANLIEGEN as $wert => $label): ?>
                                    <label class="choice">
                                        <input type="radio" name="anliegen" value="<?= e($wert) ?>"
                                            <?= ($values['anliegen'] ?? '') === $wert ? 'checked' : '' ?>>
                                        <span><?= e($label) ?></span>
                                    </label>
                                <?php endforeach; ?>
                            </span>
                            <span class="form-hint">
                                Nimm das Nächstliegende – ganz genau muss es nicht passen.
                            </span>
                            <?= $fehler('anliegen') ?>
                        </fieldset>
                    </div>

                    <!-- 2 -->
                    <div class="form-step">
                        <label>
                            Willst du mir noch etwas sagen?
                            <textarea name="nachricht" rows="6" maxlength="<?= Contact::MAX_NACHRICHT ?>"
                                      placeholder="Muss nicht sein."<?= $fehlerAttr('nachricht') ?>><?= e((string) ($values['nachricht'] ?? '')) ?></textarea>
                            <span class="form-hint">
                                Wenn dir etwas wichtig ist, schreib es hier rein. Sonst einfach
                                weiter.
                            </span>
                            <?= $fehler('nachricht') ?>
                        </label>
                    </div>

                    <!-- 3 -->
                    <div class="form-step"<?= $hatFehler(['name', 'email', 'erreichbar', 'einwilligung']) ?><?= $pflicht([
                        ['felder' => ['name'],               'meldung' => Contact::MELDUNGEN['name']],
                        ['felder' => ['email', 'telefon'],   'meldung' => Contact::MELDUNGEN['erreichbar']],
                        ['felder' => ['einwilligung'],       'meldung' => Contact::MELDUNGEN['einwilligung']],
                    ]) ?>>
                        <label>
                            Wie heißt du?
                            <input type="text" name="name" maxlength="80"
                                   value="<?= old('name', $values) ?>"
                                   autocomplete="name"<?= $fehlerAttr('name') ?>>
                            <?= $fehler('name') ?>
                        </label>

                        <fieldset class="form-fieldset"<?= isset($errors['erreichbar']) ? ' aria-invalid="true"' : '' ?>>
                            <legend>Wie melde ich mich zurück?</legend>
                            <div class="form-row">
                                <label>
                                    E-Mail
                                    <input type="email" name="email" maxlength="120"
                                           value="<?= old('email', $values) ?>"
                                           autocomplete="email"<?= $fehlerAttr('email') ?>>
                                    <?= $fehler('email') ?>
                                </label>
                                <label>
                                    Telefon
                                    <input type="tel" name="telefon" maxlength="40"
                                           value="<?= old('telefon', $values) ?>"
                                           autocomplete="tel">
                                </label>
                            </div>
                            <span class="form-hint">
                                Eins von beidem reicht. Nur mit E-Mail-Adresse bekommst du
                                gleich eine kurze Bestätigung.
                            </span>
                            <?= $fehler('erreichbar') ?>
                        </fieldset>

                        <label class="checkbox-label">
                            <input type="checkbox" name="einwilligung" value="1"
                                   <?= !empty($values['einwilligung']) ? 'checked' : '' ?><?= $fehlerAttr('einwilligung') ?>>
                            <span>
                                Ich bin einverstanden, dass Sarah meine Angaben nutzt, um mir
                                zu antworten. Mehr dazu in der
                                <a href="<?= url('/datenschutz') ?>#kontaktformular">Datenschutzerklärung</a>.
                            </span>
                        </label>
                        <?= $fehler('einwilligung') ?>
                    </div>

                    <div class="form-actions" data-absenden>
                        <button class="btn btn-primary" type="submit">Nachricht abschicken</button>
                    </div>
                </form>
            </div>

            <div>
                <h3>Was danach passiert</h3>
                <ul class="steps">
                    <li>
                        <strong>Deine Angaben gehen als E-Mail an mich</strong>
                        <span>
                            Direkt in mein Postfach. Auf dieser Website wird nichts davon
                            gespeichert – es gibt keine Liste, in der du danach stehst.
                        </span>
                    </li>
                    <li>
                        <strong>Du bekommst eine kurze Bestätigung</strong>
                        <span>
                            Automatisch und sofort, damit du weißt, dass es angekommen ist –
                            wenn du eine E-Mail-Adresse angegeben hast.
                        </span>
                    </li>
                    <li>
                        <strong>Ich melde mich</strong>
                        <span>
                            Das kann ein, zwei Tage dauern – tagsüber sitze ich im Auto.
                            Wenn es eilig ist, ruf mich lieber an.
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
