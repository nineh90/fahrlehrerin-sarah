<?php

declare(strict_types=1);

/**
 * Die Einstellungen der Barrierefreiheits-Leiste.
 *
 * Übernommen aus dem Schwesterprojekt „Kein Einzelfall" (config/darstellung.php
 * dort), auf diese Seite übertragen. Was dort NICHT dabei ist und hier deshalb
 * auch nicht: die Leichte Sprache. Das ist keine Darstellungsoption, sondern ein
 * zweiter Textbestand mit eigenem Fassungswechsel – die Texte dafür schreibt die
 * Kundin, nicht das CSS.
 *
 * WARUM HIER UND NICHT IN JAVASCRIPT: Das Panel wird serverseitig gerendert.
 * Damit stehen alle Beschriftungen im ausgelieferten HTML – die Leiste ist auch
 * dann vorhanden und vorlesbar, wenn das Skript nicht lädt. Ein Bedienfeld für
 * Barrierefreiheit darf nicht die fragilste Stelle der Seite sein.
 *
 * Zweiter Grund: Die Zuordnung „Wert -> Wirkung auf <html>" brauchen zwei
 * Stellen – das Inline-Skript im <head>, das gespeicherte Einstellungen anwendet,
 * BEVOR der Browser zeichnet, und die Bedienung in a11y.js. Beide lesen aus
 * `anwendung` unten. Stünde die Tabelle zweimal da, würde sie auseinanderlaufen.
 */

return [

    /*
     * Reihenfolge und Beschriftung im Panel.
     *
     * typ:
     *   stufen   – mehrere Stufen, der Wert ist eine Zahl (Index in 'anwendung')
     *   auswahl  – schließt sich gegenseitig aus, der Wert ist eine Zeichenkette
     *   schalter – an/aus
     */
    'optionen' => [

        'schrift' => [
            'label' => 'Schriftgröße',
            'typ'   => 'stufen',
            'werte' => [
                ['wert' => 0, 'label' => 'Standard'],
                ['wert' => 1, 'label' => 'Groß'],
                ['wert' => 2, 'label' => 'Größer'],
                ['wert' => 3, 'label' => 'Sehr groß'],
            ],
        ],

        'zeilen' => [
            'label' => 'Zeilenabstand',
            'typ'   => 'stufen',
            'werte' => [
                ['wert' => 0, 'label' => 'Standard'],
                ['wert' => 1, 'label' => 'Weit'],
                ['wert' => 2, 'label' => 'Sehr weit'],
            ],
        ],

        'zeichen' => [
            'label' => 'Buchstabenabstand',
            'typ'   => 'stufen',
            'werte' => [
                ['wert' => 0, 'label' => 'Standard'],
                ['wert' => 1, 'label' => 'Weit'],
                ['wert' => 2, 'label' => 'Sehr weit'],
            ],
        ],

        'kontrast' => [
            'label' => 'Kontrast & Farben',
            'typ'   => 'auswahl',
            'werte' => [
                ['wert' => '',           'label' => 'Standard'],
                ['wert' => 'dunkel',     'label' => 'Dunkel'],
                ['wert' => 'hoch',       'label' => 'Hoher Kontrast'],
                ['wert' => 'monochrom',  'label' => 'Graustufen'],
            ],
        ],

        'lesbar'    => ['label' => 'Gut lesbare Schrift',     'typ' => 'schalter'],
        'dyslexie'  => ['label' => 'Schrift für Legasthenie', 'typ' => 'schalter'],
        'leselinie' => ['label' => 'Leselinie',               'typ' => 'schalter'],
        'links'     => ['label' => 'Links hervorheben',       'typ' => 'schalter'],
        'cursor'    => ['label' => 'Großer Mauszeiger',       'typ' => 'schalter'],
        'ruhe'      => ['label' => 'Bewegung stoppen',        'typ' => 'schalter'],
        'bilder'    => ['label' => 'Bilder ausblenden',       'typ' => 'schalter'],
    ],

    /*
     * Wie ein gespeicherter Wert auf <html> landet.
     *
     * Angefasst wird ausschließlich das <html>-Element, nie ein einzelner
     * Baustein. Dadurch wirkt jede Einstellung automatisch auch auf Komponenten,
     * die es heute noch nicht gibt.
     */
    'anwendung' => [

        /* Der Wert ist ein Index in die jeweilige Liste.
           Die Schriftstufen sind Faktoren auf die Grundschrift; weil die ganze
           Seite seit SAR-34 in rem an zehn Tokens hängt, wächst damit alles
           gleichmäßig mit – Abstände, Kartenhöhen, Knöpfe. */
        'variablen' => [
            'schrift' => ['--a11y-font-scale',     [1, 1.15, 1.3, 1.5]],
            'zeilen'  => ['--a11y-line-height',    [1.6, 1.9, 2.2]],
            'zeichen' => ['--a11y-letter-spacing', ['0em', '0.05em', '0.1em']],
        ],

        /* Der Wert landet unverändert als <html data-…="…">. */
        'datensaetze' => ['kontrast'],

        /* An/aus wird zu <html class="a11y-…">. */
        'klassen' => ['lesbar', 'dyslexie', 'leselinie', 'links', 'cursor', 'ruhe', 'bilder'],
    ],

    /* Schlüssel im localStorage. */
    'speicher' => 'sarah-a11y',
];
