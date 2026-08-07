-- Fahrlehrerin Sarah – Datenbankschema (SQLite)
--
-- Wird von scripts/migrate.php eingespielt. Die DROP-Anweisungen machen den
-- Aufruf wiederholbar: jede Migration setzt die Datenbank neu auf.
-- ACHTUNG: Das löscht vorhandene Daten – im Demo-Betrieb ist das gewollt.

DROP TABLE IF EXISTS booking_log;
DROP TABLE IF EXISTS bookings;
DROP TABLE IF EXISTS slots;
DROP TABLE IF EXISTS students;
DROP TABLE IF EXISTS admins;

-- Sarah selbst (Backend-Zugang).
CREATE TABLE admins (
    id            INTEGER PRIMARY KEY AUTOINCREMENT,
    email         TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    created_at    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Fahrschüler:innen. Werden von Sarah angelegt – keine Selbstregistrierung.
-- Der Login läuft über E-Mail + 6-stellige PIN (gehasht wie ein Passwort).
CREATE TABLE students (
    id         INTEGER PRIMARY KEY AUTOINCREMENT,
    name       TEXT NOT NULL,
    email      TEXT NOT NULL UNIQUE,
    phone      TEXT,
    pin_hash   TEXT NOT NULL,
    active     INTEGER NOT NULL DEFAULT 1,
    note       TEXT,
    created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
);

-- Von Sarah freigegebene Termine.
--   frei      = buchbar
--   gebucht   = ein Schüler hat den Termin (zugehörige Zeile in bookings)
--   gesperrt  = von Sarah blockiert, für Schüler unsichtbar
CREATE TABLE slots (
    id           INTEGER PRIMARY KEY AUTOINCREMENT,
    starts_at    DATETIME NOT NULL,
    duration_min INTEGER NOT NULL DEFAULT 45,
    type         TEXT NOT NULL DEFAULT 'fahrstunde'
                 CHECK (type IN ('fahrstunde', 'sonderfahrt', 'pruefung')),
    location     TEXT,
    note         TEXT,
    status       TEXT NOT NULL DEFAULT 'frei'
                 CHECK (status IN ('frei', 'gebucht', 'gesperrt')),
    created_at   DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
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

CREATE INDEX idx_slots_starts_at     ON slots (starts_at);
CREATE INDEX idx_slots_status        ON slots (status);
CREATE INDEX idx_bookings_student    ON bookings (student_id);
CREATE INDEX idx_bookings_slot       ON bookings (slot_id);
CREATE INDEX idx_bookings_status     ON bookings (status);
CREATE INDEX idx_booking_log_booking ON booking_log (booking_id);

-- Nur eine aktive Buchung pro Slot – der eigentliche Schutz gegen
-- Doppelbuchungen liegt zusätzlich im UPDATE ... WHERE status='frei'.
CREATE UNIQUE INDEX idx_bookings_slot_active
    ON bookings (slot_id) WHERE status = 'gebucht';
