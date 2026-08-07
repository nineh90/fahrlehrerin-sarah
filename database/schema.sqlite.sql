-- Fahrlehrerin Sarah – Datenbankschema (SQLite)
--
-- Wird von scripts/migrate.php eingespielt. Die DROP-Anweisungen machen den
-- Aufruf wiederholbar: jede Migration setzt die Datenbank neu auf.
-- ACHTUNG: Das löscht vorhandene Daten – im Demo-Betrieb ist das gewollt.

DROP TABLE IF EXISTS notifications;
DROP TABLE IF EXISTS booking_log;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS slots;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS admins;

-- Sarah selbst (Backend-Zugang).
--
-- must_change_password = 1 bedeutet: das Passwort stammt aus der .env und ist
-- damit ein Einmalpasswort. Solange die Eins steht, landet jeder Aufruf im
-- Adminbereich auf der Passwortseite – so kann der Zugang gar nicht dauerhaft
-- mit dem Passwort laufen, das im Klartext in einer Datei stand.
CREATE TABLE admins (
    id                   INTEGER PRIMARY KEY AUTOINCREMENT,
    email                TEXT NOT NULL UNIQUE,
    password_hash        TEXT NOT NULL,
    must_change_password INTEGER NOT NULL DEFAULT 0,
    password_changed_at  DATETIME,
    created_at           DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Fahrschüler:innen. Werden von Sarah angelegt – keine Selbstregistrierung.
-- Der Login läuft über E-Mail + 6-stellige PIN (gehasht wie ein Passwort).
--
-- Die PIN steht NIRGENDS im Klartext – auch nicht hier. Sarah kann sie deshalb
-- nicht nachschlagen, sondern nur eine neue erzeugen (und mailen lassen).
-- pin_changed_at/pin_sent_at halten fest, wann das zuletzt passiert ist.
--
-- Die drei start_*-Spalten sind der Anfangsstand der Pflichtfahrten: Fahrten,
-- die vor dieser Website gefahren wurden und deshalb in keiner Buchung stehen.
CREATE TABLE students (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    name            TEXT NOT NULL,
    email           TEXT NOT NULL UNIQUE,
    phone           TEXT,
    pin_hash        TEXT NOT NULL,
    pin_changed_at  DATETIME,
    pin_sent_at     DATETIME,
    klasse          TEXT NOT NULL DEFAULT 'B'
                    CHECK (klasse IN ('B', 'BE')),
    start_ueberland INTEGER NOT NULL DEFAULT 0,
    start_autobahn  INTEGER NOT NULL DEFAULT 0,
    start_nacht     INTEGER NOT NULL DEFAULT 0,
    active          INTEGER NOT NULL DEFAULT 1,
    note            TEXT,
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Von Sarah freigegebene Termine.
--   frei      = buchbar
--   gebucht   = ein Schüler hat den Termin (zugehörige Zeile in bookings)
--   gesperrt  = von Sarah blockiert, für Schüler unsichtbar
-- sonderfahrt_art zählt die Pflichtfahrten (§5 FahrschAusbO). Nur bei
-- type='sonderfahrt' gefüllt, sonst NULL – daraus errechnet sich der
-- Ausbildungsstand jedes Schülers, ohne dass Sarah irgendwo mitzählen muss.
CREATE TABLE slots (
    id              INTEGER PRIMARY KEY AUTOINCREMENT,
    starts_at       DATETIME NOT NULL,
    duration_min    INTEGER NOT NULL DEFAULT 45,
    type            TEXT NOT NULL DEFAULT 'fahrstunde'
                    CHECK (type IN ('fahrstunde', 'sonderfahrt', 'pruefung')),
    sonderfahrt_art TEXT
                    CHECK (sonderfahrt_art IS NULL
                           OR sonderfahrt_art IN ('ueberland', 'autobahn', 'nacht')),
    location        TEXT,
    note            TEXT,
    status          TEXT NOT NULL DEFAULT 'frei'
                    CHECK (status IN ('frei', 'gebucht', 'gesperrt')),
    created_at      DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    -- Kein Slot doppelt zur selben Zeit (schützt auch die Serien-Anlage)
    UNIQUE (starts_at)
);

-- Buchungen. Ein Slot kann höchstens eine aktive Buchung haben; stornierte
-- Buchungen bleiben als Historie stehen, deshalb kein UNIQUE auf slot_id.
CREATE TABLE bookings (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    slot_id      INTEGER NOT NULL,
    student_id   INTEGER NOT NULL,
    status       TEXT NOT NULL DEFAULT 'gebucht'
                 CHECK (status IN ('gebucht', 'storniert')),
    note         TEXT,
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    cancelled_at DATETIME,
    FOREIGN KEY (slot_id)    REFERENCES slots (id)    ON DELETE CASCADE,
    FOREIGN KEY (student_id) REFERENCES students (id) ON DELETE CASCADE
);

-- Verlauf einer Buchung – macht im Admin nachvollziehbar, wer wann
-- gebucht, verschoben oder storniert hat.
CREATE TABLE booking_log (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    booking_id   INTEGER NOT NULL,
    action       TEXT NOT NULL
                 CHECK (action IN ('gebucht', 'verschoben', 'storniert')),
    from_slot_id INTEGER,
    to_slot_id   INTEGER,
    actor        TEXT NOT NULL DEFAULT 'schueler'
                 CHECK (actor IN ('schueler', 'admin')),
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE CASCADE
);

-- Benachrichtigungen für Sarah.
--
-- Bewusst eine eigene Tabelle und keine Auswertung von booking_log: hier steht
-- der Text schon fertig drin (inkl. Name und Zeit ZUM ZEITPUNKT des Ereignisses),
-- damit ein späteres Verschieben oder Löschen die Meldung nicht rückwirkend
-- verfälscht. Gleichzeitig ist das der Puffer für den Versand nach außen –
-- 'channels' hält fest, was tatsächlich rausging (mail, webhook).
CREATE TABLE notifications (
    id             INTEGER PRIMARY KEY AUTOINCREMENT,
    event          TEXT NOT NULL
                   CHECK (event IN ('gebucht', 'verschoben', 'storniert')),
    actor          TEXT NOT NULL DEFAULT 'schueler'
                   CHECK (actor IN ('schueler', 'admin')),
    booking_id     INTEGER,
    student_name   TEXT NOT NULL,
    -- Zeitpunkt des Termins nach dem Ereignis (bei Storno: der abgesagte)
    starts_at      DATETIME,
    -- Nur beim Verschieben gefüllt: die Zeit davor
    from_starts_at DATETIME,
    title          TEXT NOT NULL,
    body           TEXT NOT NULL,
    channels       TEXT,
    read_at        DATETIME,
    created_at     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (booking_id) REFERENCES bookings (id) ON DELETE SET NULL
);

CREATE INDEX idx_slots_starts_at     ON slots (starts_at);
CREATE INDEX idx_slots_status        ON slots (status);
CREATE INDEX idx_bookings_student    ON bookings (student_id);
CREATE INDEX idx_bookings_slot       ON bookings (slot_id);
CREATE INDEX idx_bookings_status     ON bookings (status);
CREATE INDEX idx_booking_log_booking ON booking_log (booking_id);
CREATE INDEX idx_notifications_read   ON notifications (read_at, id);

-- Nur eine aktive Buchung pro Slot – der eigentliche Schutz gegen
-- Doppelbuchungen liegt zusätzlich im UPDATE ... WHERE status='frei'.
CREATE UNIQUE INDEX idx_bookings_slot_active
    ON bookings (slot_id) WHERE status = 'gebucht';
