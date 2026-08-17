#!/usr/bin/env python3
"""
Baut alle Logo-Dateien in public/assets/img/ aus der Kundenvorlage.

    python3 scripts/logo-ableitungen.py

Braucht Pillow, NumPy, SciPy und scikit-image – nur zum Bauen der Bilder, die
Website selbst hat weiterhin keinen Build-Step. Schickt Sarah ein neues Logo,
kommt es nach assets-quellen/fahrlehrerin_sarah_logo.png und dieses Skript
läuft einmal durch; danach die Maße gegenprüfen (siehe unten).

WAS HIER ENTSTEHT

    logo-sarah-original-freigestellt.png  Master, weißer Grund entfernt
    logo-sarah-klein.webp                 Header, Login, Referenzseite
    logo-sarah-hero.webp                  große Fassung in Reserve
    logo-sarah-hell.webp                  für den dunklen Fuß und die Sidebar
    logo-bogen.webp                       nur der Bogen (Bühne auf /ueber-mich)
    logo-signet.webp                      Bogen + Lenkrad, ohne Schrift
    logo-wortmarke.webp                   nur der Schriftzug
    favicon.png, apple-touch-icon.png     Browser-Symbole
    logo-sarah-teilen.jpg                 Vorschaubild beim Teilen (og:image)

DIE MASSE HÄNGEN AM SEITENVERHÄLTNIS DER VORLAGE. Alle Ableitungen werden über
die HÖHE gerechnet, die Breite ergibt sich – so verzerrt nichts. Ändert sich
dadurch die Breite, gehören diese Stellen mit angefasst, sonst springt das
Layout beim Laden:

    width=… height=… an den <img>-Tags in partials/nav.php, partials/footer.php,
    admin/layout.php, admin/login.php, pages/meine-website.php
    theme.css → .hero-arc { aspect-ratio: … } (Maße von logo-bogen.webp)

Das Skript gibt die neuen Maße am Ende aus.
"""
import sys
from pathlib import Path

import numpy as np
from PIL import Image
from scipy import ndimage
from skimage.morphology import convex_hull_image

WURZEL   = Path(__file__).resolve().parent.parent
VORLAGE  = WURZEL / 'assets-quellen' / 'fahrlehrerin_sarah_logo.png'
MASTER   = WURZEL / 'assets-quellen' / 'logo-sarah-original-freigestellt.png'
ZIEL     = WURZEL / 'public' / 'assets' / 'img'

BG      = (253, 248, 240)   # --bg aus theme.css
FOOTER  = (43, 36, 52)      # --bg-footer aus theme.css
WEISS_T = 78                # Abstand zu Weiß, ab dem ein Pixel Hintergrund ist


def freistellen(quelle: Path) -> Image.Image:
    """Weißen Hintergrund entfernen, eingeschlossenes Weiß behalten.

    Wichtig ist der zweite Halbsatz: Die Speichen im Lenkrad und die Innenflächen
    der Buchstaben sind genauso weiß wie der Hintergrund. Ein reiner Farbschlüssel
    würde sie mit durchlöchern. Deshalb wird nur die Fläche entfernt, die vom Rand
    her zusammenhängt.
    """
    bild = np.array(Image.open(quelle).convert('RGB'))
    zu_weiss = np.sqrt(((255 - bild.astype(np.int32)) ** 2).sum(axis=2))
    flaechen, _ = ndimage.label(zu_weiss <= WEISS_T)
    am_rand = set(flaechen[0, :]) | set(flaechen[-1, :]) | set(flaechen[:, 0]) | set(flaechen[:, -1])
    am_rand.discard(0)
    hintergrund = np.isin(flaechen, list(am_rand))
    alpha = np.where(hintergrund, 0, 255).astype(np.uint8)
    return Image.fromarray(np.dstack([bild, alpha]), 'RGBA')


def trimmen(bild: Image.Image) -> Image.Image:
    a = np.array(bild)
    ys, xs = np.nonzero(a[..., 3] > 0)
    return bild.crop((xs.min(), ys.min(), xs.max() + 1, ys.max() + 1))


def teile(voll: Image.Image):
    """Zerlegt das Logo in Bogen, Lenkrad und Schriftzug.

    Der Bogen ist die mit Abstand größte zusammenhängende Fläche. Alles andere
    liegt entweder IN ihm (Lenkrad, Schrift) oder klebt als Farbspritzer am
    Pinselstrich. Unterschieden wird über die konvexe Hülle des Bogens – sie
    schließt die Öffnung des C mit einer Sehne – und über den Abstand zum Strich.
    """
    maske = np.array(voll)[..., 3] > 0
    H, W = maske.shape
    flaechen, n = ndimage.label(maske, np.ones((3, 3)))
    groessen = np.array(ndimage.sum(maske, flaechen, range(1, n + 1)))
    bogen_nr = int(np.argmax(groessen)) + 1
    bogen = flaechen == bogen_nr

    huelle = convex_hull_image(bogen)
    abstand = ndimage.distance_transform_edt(~bogen)
    mindestabstand = max(6, round(W / 80))
    mindestgroesse = max(24, round(W * H / 8000))
    kaesten = ndimage.find_objects(flaechen)

    frei_innen = []
    for i in range(1, n + 1):
        if i == bogen_nr:
            continue
        kasten = kaesten[i - 1]
        teil = flaechen[kasten] == i
        if huelle[kasten][teil].all() and abstand[kasten][teil].min() > mindestabstand:
            frei_innen.append(i)

    inhalt = np.zeros_like(maske)
    for i in frei_innen:
        if groessen[i - 1] >= mindestgroesse:
            inhalt[kaesten[i - 1]] |= flaechen[kaesten[i - 1]] == i

    # Zweiter Durchgang für die Kleinteile: Der Punkt auf dem i gehört zum i, ein
    # Farbspritzer gehört zu nichts. Das entscheidet die Nähe zum schon erkannten
    # Inhalt und nicht die Größe – i-Punkte sind winzig.
    nah_am_inhalt = ndimage.distance_transform_edt(~inhalt) < W / 34
    for i in frei_innen:
        if groessen[i - 1] < mindestgroesse:
            kasten = kaesten[i - 1]
            teil = flaechen[kasten] == i
            if nah_am_inhalt[kasten][teil].any():
                inhalt[kasten] |= teil

    innere = ndimage.label(inhalt, np.ones((3, 3)))
    lenkrad = innere[0] == int(np.argmax(ndimage.sum(inhalt, innere[0], range(1, innere[1] + 1)))) + 1
    return maske & ~inhalt, lenkrad, inhalt & ~lenkrad


def nur(voll: Image.Image, behalten: np.ndarray) -> Image.Image:
    """Blendet alles aus, was nicht in der Maske steht – ohne zu beschneiden.

    Der Zuschnitt bleibt bewusst der des vollen Logos: logo-bogen.webp ist die
    Bühne, auf der Sarahs Foto in prozentualen Koordinaten sitzt (theme.css,
    .hero-arc img). Neu getrimmt würden diese Prozente auf etwas anderes zeigen.
    """
    a = np.array(voll).copy()
    a[..., 3] = np.where(behalten, a[..., 3], 0)
    return Image.fromarray(a, 'RGBA')


def hell(bild: Image.Image) -> Image.Image:
    """Fassung für dunklen Grund: Schwarz wird hell, Weiß wird dunkel.

    Nur die unbunten Stellen werden getauscht – der Regenbogen bleibt, wie er
    ist. Sonst wäre es ein Negativ und keine zweite Fassung desselben Logos.
    """
    a = np.array(bild).astype(np.float64)
    rgb = a[..., :3]
    helligkeit = rgb.mean(axis=2, keepdims=True) / 255.0
    ersatz = np.array(BG) * (1 - helligkeit) + np.array(FOOTER) * helligkeit
    buntheit = (rgb.max(axis=2) - rgb.min(axis=2))[..., None]
    anteil = np.clip(1 - buntheit / 32.0, 0, 1)
    a[..., :3] = rgb * (1 - anteil) + ersatz * anteil
    return Image.fromarray(a.round().clip(0, 255).astype(np.uint8), 'RGBA')


def auf_hoehe(bild: Image.Image, hoehe: int) -> Image.Image:
    breite = max(1, round(bild.size[0] * hoehe / bild.size[1]))
    return bild.resize((breite, hoehe), Image.LANCZOS)


def buehne(bild: Image.Image, breite: int, hoehe: int, inhalt_hoehe: int, grund=None) -> Image.Image:
    """Mittig auf eine feste Leinwand setzen – für die Symbole und das og:image."""
    klein = auf_hoehe(bild, inhalt_hoehe)
    leinwand = Image.new('RGBA', (breite, hoehe), (*grund, 255) if grund else (0, 0, 0, 0))
    leinwand.alpha_composite(klein, ((breite - klein.size[0]) // 2, (hoehe - klein.size[1]) // 2))
    return leinwand


def main() -> int:
    if not VORLAGE.exists():
        print(f'Vorlage fehlt: {VORLAGE}', file=sys.stderr)
        return 1

    frei = freistellen(VORLAGE)
    frei.save(MASTER)
    voll = trimmen(frei)
    bogen, lenkrad, schrift = teile(voll)
    bogen_bild = nur(voll, bogen)
    signet = nur(voll, bogen | lenkrad)
    wortmarke = trimmen(nur(voll, schrift))

    gebaut = []

    def webp(bild, name):
        bild.save(ZIEL / name, 'WEBP', quality=88, method=6)
        gebaut.append((name, bild.size))

    webp(auf_hoehe(voll, 300), 'logo-sarah-klein.webp')
    webp(auf_hoehe(voll, 947), 'logo-sarah-hero.webp')
    webp(auf_hoehe(hell(voll), 462), 'logo-sarah-hell.webp')
    webp(auf_hoehe(bogen_bild, 1155), 'logo-bogen.webp')
    webp(auf_hoehe(signet, 231), 'logo-signet.webp')
    webp(wortmarke.resize((600, round(600 * wortmarke.size[1] / wortmarke.size[0])), Image.LANCZOS),
         'logo-wortmarke.webp')

    # Das Symbol im Browser-Tab zeigt nur den Bogen: Bei 48 px ist der Schriftzug
    # ein grauer Fleck, der Bogen bleibt erkennbar.
    buehne(bogen_bild, 48, 48, 44).save(ZIEL / 'favicon.png')
    gebaut.append(('favicon.png', (48, 48)))

    buehne(voll, 180, 180, 156, grund=BG).convert('RGB').save(ZIEL / 'apple-touch-icon.png')
    gebaut.append(('apple-touch-icon.png', (180, 180)))

    buehne(voll, 1200, 630, 521, grund=BG).convert('RGB').save(
        ZIEL / 'logo-sarah-teilen.jpg', quality=86, optimize=True, progressive=True)
    gebaut.append(('logo-sarah-teilen.jpg', (1200, 630)))

    for name, (b, h) in gebaut:
        print(f'  {name:<30} {b}x{h}')
    print('\nMaße geändert? Dann die <img>-Angaben und .hero-arc anpassen (siehe Kopf dieser Datei).')
    return 0


if __name__ == '__main__':
    raise SystemExit(main())
