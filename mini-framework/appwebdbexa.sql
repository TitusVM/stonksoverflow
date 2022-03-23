DROP DATABASE IF EXISTS appWeb2StonksOverflow;
CREATE DATABASE appWeb2StonksOverflow
  CHARACTER SET 'utf8mb4'
  COLLATE 'utf8mb4_unicode_ci';

USE appWeb2StonksOverflow;

CREATE TABLE Users(
   id INT,
   username VARCHAR(50) NOT NULL,
   passwd VARCHAR(50) NOT NULL,
   PRIMARY KEY(id),
   UNIQUE(username)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Questions(
   id INT,
   mainText TEXT,
   datetimestamp DATETIME NOT NULL,
   idUser INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idUser) REFERENCES Users(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Answers(
   id INT,
   mainText TEXT,
   datetimestamp DATETIME NOT NULL,
   solution LOGICAL NOT NULL,
   idQuestion INT NOT NULL,
   idUser INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idQuestion) REFERENCES Questions(id),
   FOREIGN KEY(idUser) REFERENCES Users(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE Comments(
   id INT,
   mainText TEXT,
   datetimestamp DATETIME NOT NULL,
   idUser INT NOT NULL,
   idAnswer INT NOT NULL,
   idQuestion INT NOT NULL,
   PRIMARY KEY(id),
   FOREIGN KEY(idUsers) REFERENCES Users(id),
   FOREIGN KEY(idAnswer) REFERENCES Answers(id),
   FOREIGN KEY(idQuestion) REFERENCES Questions(id)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

ALTER TABLE Users AUTO_INCREMENT = 1;
ALTER TABLE Questions AUTO_INCREMENT = 1;
ALTER TABLE Answers AUTO_INCREMENT = 1;
ALTER TABLE Comments AUTO_INCREMENT = 1;

INSERT INTO Comments(mainText, datetimestamp, idUser, idAnswer, idQuestion)
   VALUES ('Ceci est un commentaire qui répond à une question', now(), 1, 0, 1),
          ('Ceci est un commentaire qui répond à une réponse', now(), 1, 1, 0),
          ('Ceci est un commentaire qui répond à un commentaire', now(), 2, 1, 0);

INSERT INTO Answers(mainText, datetimestamp, solution,  idQuestion, idUser)
   VALUES ('Ceci est une réponse qui répond à une question', now(), 0, 1, 1),
          ('Ceci est une réponse qui répond à une réponse', now(), 1, 1, 2);

INSERT INTO Questions(mainText, datetimestamp, idQuestion, idUser)
   VALUES ('Ceci est une réponse qui répond à une question', now(), 1, 1),
          ('Ceci est une réponse qui répond à une réponse', now(), 1, 2);

INSERT INTO Users(mainText, datetimestamp, idUser)
   VALUES ('Ceci est une question', now(), 1);