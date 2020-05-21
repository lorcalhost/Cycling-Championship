-- create an empty database. Name of the database: CHAMPIONSHIP
SET storage_engine = InnoDB;
SET FOREIGN_KEY_CHECKS = 1;
CREATE DATABASE IF NOT EXISTS Championship;

-- use CHAMPIONSHIP 
use Championship;


-- drop tables if they already exist
DROP TABLE IF EXISTS Individual_Classification;
DROP TABLE IF EXISTS Cyclist;
DROP TABLE IF EXISTS Team;
DROP TABLE IF EXISTS Stage;

-- create tables
CREATE TABLE Team (
	CodT CHAR(20),
	NameT CHAR(50) NOT NULL,
	FoundationYear YEAR(4) NOT NULL,
	LegalAddress CHAR(100) NOT NULL,
	PRIMARY KEY (CodT)
);

CREATE TABLE Cyclist (
	CodC CHAR(20),
	Name CHAR(50) NOT NULL,
	Surname CHAR(50) NOT NULL,
	Nationality CHAR(20) NOT NULL,
    CodT CHAR(20) NOT NULL,
	BirthYear YEAR(4) NOT NULL,
	PRIMARY KEY (CodC),
    FOREIGN KEY (CodT)
        REFERENCES Team(CodT)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

CREATE TABLE Stage (
    Edition SMALLINT CHECK (Edition > 0),
	CodS SMALLINT CHECK(CodS > 0),
	StartingCity CHAR(20) NOT NULL,
    ArrivalCity CHAR(20) NOT NULL,
    Length INT NOT NULL,
    HeightDifference SMALLINT NOT NULL,
    DifficultyLevel SMALLINT NOT NULL CHECK (DifficultyLevel >= 1 and DifficultyLevel <= 10),
	PRIMARY KEY (Edition, CodS)
);

CREATE TABLE Individual_Classification (
    CodC CHAR(20),
	CodS SMALLINT,
    Edition SMALLINT,
    Ranking SMALLINT NOT NULL CHECK (Ranking > 0),
	PRIMARY KEY (CodC, CodS, Edition),
    FOREIGN KEY (CodC)
		REFERENCES Cyclist(CodC) 
		ON DELETE RESTRICT
		ON UPDATE CASCADE,
    FOREIGN KEY (Edition, CodS)
		REFERENCES Stage(Edition, CodS) 
		ON DELETE RESTRICT
		ON UPDATE CASCADE
);

-- Insert data
INSERT INTO Team (CodT, NameT, FoundationYear, LegalAddress)
VALUES ('AG2R', 'AG2R La Mondiale', 1992, '23, rue du Puits Romain L-8070 Bertrange, Luxembourg');
INSERT INTO Team (CodT, NameT, FoundationYear, LegalAddress)
VALUES ('BML', 'Bahrain - McLaren', 2017, 'Building 800, Road 123, Block 701, Tubili, Bahrain');
INSERT INTO Team (CodT, NameT, FoundationYear, LegalAddress)
VALUES ('APT', 'Astana Pro Team', 2007, '37, Rue des Scillas L-2529 Luxembourg');

INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('AG2R-1', 'Chris', 'Moore', 'British', 'AG2R', 1985);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('AG2R-2', 'Lance', 'Armstrong', 'American', 'AG2R', 1971);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('AG2R-3', 'Laurent', 'Fignon', 'French', 'AG2R', 1960);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('BML-1', 'Andy', 'Schleck', 'Luxembourgian', 'BML', 1985);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('BML-2', 'Cadel', 'Evans', 'Australian', 'BML', 1977);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('BML-3', 'Fabian', 'Cancellara', 'Swiss', 'BML', 1981);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('APT-1', 'Peter', 'Sagan', 'Slovak', 'APT', 1990);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('APT-2', 'Chris', 'Froome', 'British', 'APT', 1985);
INSERT INTO Cyclist (CodC, Name, Surname, Nationality, CodT, BirthYear)
VALUES ('APT-3', 'Maximilian', 'Schachmann', 'German', 'APT', 1994);

INSERT INTO Stage (Edition, CodS, StartingCity, ArrivalCity, Length, HeightDifference, DifficultyLevel)
VALUES (1, 1, "Turin", "Milan", 141200, 119, 4);
INSERT INTO Stage (Edition, CodS, StartingCity, ArrivalCity, Length, HeightDifference, DifficultyLevel)
VALUES (2, 1, "Turin", "Milan", 141200, 119, 4);
INSERT INTO Stage (Edition, CodS, StartingCity, ArrivalCity, Length, HeightDifference, DifficultyLevel)
VALUES (1, 2, "Beijing", "Shanghai", 1088000, 40, 10);

INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-1', 1, 1, 1);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-2', 1, 1, 2);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-3', 1, 1, 3);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-1', 1, 1, 4);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-2', 1, 1, 5);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-3', 1, 1, 6);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-1', 1, 1, 7);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-2', 1, 1, 8);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-3', 1, 1, 9);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-1', 1, 2, 9);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-2', 1, 2, 5);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-3', 1, 2, 2);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-1', 1, 2, 6);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-2', 1, 2, 8);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-3', 1, 2, 3);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-1', 1, 2, 7);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-2', 1, 2, 1);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-3', 1, 2, 4);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-1', 2, 1, 2);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-2', 2, 1, 6);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('AG2R-3', 2, 1, 5);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-1', 2, 1, 1);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-2', 2, 1, 9);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('BML-3', 2, 1, 7);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-1', 2, 1, 4);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-2', 2, 1, 8);
INSERT INTO Individual_Classification (CodC, CodS, Edition, Ranking)
VALUES ('APT-3', 2, 1, 3);