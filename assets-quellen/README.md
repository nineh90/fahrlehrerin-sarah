# Quelldateien

Hier liegen die Vorlagen, aus denen die Bilder in `public/assets/img/` abgeleitet werden.
Sie liegen **bewusst außerhalb des Webroots** – sie sollen nicht über die Website
abrufbar sein.

Die Logo-Ableitungen baut `scripts/logo-ableitungen.py`. Schickt Sarah ein neues Logo,
kommt es als `fahrlehrerin_sarah_logo.png` hierher und das Skript läuft einmal durch:

```bash
python3 scripts/logo-ableitungen.py
```

Es stellt frei, zerlegt in Bogen, Lenkrad und Schriftzug und schreibt alle Fassungen
samt Favicon und Teilen-Bild. Ändert sich dabei das Seitenverhältnis, nennt es die neuen
Maße – dann gehören die `width`/`height` an den `<img>`-Tags und `.hero-arc` in der
`theme.css` mit angefasst. Was warum so gerechnet wird, steht im Kopf des Skripts.

| Datei | Was | Im Repo? |
|---|---|---|
| `fahrlehrerin_sarah_logo.png` | Kundenvorlage des Logos, weißer Hintergrund | ja |
| `logo-sarah-original-freigestellt.png` | daraus freigestellt, Master aller Logo-Ableitungen | ja |
| `fahrlehrerin_sarah.jpeg` | Rohfoto von der Messe | **nein**, siehe `.gitignore` |
| `fahrlehrerin_sarah_ausgeschnitten.png` | Rohfoto freigestellt | **nein**, siehe `.gitignore` |
| `sarah-rollistammtisch.jpeg` | Rohfoto am Infotisch beim Rollistammtisch | **nein**, siehe `.gitignore` |

Die Fotos bleiben nur lokal: Das Repo ist öffentlich, und Aufnahmen einer realen Person
gehören da nicht hinein. Auf den beiden Messe-Fotos steht zusätzlich „FAHRSCHULE SANDER"
auf dem Stehtisch – derselbe Sachverhalt wie `SCHOOL_NAME` in der `.env`. Wer die
Zuschnitte neu bauen muss, holt sich die Originale aus dem Kundenordner. Die Befehle
dafür stehen in der `CLAUDE.md` im Abschnitt „Bilder".

**Rohdateien nie in `public/assets/img/` ablegen** – von dort sind sie sofort öffentlich
abrufbar und landen beim nächsten `git add` im Repo. Erst hierher, dann die verkleinerte
Fassung nach `public/`.

## Die Wortmarke von Johannes Springer

`public/assets/img/partner/johannes-springer-wortmarke.webp` ist die einzige Logodatei
dieser Seite, die es beim Inhaber **nicht als Datei gibt**: „JOHANNES SPRINGER / STUDIO"
ist auf johannes-springer.studio gesetzter Text. Die Datei ist deshalb mit seinen eigenen
Werten nachgesetzt, direkt aus seiner Seite gelesen (SAR-60, 21.08.2026):

| | |
|---|---|
| Schrift | Space Mono 400 (Google Fonts, SIL OFL) |
| Sperrung | 0,17 em · Zeilenhöhe 1,35 |
| Zeile 1 | „JOHANNES SPRINGER" in `#F3EEE4` |
| Zeile 2 | „STUDIO" in `#EE7B2E`, dahinter der Cursorblock (0,31 × 0,95 em) |
| Grund | `#14161C` – liegt nicht im Bild, sondern als `logo_plate` in `Partners.php` |

Die Schriftdatei liegt **nicht im Repo**: Sie wird nur zum Rendern gebraucht. Alle Maße
im Achtfachen des Originals, damit die Kanten sauber werden.

```bash
curl -sA 'Mozilla/4.0' 'https://fonts.googleapis.com/css2?family=Space+Mono:wght@400' \
  | grep -o 'https://[^)]*\.ttf' | head -1 | xargs curl -s -o /tmp/SpaceMono-Regular.ttf

magick -background none -fill '#F3EEE4' -font /tmp/SpaceMono-Regular.ttf \
  -pointsize 108.8 -kerning 18.5 label:'JOHANNES SPRINGER' -trim +repage /tmp/z1.png
magick -background none -fill '#EE7B2E' -font /tmp/SpaceMono-Regular.ttf \
  -pointsize 108.8 -kerning 18.5 label:'STUDIO' -trim +repage /tmp/z2.png
magick -size 34x103 xc:'#EE7B2E' /tmp/cursor.png

magick -background none -gravity Center /tmp/z2.png \( -size 9x1 xc:none \) \
  /tmp/cursor.png +append /tmp/zeile2.png
magick -background none -gravity West /tmp/z1.png \( -size 1x67 xc:none \) \
  /tmp/zeile2.png -append /tmp/wortmarke.png

magick /tmp/wortmarke.png -resize 600x -quality 88 -define webp:method=6 \
  public/assets/img/partner/johannes-springer-wortmarke.webp
```

**Ändert sich dabei das Seitenverhältnis, gehören `logo_width`/`logo_height` in
`Partners.php` mit angefasst.** Und: Eine nachgesetzte Wortmarke gehört vom Inhaber
freigegeben. Liefert er eine eigene Datei, ersetzt sie diese hier.

Sein Favicon (`partner/johannes-springer.webp`, oranger Block auf dunklem Grund) stand
bis zum 21.08.2026 in der Kachel und liegt weiter im Ordner.

---

## Die drei Aufnahmen vom 31.08.2026 (SAR-110)

Von Sarah geliefert, ursprünglich direkt in `public/assets/img/` abgelegt und von
dort hierher verschoben – ins Web gehört der verkleinerte Zuschnitt, nicht das
Original vom Telefon. Alle drei stehen in der `.gitignore`: **Auf zweien ist nicht
nur Sarah zu sehen**, sondern eine Kollegin und ein Fahrschüler, erkennbar und in
voller Auflösung. Das Repo ist öffentlich.

| Vorlage | Ausgeliefert | Wo |
|---|---|---|
| `fahrlehrerin_sarah_und_kollegin.jpeg` (1536×2048) | `sarah-und-kollegin.jpg` (900×1200) | `/neurodivergenz`, „Du musst dich bei mir nicht verstellen" |
| `fahrlehrerin_sarah_fahrstunde_handicap.jpeg` (2048×1536) | `sarah-fahrstunde-handicap.jpg` (900×675) | dieselbe Sektion, darunter versetzt |
| `fahrlehrerin_sarah_fahrschulauto_sander_handicap_ausbildung.jpeg` (1600×1200) | `fahrschulauto-handicap.jpg` (900×665) | `/fahren-mit-handicap`, „Welche Lösung passt zu dir?", neben der Handbedienung |

Gebaut mit dem Standardbefehl, nur auf 900 px statt 1400 px – breiter werden die
beiden nirgends angezeigt (im Paar rund 420 bzw. 360 px, also doppelte
Anzeigebreite):

```bash
magick assets-quellen/fahrlehrerin_sarah_und_kollegin.jpeg -auto-orient -resize 900x \
  -strip -interlace Plane -quality 76 public/assets/img/sarah-und-kollegin.jpg
magick assets-quellen/fahrlehrerin_sarah_fahrstunde_handicap.jpeg -auto-orient -resize 900x \
  -strip -interlace Plane -quality 76 public/assets/img/sarah-fahrstunde-handicap.jpg
```

`-strip` ist hier nicht nur eine Größenfrage: Es nimmt die EXIF-Daten mit, also auch
einen etwaigen Standort. Nachgesehen – in diesen beiden Vorlagen stand ohnehin
keiner, aber beim nächsten Telefonfoto kann es anders sein.

**Offen und nicht von uns zu entscheiden:** Auf beiden Bildern sind Dritte
erkennbar. Dass sie der Veröffentlichung zugestimmt haben, setzen wir voraus, weil
Sarah die Fotos zu genau diesem Zweck geliefert hat – geprüft haben wir es nicht.

### Der Zuschnitt des Autos ist eine inhaltliche Entscheidung

Auf dem Original steht „FAHRSCHULE SANDER" quer über der Tür, dazu
`fahrschule-sander.de`, das **scharf lesbare Kennzeichen**, das VW-Logo,
Facebook- und Instagram-Zeichen und zwei fremde Sponsorenlogos (clever fit,
Autohaus Czychy). Der Ausschnitt lässt all das weg. Übrig bleiben das orangene
Rollstuhlzeichen, der grüne Streifen und ein Stück Dach – der Beleg für Sarahs
Schwerpunkt, nicht ein Foto ihres Arbeitgebers. Am selben Tag hatte sie „zu
viel Sander" gemeldet (SAR-101); ein ungeschnittenes Foto hätte ihr genau das
zurückgegeben.

```bash
magick assets-quellen/fahrlehrerin_sarah_fahrschulauto_sander_handicap_ausbildung.jpeg \
  -crop 650x480+350+180 +repage -auto-orient -resize 900x \
  -strip -interlace Plane -quality 78 public/assets/img/fahrschulauto-handicap.jpg
```

Zwei weitere Zuschnitte waren zur Auswahl gebaut und sind verworfen: einer nur
aufs Heck (vom Rücklicht erschlagen) und einer mit **beiden** Rollstuhlzeichen
– inhaltlich stärker, aber bei rund 360 px Anzeigebreite wird jedes der beiden
zu klein. Wer den Wagen doch in voller Länge zeigen will, baut neu – dann aber
mit dem Kennzeichen im Blick.

**Seit SAR-113 (31.08.2026) kommen zwei weitere Zuschnitte aus derselben
Vorlage**, je einer für die Hero der beiden Schwerpunktseiten. `-crop` ist
hier die ganze Aussage: Beide Seiten zeigen dasselbe Auto, aber nicht dasselbe
davon.

| Ausgeliefert | Wo | Was drauf ist |
|---|---|---|
| `hero-fahrschulauto-zeichen.jpg` (800×606) | Hero `/fahren-mit-handicap` | das orangene Rollstuhlzeichen groß, grüner Streifen, Rücklicht |
| `hero-fahrschulauto-fenster.jpg` (800×748) | Hero `/neurodivergenz` | Fensterband, Außenspiegel, grüner Streifen, ein Stück Hecke – **kein** Rollstuhlzeichen |

```bash
magick assets-quellen/fahrlehrerin_sarah_fahrschulauto_sander_handicap_ausbildung.jpeg \
  -auto-orient -crop 620x470+380+230 +repage -resize 800x \
  -strip -interlace Plane -quality 78 public/assets/img/hero-fahrschulauto-zeichen.jpg
magick assets-quellen/fahrlehrerin_sarah_fahrschulauto_sander_handicap_ausbildung.jpeg \
  -auto-orient -crop 460x430+60+230 +repage -resize 800x \
  -strip -interlace Plane -quality 78 public/assets/img/hero-fahrschulauto-fenster.jpg
```

**Warum das Fensterbild ohne Rollstuhlzeichen auskommen muss:** Die Seite
handelt von Autismus, ADHS und anderer Reizverarbeitung, also von
Behinderungen, die man nicht sieht. Sarahs Anlass für die Seite war ihr Satz,
sie habe „bisher nicht ein Wort über die Menschen mit unsichtbaren
Behinderungen gefunden". Ein Rollstuhlsymbol über ihrer Überschrift nähme ihn
zurück. Der Ausschnitt liegt deshalb links vom Zeichen (das im Original bei
x ≈ 512 anfängt) und oberhalb der Türbeschriftung (ab y ≈ 680).

Eine zweite Fassung des Fensterbilds mit mehr Hecke (`460x470+60+150`) ist
verworfen: Bei 400 px Anzeigebreite war die halbe Fläche Grün und das Auto
Beiwerk.

**`fahrschulauto-handicap.jpg` ist seit SAR-113 nicht mehr eingebunden.** Es
stand einen Tag lang neben der Handbedienung; das Auto steht jetzt in der
Hero derselben Seite, und zwei Zuschnitte eines Wagens auf einer Seite lesen
sich als Wiederholung. Die Datei bleibt liegen.

**Nicht zu verwechseln mit `fahrschulauto.webp`**: Das ist der ältere
Freisteller aus einer Folie des Theoriematerials, weiterhin nirgends
eingebunden.

## Die Pedalverlängerung (31.08.2026, SAR-112)

`fahrlehrerin_sarah_umbau_fahrschulauto_kleinwuchs.jpeg` (1536×2048) – der Fußraum
des Fahrschulautos mit der Pedalverlängerung, also dem Umbau, um den es bei
Kleinwuchs geht. Ausgeliefert als `handicap-pedalverlaengerung.jpg` (900×1200) auf
`/fahren-mit-handicap`, im Abschnitt „Autofahren mit angepasster Technik" neben dem
Linksgas-Foto.

Kam wie die drei vom selben Tag direkt in `public/assets/img/` an und ist von dort
hierher verschoben worden.

**Diese Vorlage bleibt im Repo**, anders als die drei aus SAR-110. Der Grund für
deren Sperre trifft hier nicht zu: kein Mensch im Bild, kein Kennzeichen, keine
Beschriftung der Fahrschule – nur Technik, wie bei `handicap-handgas-umbau.jpeg`,
das aus demselben Grund im Repo liegt. EXIF war schon keines drin (nachgesehen,
auch kein Standort); `-strip` nimmt trotzdem mit, was käme.

```bash
magick assets-quellen/fahrlehrerin_sarah_umbau_fahrschulauto_kleinwuchs.jpeg -auto-orient \
  -crop 1230x1640+230+330 +repage -resize 900x \
  -strip -interlace Plane -quality 76 public/assets/img/handicap-pedalverlaengerung.jpg
```

Der Zuschnitt nimmt unten gut ein Drittel leere Fußmatte weg und links die dunkle
Kante. Angezeigt wird das Bild mit rund 420 px Breite – ungeschnitten wären die
Pedale darin verloren. Ein Rest Fußmatte bleibt trotzdem stehen: Ohne sie ist nicht
zu erkennen, dass man in einen Fußraum sieht. Zwei weitere Zuschnitte waren zur
Auswahl gebaut und sind verworfen: ein weiterer, auf dem die Pedale bei 420 px zu
klein werden, und ein engerer, auf dem vom grünen Stab nur ein Stummel bleibt –
und der ist der einzige Farbpunkt der Aufnahme.

## Das Neurodivergenz-Schaubild (31.08.2026, SAR-114)

**Hier liegt kein Bild – auf der Website steht ein Nachbau in HTML und CSS.**
Der Kreis auf `/neurodivergenz` (Kern „Neurodivergenz", darum sechs Felder:
Hochbegabung, Autismus, Tourette-Syndrom, Dyskalkulie, Dyslexie, AD(H)S) ist
die Komponente `.spektrum` – Struktur in `nd-base.css`, Farben in
`theme.css`, Sonderfall Hochkontrast in `a11y.css`.

Geliefert worden war eine fertige Grafik
(`fahrlehrerin_sarah_hero_neurodivergenz.jpeg`, 872 × 1022). Sie liegt lokal
in diesem Ordner, steht aber **in der `.gitignore`** und wird nirgends
ausgeliefert. Zwei Gründe, jeder für sich ausreichend:

1. **Herkunft und Lizenz sind ungeklärt.** Die Vorlage ist erkennbar ein
   Bildschirmfoto aus einer fremden Veröffentlichung. Das Repo ist
   öffentlich, und die Website ist seit demselben Tag indexierbar.
2. **Sie besteht ausschließlich aus Text im Bild** – genau das, was die
   Konvention dieser Seite vermeidet. Gemalter Text skaliert nicht, lässt
   sich nicht markieren, wird nicht vorgelesen und von Suchmaschinen nicht
   gelesen. Ausgerechnet auf der Seite, die unter „ADHS" und „Autismus"
   gefunden werden soll, wären das die wichtigsten Wörter gewesen – als
   Pixel.

Der Nachbau erledigt beides und kostet nichts: sechs Listeneinträge, ein
Absatz, gut hundert Zeilen CSS. Er trägt Sarahs Regenbogen statt der Farben
der Vorlage, wächst mit der Schriftgröße des Browsers, funktioniert in allen
drei Farbmodi und wird unter 430 px Spaltenbreite zu einer Reihe von Pillen,
statt die Schrift auf 10 px zu schrumpfen.

**Wer die Vorlage doch einmal braucht** (etwa zum Vergleich), findet sie in
diesem Ordner. Sie gehört nicht ins Repo und nicht auf den Server.
