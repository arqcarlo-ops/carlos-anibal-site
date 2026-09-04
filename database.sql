-- Banco MySQL para hospedagem compartilhada
-- Importe este arquivo no phpMyAdmin e depois edite config/config.php.

CREATE TABLE IF NOT EXISTS users (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS students (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(160) NOT NULL,
  birth_date DATE NULL,
  responsible_name VARCHAR(160) NOT NULL,
  phone VARCHAR(40) NULL,
  address VARCHAR(255) NULL,
  condominium VARCHAR(180) NULL,
  program VARCHAR(180) NOT NULL DEFAULT 'Movimento Kids',
  start_date DATE NULL,
  status VARCHAR(20) NOT NULL DEFAULT 'ativo',
  notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS attendance (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id INT UNSIGNED NOT NULL,
  class_date DATE NOT NULL,
  duration_minutes INT NOT NULL DEFAULT 60,
  present TINYINT(1) NOT NULL DEFAULT 1,
  activity VARCHAR(200) NULL,
  notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_attendance_student FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
  INDEX idx_attendance_student_date(student_id,class_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS evaluations (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id INT UNSIGNED NOT NULL,
  evaluation_date DATE NOT NULL,
  coordination TINYINT NOT NULL DEFAULT 5,
  balance TINYINT NOT NULL DEFAULT 5,
  agility TINYINT NOT NULL DEFAULT 5,
  strength TINYINT NOT NULL DEFAULT 5,
  endurance TINYINT NOT NULL DEFAULT 5,
  confidence TINYINT NOT NULL DEFAULT 5,
  notes TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_evaluations_student FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
  INDEX idx_evaluations_student_date(student_id,evaluation_date)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS documents (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  student_id INT UNSIGNED NOT NULL,
  type VARCHAR(40) NOT NULL,
  period_start DATE NULL,
  period_end DATE NULL,
  document_number VARCHAR(50) NOT NULL UNIQUE,
  issued_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  CONSTRAINT fk_documents_student FOREIGN KEY(student_id) REFERENCES students(id) ON DELETE CASCADE,
  INDEX idx_documents_number(document_number)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- IMPORTANTE: no MySQL, crie o primeiro usuário admin usando o instalador abaixo:
-- 1) temporariamente altere driver para sqlite, acesse /admin uma vez e teste; ou
-- 2) gere um hash PHP com: php -r "echo password_hash('SUA_SENHA', PASSWORD_DEFAULT);"
-- e faça o INSERT abaixo substituindo HASH_GERADO.
-- INSERT INTO users(name,email,password_hash) VALUES ('Carlos Aníbal','admin@carlosanibal.com.br','HASH_GERADO');
