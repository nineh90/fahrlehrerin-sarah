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

Die beiden Fotos bleiben nur lokal: Das Repo ist öffentlich, und auf beiden Aufnahmen
steht „FAHRSCHULE SANDER" auf dem Stehtisch – derselbe Sachverhalt wie `SCHOOL_NAME`
in der `.env`. Wer die Zuschnitte neu bauen muss, holt sich die Originale aus dem
Kundenordner.
