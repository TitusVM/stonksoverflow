DROP DATABASE IF EXISTS appWebIIStonksOverflow;
CREATE DATABASE appWebIIStonksOverflow
  CHARACTER SET 'utf8mb4'
  COLLATE 'utf8mb4_unicode_ci';

USE appWebIIStonksOverflow;

CREATE TABLE Users(
   id INT AUTO_INCREMENT,
   username VARCHAR(50) UNIQUE NOT NULL,
   passwd VARCHAR(50) NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(username)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Questions(
   id INT AUTO_INCREMENT,
   title varchar(150) NOT NULL,
   mainText TEXT,
   datetimestamp DATETIME NOT NULL,
   idUser INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idUser) REFERENCES Users(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Answers(
   id INT AUTO_INCREMENT,
   mainText TEXT,
   datetimestamp DATETIME NOT NULL,
   solution TINYINT NOT NULL,
   idQuestion INT NOT NULL,
   idUser INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idQuestion) REFERENCES Questions(id),
   FOREIGN KEY(idUser) REFERENCES Users(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Comments(
   id INT AUTO_INCREMENT,
   mainText TEXT,
   datetimestamp DATETIME NOT NULL,
   idUser INT NOT NULL,
   idAnswer INT,
   idQuestion INT,
   PRIMARY KEY(id),
   FOREIGN KEY(idUser) REFERENCES Users(id),
   FOREIGN KEY(idAnswer) REFERENCES Answers(id),
   FOREIGN KEY(idQuestion) REFERENCES Questions(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE Users AUTO_INCREMENT = 1;
ALTER TABLE Questions AUTO_INCREMENT = 1;
ALTER TABLE Answers AUTO_INCREMENT = 1;
ALTER TABLE Comments AUTO_INCREMENT = 1;

INSERT INTO Users(username, passwd)
   VALUES ('test', 'test'),
          ('test2', 'test2');

INSERT INTO Questions(title, mainText, datetimestamp, idUser)
   VALUES ('Titre de question 1', 'Ceci est une question', now(), 1),
          ('Titre de question 2', 'Ceci est une autre question', now(), 2);

INSERT INTO Answers(mainText, datetimestamp, solution,  idQuestion, idUser)
   VALUES ('Ceci est une réponse qui répond à une question', now(), 1, 1, 1),
          ('Ceci est une autre réponse qui répond à une question', now(), 0, 1, 2),
          ('Ceci est une autre réponse qui répond à une autre question', now(), 1, 2, 2);

INSERT INTO Comments(mainText, datetimestamp, idUser, idAnswer, idQuestion)
   VALUES ('Ceci est un commentaire qui répond à une question', now(), 1, NULL, 1),
          ('Ceci est un commentaire qui répond à une réponse', now(), 1, 1, NULL),
          ('Ceci est un autre commentaire qui répond à une réponse', now(), 2, 1, NULL);
