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
