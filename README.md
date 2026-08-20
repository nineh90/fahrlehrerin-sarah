# Fahrlehrerin Sarah – Website & Stundenplanung

Persönliche Website für Sarah, angestellte Fahrlehrerin (Klassen B und BE, Schwerpunkt
Ausbildung mit Handicap) in Neu Wulmstorf, Buxtehude, Stade und Hamburg.

Die Seite ist **Sarahs Aushängeschild**, keine Fahrschul-Website: Anmeldung, Vertrag und
Preise laufen über ihre Fahrschule. Die Terminübersicht ist Sarahs eigene Stundenplanung –
ihre Fahrschüler:innen tragen sich dort selbst ein, statt ihr hinterherzutelefonieren.

**Stand: klickbare Demo.** Alles funktioniert echt, die Inhalte sind Platzhalter.

---

## Loslegen

```bash
cp .env.example .env
php scripts/migrate.php
php -S localhost:8000 -t public
```

Dann <http://localhost:8000> öffnen.

### Demo-Zugänge

| Rolle | Adresse | Zugangsdaten |
|---|---|---|
| Sarah (Schaltzentrale) | `/admin/login` | `info@fahrlehrerinsarah.de` · `sarah12345` |
| Fahrschülerin Lena | `/login` | `lena@example.de` · PIN `111111` |
| Fahrschüler Tim | `/login` | `tim@example.de` · PIN `222222` |
| Fahrschülerin Mia | `/login` | `mia@example.de` · PIN `333333` |

Die Schaltzentrale ist seit SAR-54 **nirgends mehr verlinkt**. `/admin/login` gibt es
unverändert, die Adresse muss man nur direkt eingeben. Das ist eine Aufräumaktion im
Fuß und keine Sicherung: Was den Bereich schützt, ist das Passwort.

Die Demo-Termine werden **relativ zum heutigen Datum** erzeugt. Wirkt die Demo nach ein paar
Wochen leer, einfach `php scripts/migrate.php` erneut ausführen – das setzt alles frisch auf.

---

## Was wo eingestellt wird

| Was | Wo |
|---|---|
| Farben, Schriften, gesamtes Branding | `public/assets/css/theme.css` (nur diese Datei!) |
| Telefon, E-Mail, Einzugsgebiet, Handles | `.env` |
| Name der Fahrschule (leer = wird nicht genannt) | `.env` → `SCHOOL_NAME` |
| Änderungsfrist fürs Absagen (Standard 24 h) | `.env` → `CANCEL_DEADLINE_HOURS` |
| Texte | `app/Views/` (Plain PHP, keine Templatesprache) |
| Wegbegleiter (Partner-Logos + Unterseiten) | `app/Partners.php`, Anleitung steht im Kopf der Datei |
| Bilder | `public/assets/img/` – echte Fotos direkt, Fehlendes als `platzhalter-*.svg` |
| Mailversand | `.env` → `MAIL_DRIVER`, `SMTP_*` (siehe unten) |

### Mailversand

`MAIL_DRIVER=log` ist der Standard: Es geht nichts raus, alles landet in
`storage/mail.log`. **Zum Entwickeln so lassen** – dann liegt lokal auch kein
Mailpasswort.

Im Betrieb `MAIL_DRIVER=smtp` und die `SMTP_*`-Werte in der `.env` des Servers
setzen. `SMTP_PASSWORD` gehört ausschließlich dorthin: Die Datei ist
gitignored, liegt außerhalb des Webroots und wird vom Deploy nicht angefasst.

`MAIL_DRIVER=mail` (PHP `mail()`) funktioniert im Docker-Container **nicht** –
das Image enthält kein Mailprogramm.

Versand ausprobieren, ohne eine Buchung auszulösen:

```bash
php scripts/mailtest.php empfaenger@example.de
```

---

## Manuelle Klick-Checkliste

Es gibt bewusst keine Test-Suite. Vor jeder Übergabe einmal durchklicken:

| # | Schritt | Erwartung |
|---|---|---|
| 1 | `/` aufrufen | Hero mit Porträt-Platzhalter, Hinweis „persönliche Seite", Handicap-Abschnitt |
| 2 | Fenster auf 360 px verkleinern | Nichts läuft über, Kalender stapelt sich, Menü klappt auf |
| 3 | `/termine` ohne Login | Freie Zeiten sichtbar, Hinweiskasten statt Eintragen-Button |
| 4 | `/login` mit Demo-PIN | Weiterleitung auf „Meine Stunden" |
| 5 | Freie Zeit eintragen | Verschwindet aus der freien Liste, taucht unter „Meine Stunden" auf |
| 6 | Zweiter Browser trägt dieselbe Zeit ein | Meldung „wurde gerade eben vergeben", keine Doppelbuchung |
| 7 | Stunde verschieben | Alte Zeit wieder frei, neue belegt, Verlauf zeigt „verschoben" |
| 8 | Stunde in < 24 h | Buttons weg, Erklärung + Hinweis „Frist abgelaufen" |
| 9 | Absagen | Zeit wieder frei, Eintrag steht als storniert im Verlauf |
| 10 | Fremde Buchungs-ID in der URL | 404, keine fremden Daten |
| 11 | `/admin` ohne Login | Weiterleitung auf den Login |
| 12 | Serie anlegen: Mo+Mi, 14–17 Uhr, 2 Wochen | Termine erscheinen im Kalender |
| 13 | Dieselbe Serie nochmal | „Alle X Termine gab es bereits", nichts doppelt |
| 14 | Fahrschüler:in anlegen | PIN wird einmalig angezeigt, Login damit funktioniert |
| 15 | Formular ohne CSRF-Token abschicken | Abbruch mit HTTP 419 |
| 16 | Ganz nach unten auf `/` | Abschnitt „Wegbegleiter“, die Logo-Kacheln stehen nebeneinander links |
| 17 | Kachel anklicken | Infoseite des Wegbegleiters, Rückweg oben links |
| 18 | `/wegbegleiter/gibt-es-nicht` aufrufen | 404 |
| 18a | Wegbegleiter-Seite ganz nach unten | Herkunftsangabe unter einer Haarlinie, KEIN „Ich bin Fahrlehrerin …“ |
| 19 | Fuß auf jeder Seite ansehen | Nur Impressum · Datenschutz, kein Weg in die Schaltzentrale |
| 20 | `/impressum` und `/datenschutz` | Echte Angaben, keine eckigen Klammern, gleiche Anschrift |

Syntaxprüfung:

```bash
for f in $(find app public scripts -name '*.php'); do php -l "$f"; done
```

---

## Vor dem Livegang

Die vollständige Liste steht in `CLAUDE.md`. Das Wichtigste:

1. ~~**Impressum und Datenschutz** mit echten Daten füllen.~~ Mit SAR-15 erledigt:
   Sarahs Angaben stammen aus ihrem Online-Impressum, im Datenschutz steht dieselbe
   verantwortliche Stelle. **Zwei Punkte bleiben offen:** ob die für die
   Fahrlehrerlaubnis zuständige Behörde genannt werden muss (der Block
   „Berufsbezeichnung" nennt sie nicht), und die Hosting-Angaben im Datenschutz
   (Auftragsverarbeitung, Serverstandort, Logfiles). Juristisch geprüft ist beides
   nicht.
2. Restliche Fotos einsetzen (Porträt von Sarah, Fahrschulauto, Lenkhilfe/Handbedienteil,
   Kanal-Ausschnitt) – das Linksgas-Foto ist schon drin.
3. ~~Klären, ob die Fahrschule namentlich genannt werden darf.~~ Geklärt am
   19.08.2026: Sie darf genannt werden, und ihr Logo darf stehen, denn Sarah
   arbeitet dort. Das gilt für die Fahrschule Sander. Bei jedem weiteren
   Wegbegleiter ist die Frage neu zu klären, denn ein fremdes Logo zu zeigen
   ist eine Nutzung und kein Zitat.
   **Offen für Ankerliebe St. Pauli** (SAR-64, seit 20.08.2026): Logo und Name
   stehen auf der Seite, die Freigabe von Ricarda Belmar fehlt noch. Dasselbe
   gilt für den Satz im Vorspann der Unterseite, der sagt, wie Sarah und
   Ankerliebe zusammenhängen; der ist geschlossen und nicht von Sarah bestätigt.
   **Offen für KE!N EINZELFALL e.V.** (SAR-63, seit 20.08.2026): dieselben zwei
   Punkte, Freigabe durch den Verein und der Satz im Vorspann. Dazu ein dritter,
   der nur hier gilt: ob Sarah auf ihrer Seite auf Opferhilfe verweisen möchte.
   Das ist keine Gestaltungsfrage.
4. `APP_DEBUG=false`, neues `ADMIN_PASSWORD`, echte Kontaktdaten in der `.env`.
5. Google Fonts lokal ausliefern – dann entfällt die Datenübertragung an Google.

---

## Technik

Plain PHP 8 mit SQLite, kein Framework, kein Composer, kein Build-Step. Läuft auf
praktisch jedem Hosting mit PHP und `pdo_sqlite`. Details zur Architektur: `CLAUDE.md`.
Ursprüngliche Planung: `projekt.md`.
