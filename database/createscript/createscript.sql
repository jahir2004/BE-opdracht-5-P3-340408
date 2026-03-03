drop database if exists jamin_be_opdr4;
create database jamin_be_opdr4;
use jamin_be_opdr4;

CREATE TABLE Product (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255),
    Barcode VARCHAR(13)
);

CREATE TABLE Magazijn (
    Id INT PRIMARY KEY,
    ProductId INT,
    VerpakkingsEenheid DECIMAL(10, 2),
    AantalAanwezig INT,
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

CREATE TABLE ProductPerAllergeen (
    Id INT PRIMARY KEY,
    ProductId INT,
    AllergeenId INT,
    FOREIGN KEY (ProductId) REFERENCES Product(Id),
    FOREIGN KEY (AllergeenId) REFERENCES Allergeen(Id)
);

CREATE TABLE Allergeen (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255),
    Omschrijving TEXT
);

CREATE TABLE ProductPerLeverancier (
    Id INT PRIMARY KEY,
    LeverancierId INT,
    ProductId INT,
    DatumLevering DATE,
    Aantal INT,
    DatumEerstVolgendeLevering DATE,
    FOREIGN KEY (LeverancierId) REFERENCES Leverancier(Id),
    FOREIGN KEY (ProductId) REFERENCES Product(Id)
);

CREATE TABLE Leverancier (
    Id INT PRIMARY KEY,
    Naam VARCHAR(255),
    ContactPersoon VARCHAR(255),
    LeverancierNummer VARCHAR(20),
    Mobiel VARCHAR(15),
    ContactId INT,
    FOREIGN KEY (ContactId) REFERENCES Contact(Id)
);

CREATE TABLE Contact (
    Id INT PRIMARY KEY,
    Straat VARCHAR(255),
    Huisnummer INT,
    Postcode VARCHAR(10),
    Stad VARCHAR(255)
);