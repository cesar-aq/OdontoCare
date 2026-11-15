CREATE DATABASE IF NOT EXISTS crud_consultas
    DEFAULT CHARACTER SET utf8mb4
    DEFAULT COLLATE utf8mb4_unicode_ci;
USE crud_consultas;

CREATE TABLE IF NOT EXISTS paciente (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS funcionario (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    perfil ENUM('dentista','secretaria') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE IF NOT EXISTS consulta (
    id INT AUTO_INCREMENT PRIMARY KEY,
    paciente_id INT NOT NULL,
    dentista_id INT NOT NULL,
    data_hora DATETIME NOT NULL,
    valor_total DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    valor_pago DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    forma_pagamento ENUM('DINHEIRO','PIX','CARTÃO DE DEBITO','CARTÃO DE CREDITO') NOT NULL,
    procedimentos_realizados VARCHAR(255) NULL,
    procedimentos_arealizar VARCHAR(255) NULL,
    descricao VARCHAR(255) NULL,
    medicacao VARCHAR(255) NULL,
    criado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    atualizado_em TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_consulta_paciente FOREIGN KEY (paciente_id) REFERENCES paciente(id),
    CONSTRAINT fk_consulta_dentista FOREIGN KEY (dentista_id) REFERENCES funcionario(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO paciente (nome) VALUES
('Ana Paula Silva'), ('João Pedro Santos'), ('Mariana Oliveira');

INSERT INTO funcionario (nome, perfil) VALUES
('Dr. Carlos Eduardo', 'dentista'), ('Dra. Fernanda Lima', 'dentista');
