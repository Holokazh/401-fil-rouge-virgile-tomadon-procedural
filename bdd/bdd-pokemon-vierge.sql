DROP DATABASE IF EXISTS pokemon;

CREATE DATABASE IF NOT EXISTS pokemon;

USE pokemon;

CREATE TABLE IF NOT EXISTS Type (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    caracteristique TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS Attaque (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS Attaque_Type (
    AttaqueId INT NOT NULL,
    TypeId INT NOT NULL
);

CREATE TABLE IF NOT EXISTS Pokemon (
    id INT PRIMARY KEY NOT NULL AUTO_INCREMENT,
    nom VARCHAR(50) NOT NULL,
    numero INT NOT NULL,
    typeId INT,
    image VARCHAR(255) NOT NULL
);

ALTER TABLE Attaque_Type ADD PRIMARY KEY IF NOT EXISTS (AttaqueId, TypeId);
ALTER TABLE Attaque_Type ADD FOREIGN KEY IF NOT EXISTS (AttaqueId) REFERENCES Attaque(id) ON DELETE CASCADE;
ALTER TABLE Attaque_Type ADD FOREIGN KEY IF NOT EXISTS (TypeId) REFERENCES Type(id) ON DELETE CASCADE;
ALTER TABLE Pokemon ADD FOREIGN KEY IF NOT EXISTS (TypeId) REFERENCES Type(id);