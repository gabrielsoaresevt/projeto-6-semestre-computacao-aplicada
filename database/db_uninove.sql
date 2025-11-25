DROP DATABASE IF EXISTS DB_UNINOVE;

CREATE DATABASE IF NOT EXISTS db_uninove
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE db_uninove;

CREATE TABLE Cursos (
    id_curso INT AUTO_INCREMENT PRIMARY KEY,
    nome_curso VARCHAR(100) NOT NULL
) ENGINE=InnoDB;

CREATE TABLE Turmas (
    id_turma INT AUTO_INCREMENT PRIMARY KEY,
    id_curso_fk INT NOT NULL,
    nome_turma VARCHAR(100) NOT NULL,
    ano_inicio YEAR NOT NULL,
    semestre INT NOT NULL, 
    periodo ENUM('Matutino', 'Vespertino', 'Noturno', 'Integral') NOT NULL,
    status ENUM('Planejada', 'Ativa', 'Concluída') NOT NULL DEFAULT 'Planejada',
    
    CONSTRAINT fk_turma_curso
        FOREIGN KEY (id_curso_fk) 
        REFERENCES Cursos(id_curso)
) ENGINE=InnoDB;

CREATE TABLE Alunos (
    id_aluno INT AUTO_INCREMENT PRIMARY KEY,
    
    nome VARCHAR(255) NOT NULL,
    ra VARCHAR(20) NOT NULL UNIQUE,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha_hash VARCHAR(255) NOT NULL
    
) ENGINE=InnoDB;

CREATE TABLE Matriculas (
    id_matricula INT AUTO_INCREMENT PRIMARY KEY,
    id_aluno_fk INT NOT NULL,
    id_turma_fk INT NOT NULL,
    data_matricula DATE NOT NULL,
    status_aluno_turma ENUM('Cursando', 'Aprovado', 'Reprovado', 'Trancado') NOT NULL DEFAULT 'Cursando',

    CONSTRAINT fk_matricula_aluno
        FOREIGN KEY (id_aluno_fk) 
        REFERENCES Alunos(id_aluno),
        
    CONSTRAINT fk_matricula_turma
        FOREIGN KEY (id_turma_fk) 
        REFERENCES Turmas(id_turma),
        
    UNIQUE KEY uk_aluno_turma (id_aluno_fk, id_turma_fk)
) ENGINE=InnoDB;

CREATE TABLE Logs_Acesso (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    ra_informado VARCHAR(30) NOT NULL,
    data_acesso DATETIME NOT NULL,
    ip_origem VARCHAR(45) NULL,
    resultado ENUM('Sucesso', 'Falha') NOT NULL,
    id_aluno_fk INT NULL, 

    CONSTRAINT fk_log_aluno
        FOREIGN KEY (id_aluno_fk) 
        REFERENCES Alunos(id_aluno)
) ENGINE=InnoDB;

USE db_uninove;

INSERT INTO Cursos (nome_curso) VALUES
('Ciência da Computação'),
('Administração'),
('Direito'),
('Engenharia Civil');

INSERT INTO Turmas (id_curso_fk, nome_turma, ano_inicio, semestre, periodo, status) VALUES

(1, 'CC-2024.1-Noturno', '2024', 1, 'Noturno', 'Concluída'),
(1, 'CC-2024.2-Noturno', '2024', 2, 'Noturno', 'Ativa'),
(1, 'CC-2025.1-Noturno', '2025', 1, 'Noturno', 'Planejada'),

(2, 'ADM-2024.1-Matutino', '2024', 1, 'Matutino', 'Concluída'),
(2, 'ADM-2024.2-Matutino', '2024', 2, 'Matutino', 'Ativa'),

(3, 'DIR-2025.1-Integral', '2025', 1, 'Integral', 'Planejada');

INSERT INTO Alunos (nome, ra, email, senha_hash) VALUES
('Ana Silva', '101010', 'ana.silva@email.com', '$2y$10$T.A.tqK/bCMzLwL.1VLf.e.9fJj/LwL.1VLf'),
('Bruno Costa', '202020', 'bruno.costa@email.com', '$2y$10$V.LwL.1VLf.e.9fJj/LwL.1VLf.e.9fJj/Lw'),
('Carla Dias', '303030', 'carla.dias@email.com', '$2y$10$W.1VLf.e.9fJj/LwL.1VLf.e.9fJj/LwL.1V'),
('Daniel Moreira', '404040', 'daniel.moreira@email.com', '$2y$10$X.LwL.1VLf.e.9fJj/LwL.1VLf.e.9fJj/L'),
('Elisa Fernandes', '505050', 'elisa.fernandes@email.com', '$2y$10$Y.1VLf.e.9fJj/LwL.1VLf.e.9fJj/LwL.1'),
('Fábio Guedes', '606060', 'fabio.guedes@email.com', '$2y$10$Z.LwL.1VLf.e.9fJj/LwL.1VLf.e.9fJj/Lw'),
('Gabriela Lima', '707070', 'gabriela.lima@email.com', '$2y$10$A.1VLf.e.9fJj/LwL.1VLf.e.9fJj/LwL.1'),
('Heitor Alves', '808080', 'heitor.alves@email.com', '$2y$10$B.LwL.1VLf.e.9fJj/LwL.1VLf.e.9fJj/Lw'),
('Isis Ribeiro', '909090', 'isis.ribeiro@email.com', '$2y$10$C.1VLf.e.9fJj/LwL.1VLf.e.9fJj/LwL.1V'),
('João Mendes', '121212', 'joao.mendes@email.com', '$2y$10$D.LwL.1VLf.e.9fJj/LwL.1VLf.e.9fJj/Lw');

INSERT INTO Matriculas (id_aluno_fk, id_turma_fk, data_matricula, status_aluno_turma) VALUES

(1, 1, '2024-02-01', 'Aprovado'), 
(1, 2, '2024-07-01', 'Cursando'), 
(2, 1, '2024-02-01', 'Aprovado'), 
(2, 2, '2024-07-01', 'Cursando'),
(3, 1, '2024-02-01', 'Reprovado'), 
(3, 2, '2024-07-01', 'Trancado'), 

(4, 2, '2024-07-01', 'Cursando'),
(5, 3, '2025-02-01', 'Cursando'), 

(6, 4, '2024-02-01', 'Aprovado'),
(6, 5, '2024-07-01', 'Cursando'),
(7, 4, '2024-02-01', 'Aprovado'),
(7, 5, '2024-07-01', 'Cursando'),
(8, 5, '2024-07-01', 'Cursando'),

(9, 6, '2025-02-01', 'Cursando'),
(10, 6, '2025-02-01', 'Cursando');

INSERT INTO Logs_Acesso (ra_informado, data_acesso, ip_origem, resultado, id_aluno_fk) VALUES

( '101010', '2025-10-10 09:15:00', '192.168.1.5', 'Sucesso', 1),
( '101010', '2025-11-01 10:00:00', '192.168.1.5', 'Sucesso', 1),
( '202020', '2025-11-16 14:00:00', '189.10.20.30', 'Sucesso', 2),
( '101010', '2025-11-17 14:00:00', '192.168.1.5', 'Sucesso', 1),
( '606060', '2025-11-17 15:00:00', '45.12.33.99', 'Sucesso', 6),
( '909090', '2025-11-16 10:00:00', '8.8.8.8', 'Sucesso', 9),

( '101010', '2025-11-17 13:59:00', '192.168.1.5', 'Falha', 1),
( '202020', '2025-11-17 08:29:00', '189.10.20.30', 'Falha', 2),
( '202020', '2025-11-17 08:29:30', '189.10.20.30', 'Falha', 2),

( '999999', '2025-11-15 12:00:00', '201.50.40.30', 'Falha', NULL),
( 'admin', '2025-11-16 09:00:00', '150.70.80.90', 'Falha', NULL),
( '303030', '2025-11-17 10:00:00', '177.50.60.70', 'Falha', 3);

SELECT * FROM Cursos;
SELECT * FROM Turmas;
SELECT * FROM Alunos;
SELECT * FROM Matriculas;
SELECT * FROM Logs_Acesso;

CREATE VIEW vw_DetalhesAcademicosAluno AS
SELECT 
    a.ra AS "RA",
    a.nome AS "Nome do Aluno",
    a.email AS "Email",
    c.nome_curso AS "Curso",
    t.nome_turma AS "Turma",
    t.ano_inicio AS "Ano da Turma",
    t.semestre AS "Semestre",
    t.periodo AS "Período",
    m.status_aluno_turma AS "Status do Aluno na Turma"
    
    -- a.id_aluno,
    -- t.id_turma,
    -- c.id_curso
FROM 
    Alunos AS a
JOIN 
    Matriculas AS m ON a.id_aluno = m.id_aluno_fk
JOIN 
    Turmas AS t ON m.id_turma_fk = t.id_turma
JOIN 
    Cursos AS c ON t.id_curso_fk = c.id_curso;
    
SELECT * FROM vw_DetalhesAcademicosAluno;

CREATE USER 'admin_uninove'@'localhost' IDENTIFIED WITH mysql_native_password BY '123456';
GRANT ALL PRIVILEGES ON db_uninove. * TO 'admin_uninove'@'localhost' WITH GRANT OPTION;