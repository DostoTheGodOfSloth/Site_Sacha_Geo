-- Nom-prénom : Florian Tauxe
-- date : 14.06.2021
DROP DATABASE IF EXISTS db_terracoast;
CREATE DATABASE db_terracoast default character set UTF8 collate utf8_general_ci;
CREATE TABLE t_continent (
  idContinent INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  conName VARCHAR (50) NOT NULL
);

CREATE TABLE t_pays (
  idPays INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  payAbreviation VARCHAR (2) NOT NULL,
  payCapitale VARCHAR (50) NOT NULL,
  payNom VARCHAR (50) NOT NULL,
  fkContinent int unsigned NOT NULL,
  FOREIGN KEY (fkContinent) REFERENCES t_continent(idContinent)
);
CREATE TABLE t_canton (
  idCanton INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  canNom VARCHAR (50) NOT NULL,
  canChef VARCHAR (50) NOT NULL
);
CREATE TABLE t_quiz (
  idQuiz INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  quiTitre VARCHAR (50) NOT NULL,
  quiDescription TEXT NOT NULL,
  quiDifficulte VARCHAR (10) NOT NULL,
  quiTemps VARCHAR (10) NOT NULL,
  quiLien VARCHAR (50) NOT NULL
);
CREATE TABLE t_user (
  idUser INT UNSIGNED PRIMARY KEY AUTO_INCREMENT NOT NULL,
  useNom VARCHAR (50) NOT NULL,
  useMdp VARCHAR (255) NOT NULL,
  isAdmin bool DEFAULT 0 NOT NULL
);
CREATE TABLE t_score (
  scoScore TINYINT UNSIGNED DEFAULT 0 NOT NULL,
  scoTemps INT UNSIGNED DEFAULT 0 NOT NULL,
  fkUser int UNSIGNED NOT NULL,
  fkQuiz int UNSIGNED NOT NULL,
  UNIQUE(fkUser, fkQuiz),
  FOREIGN KEY (fkUser) REFERENCES t_user(idUser),
  FOREIGN KEY (fkQuiz) REFERENCES t_quiz(idQuiz)
);