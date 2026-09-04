<?php

declare(strict_types=1);

function app_config(): array
{
    static $config;
    if (!$config) {
        $config = require __DIR__ . '/../config/config.php';
    }
    return $config;
}

function db(): PDO
{
    static $pdo;
    if ($pdo instanceof PDO) {
        return $pdo;
    }

    $cfg = app_config()['db'];
    if ($cfg['driver'] === 'mysql') {
        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $cfg['host'], $cfg['port'], $cfg['database'], $cfg['charset']
        );
        $pdo = new PDO($dsn, $cfg['username'], $cfg['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
    } else {
        $pdo = new PDO('sqlite:' . $cfg['sqlite_path'], null, null, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);
        $pdo->exec('PRAGMA foreign_keys = ON');
    }

    ensure_schema($pdo, $cfg['driver']);
    return $pdo;
}

function ensure_schema(PDO $pdo, string $driver): void
{
    $auto = $driver === 'sqlite';
    if (!$auto) {
        return;
    }

    $pdo->exec(<<<'SQL'
CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password_hash TEXT NOT NULL,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS students (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name TEXT NOT NULL,
    birth_date TEXT,
    responsible_name TEXT NOT NULL,
    phone TEXT,
    address TEXT,
    condominium TEXT,
    program TEXT NOT NULL DEFAULT 'Movimento Kids',
    start_date TEXT,
    status TEXT NOT NULL DEFAULT 'ativo',
    notes TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP
);
CREATE TABLE IF NOT EXISTS attendance (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    student_id INTEGER NOT NULL,
    class_date TEXT NOT NULL,
    duration_minutes INTEGER NOT NULL DEFAULT 60,
    present INTEGER NOT NULL DEFAULT 1,
    activity TEXT,
    notes TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS evaluations (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    student_id INTEGER NOT NULL,
    evaluation_date TEXT NOT NULL,
    coordination INTEGER NOT NULL DEFAULT 5,
    balance INTEGER NOT NULL DEFAULT 5,
    agility INTEGER NOT NULL DEFAULT 5,
    strength INTEGER NOT NULL DEFAULT 5,
    endurance INTEGER NOT NULL DEFAULT 5,
    confidence INTEGER NOT NULL DEFAULT 5,
    notes TEXT,
    created_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);
CREATE TABLE IF NOT EXISTS documents (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    student_id INTEGER NOT NULL,
    type TEXT NOT NULL,
    period_start TEXT,
    period_end TEXT,
    document_number TEXT NOT NULL,
    issued_at TEXT NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE
);
SQL);

    $count = (int)$pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
    if ($count === 0) {
        $stmt = $pdo->prepare('INSERT INTO users (name,email,password_hash) VALUES (?,?,?)');
        $stmt->execute([
            'Carlos Aníbal',
            'admin@carlosanibal.com.br',
            password_hash('MovimentoKids2026!', PASSWORD_DEFAULT),
        ]);
    }
}
