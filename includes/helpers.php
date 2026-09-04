<?php

declare(strict_types=1);

require_once __DIR__ . '/db.php';

function e(?string $value): string
{
    return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8');
}

function start_secure_session(): void
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_set_cookie_params([
            'httponly' => true,
            'samesite' => 'Lax',
            'secure' => (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off'),
        ]);
        session_start();
    }
}

function csrf_token(): string
{
    start_secure_session();
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(24));
    }
    return $_SESSION['csrf'];
}

function check_csrf(): void
{
    start_secure_session();
    $token = $_POST['csrf'] ?? '';
    if (!$token || !hash_equals($_SESSION['csrf'] ?? '', $token)) {
        http_response_code(419);
        exit('Sessão expirada. Volte e tente novamente.');
    }
}

function require_auth(): void
{
    start_secure_session();
    if (empty($_SESSION['user_id'])) {
        header('Location: login.php');
        exit;
    }
}

function admin_user(): ?array
{
    start_secure_session();
    if (empty($_SESSION['user_id'])) return null;
    $stmt = db()->prepare('SELECT id,name,email FROM users WHERE id = ?');
    $stmt->execute([$_SESSION['user_id']]);
    return $stmt->fetch() ?: null;
}

function redirect(string $path): never
{
    header('Location: ' . $path);
    exit;
}

function age_from_birthdate(?string $birthDate): ?int
{
    if (!$birthDate) return null;
    try {
        return (new DateTime($birthDate))->diff(new DateTime())->y;
    } catch (Throwable $e) {
        return null;
    }
}

function student_by_id(int $id): ?array
{
    $stmt = db()->prepare('SELECT * FROM students WHERE id = ?');
    $stmt->execute([$id]);
    return $stmt->fetch() ?: null;
}

function attendance_stats(int $studentId, ?string $start = null, ?string $end = null): array
{
    $sql = 'SELECT COUNT(*) total, SUM(CASE WHEN present=1 THEN 1 ELSE 0 END) present_count, SUM(CASE WHEN present=0 THEN 1 ELSE 0 END) absent_count, SUM(CASE WHEN present=1 THEN duration_minutes ELSE 0 END) minutes FROM attendance WHERE student_id=?';
    $params = [$studentId];
    if ($start) { $sql .= ' AND class_date >= ?'; $params[] = $start; }
    if ($end) { $sql .= ' AND class_date <= ?'; $params[] = $end; }
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $r = $stmt->fetch() ?: [];
    $total = (int)($r['total'] ?? 0);
    $present = (int)($r['present_count'] ?? 0);
    return [
        'total' => $total,
        'present' => $present,
        'absent' => (int)($r['absent_count'] ?? 0),
        'minutes' => (int)($r['minutes'] ?? 0),
        'percent' => $total > 0 ? round(($present / $total) * 100, 1) : 0,
    ];
}

function latest_evaluations(int $studentId, int $limit = 2): array
{
    $limit = max(1, min(10, $limit));
    $stmt = db()->prepare("SELECT * FROM evaluations WHERE student_id=? ORDER BY evaluation_date DESC, id DESC LIMIT $limit");
    $stmt->execute([$studentId]);
    return $stmt->fetchAll();
}

function document_number(): string
{
    return 'CA-' . date('Y') . '-' . strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
}
