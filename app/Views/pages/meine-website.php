<section class="page-head">
    <div class="container">
        <h1>Wer diese Seite erstellt hat</h1>
        <p class="page-lead">
            Ich werde regelmäßig gefragt, wo die Website herkommt – deshalb steht
            es hier statt in jeder einzelnen Nachricht.
        </p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="duo duo--text-first">
            <div class="duo-media photo-wrap" style="--card-accent: var(--c-blue);">
                <?php /* Hier stand der letzte Platzhalter der Seite (eine gezeichnete
                         Windschutzscheibe). An seiner Stelle jetzt beide Marken
                         nebeneinander – auf einer Seite, die „Wer diese Seite erstellt
                         hat" heißt, ist das der passendere Inhalt als ein Foto aus dem
                         Auto (Nils, 12.08.2026).

                         Aus zwei echten Logos zusammengesetzt und NICHT als fertige
                         Grafik gebaut: Beide bleiben in jeder Größe scharf, es
                         entsteht keine neue Datei, die bei einer Logo-Änderung
                         veralten könnte – und Sarahs Logo wird dabei nicht angefasst,
                         sondern nur danebengestellt (siehe „Sarahs Logo" in CLAUDE.md:
                         das Logo selbst wird nicht mehr verändert).

                         Das × ist aria-hidden: Vorgelesen ergibt „Fahrlehrerin Sarah
                         mal Nils-Digital" keinen Sinn, die beiden alt-Texte reichen. */ ?>
                <div class="cooperation">
                    <img class="cooperation-mark" src="<?= asset('img/logo-sarah-klein.webp') ?>"
                         alt="Fahrlehrerin Sarah" width="260" height="300"
                         loading="lazy" decoding="async">
                    <span class="cooperation-x" aria-hidden="true">&times;</span>
                    <img class="cooperation-mark cooperation-mark--nd" src="<?= asset('img/nils-digital-logo.png') ?>"
                         alt="Nils-Digital" width="320" height="233"
                         loading="lazy" decoding="async">
                </div>
            </div>

            <div class="duo-text">
                <?php /* DIE ECHTE ENTSTEHUNGSGESCHICHTE (Nils, 12.08.2026). Hier
                         stand vorher „Zwei Gründe …", und das klang, als hätte Sarah
                         die Website von sich aus gewollt. Tatsächlich war ihr Plan
                         ein Terminplaner für die Fahrstunden – die Seite drumherum
                         kam als Vorschlag von Nils.

                         Das ist die ehrlichere Geschichte und für eine Referenzseite
                         die bessere: Sie zeigt, was Nils-Digital beiträgt, nämlich
                         den Blick auf das Ganze statt nur auf das bestellte Stück.

                         Weiterhin ein ENTWURF in Sarahs Stimme – die Fakten stimmen
                         jetzt, die Formulierung ist noch nicht von ihr. */ ?>
                <h2>Eigentlich wollte ich nur einen Terminplaner</h2>
                <p>
                    Mein Problem war die Terminabsprache. Ich habe zwischen den Fahrstunden
                    Nachrichten beantwortet, hinterhertelefoniert und trotzdem Termine
                    doppelt vergeben. Gesucht habe ich einen Planer für meine Stunden –
                    mehr erst mal nicht.
                </p>
                <p>
                    Nils hat vorgeschlagen, eine Seite drumherum zu bauen: eine, die die
                    Terminplanung einschließt und dazu zeigt, wie ich arbeite. Auf TikTok
                    und Instagram bin ich mit meiner Arbeit ohnehin öffentlich unterwegs –
                    eine eigene Seite rundet das ab.
                </p>
                <p>
                    Dazu kommt die Ausbildung mit Handicap. Wer mit Prothese oder nach einem
                    Unfall fahren lernen will, sucht danach im Internet – und findet meistens
                    nichts.
                </p>
            </div>
        </div>
    </div>
</section>

<?php /* Hier stand ein Zitat unter Sarahs Namen („Ich wollte keine Seite, die
         aussieht wie jede andere Fahrschule …") – erfunden. Es ist am 12.08.2026
         ersatzlos entfallen: Sarah hat nie darüber geschrieben, warum sie die
         Seite wollte, und die echte Geschichte steht jetzt eine Sektion höher.
         Wenn sie einen Satz dazu liefert, kommt hier wieder ein Zitat hin –
         vorher nicht. */ ?>

<section class="section">
    <div class="container">
        <div class="duo">
            <div class="duo-text">
                <h2>Wie es gelaufen ist</h2>
                <p>
                    <?php /* Jede Nennung von Nils-Digital auf dieser Seite ist ein Link
                             (Nils, 12.08.2026). Ohne rel="nofollow" – ein Backlink, der
                             zählen soll, darf nicht abgewertet sein. rel="noopener"
                             bleibt, das ist Sicherheit und kein SEO-Signal. */ ?>
                    Erstellt hat die Seite <strong><a href="https://nils-digital.de"
                        target="_blank" rel="noopener">Nils-Digital</a></strong>. Wir haben besprochen,
                    was ich brauche, und ein paar Wochen später war sie fertig – die
                    Terminplanung, mit der alles anfing, ist Teil davon.
                </p>
                <p>
                    Wenn du selbstständig bist oder einen kleinen Betrieb hast und dir seit
                    Jahren vornimmst, „mal was mit der Website zu machen": Da lohnt sich ein
                    Gespräch.
                </p>

                <?php /* Der Transparenzhinweis ist Pflicht und keine Höflichkeit:
                         Sarah bekommt die Seite zu besonderen Konditionen und
                         empfiehlt Nils-Digital dafür weiter – das ist eine
                         Gegenleistung, und eine Empfehlung gegen Gegenleistung
                         muss als solche erkennbar sein.

                         Der Satz „empfehlen würde ich sie aber auch sonst" stand
                         hier bis zum 12.08.2026 und ist entfallen: Genau diese
                         Bekräftigung hebt die Kennzeichnung wieder auf, die der
                         Kasten leisten soll – und gesagt hat Sarah sie nie. */ ?>
                <div class="notice" style="--card-accent: var(--c-yellow); margin-top:1.6rem;">
                    <?= icon('shield') ?>
                    <div>
                        <h3>Transparenz</h3>
                        <p>
                            Ich bekomme diese Website zu besonderen Konditionen und empfehle
                            <a href="https://nils-digital.de" target="_blank" rel="noopener">Nils-Digital</a>
                            dafür weiter. Das gehört dazugesagt.
                        </p>
                    </div>
                </div>
            </div>

            <div class="duo-media">
                <div class="card center">
                    <img src="<?= asset('img/nils-digital-logo.png') ?>"
                         alt="Logo von Nils-Digital" width="320" height="233"
                         style="width:120px;height:auto;margin:0 auto;" loading="lazy" decoding="async">
                    <?php /* Auch die Wortmarke in der Karte ist ein Link. Der Knopf
                             darunter führt zwar zum selben Ziel – aber wer auf einen
                             Namen zeigt, klickt darauf, und ein toter Name neben einem
                             lebendigen Knopf ist eine kleine Enttäuschung. */ ?>
                    <p class="nd-credit-word" style="font-size:1.5rem;margin:.9rem 0 .4rem;">
                        <a href="https://nils-digital.de" target="_blank" rel="noopener">Nils-Digital</a>
                    </p>
                    <p class="muted" style="font-size:.9rem;margin:0 0 1.4rem;">
                        Websites für kleine Betriebe und Selbstständige –
                        handgemacht, schnell und ohne Baukasten.
                    </p>
                    <a class="btn btn-primary btn-block" href="https://nils-digital.de"
                       target="_blank" rel="noopener">nils-digital.de</a>
                </div>
            </div>
        </div>
    </div>
</section>
