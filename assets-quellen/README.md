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
