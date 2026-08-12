# Quelldateien

Hier liegen die Vorlagen, aus denen die Bilder in `public/assets/img/` abgeleitet werden.
Sie liegen **bewusst außerhalb des Webroots** – sie sollen nicht über die Website
abrufbar sein. Die Befehle zum Neubauen der Ableitungen stehen in der `CLAUDE.md`
im Abschnitt „Sarahs Logo".

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
