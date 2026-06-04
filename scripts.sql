CREATE DATABASE medflow;
USE medflow;

CREATE TABLE roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    label VARCHAR(50) NOT NULL UNIQUE
);


CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role_id INT NOT NULL,
    CONSTRAINT fk_user_role
        FOREIGN KEY (role_id)
        REFERENCES roles(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);


CREATE TABLE patients (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    birth_date DATE,
    CONSTRAINT fk_patient_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

-- =========================
-- SPECIALITES
-- =========================
CREATE TABLE specialites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(100) NOT NULL UNIQUE
);

 
CREATE TABLE medecins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL UNIQUE,
    specialite_id INT NOT NULL,

    CONSTRAINT fk_medecin_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_medecin_specialite
        FOREIGN KEY (specialite_id)
        REFERENCES specialites(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
);

 
CREATE TABLE disponibilites (
    id INT AUTO_INCREMENT PRIMARY KEY,
    medecin_id INT NOT NULL,
    date DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL,
    disponible BOOLEAN DEFAULT TRUE,

    CONSTRAINT fk_disponibilite_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecins(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

 
CREATE TABLE rendez_vous (
    id INT AUTO_INCREMENT PRIMARY KEY,
    patient_id INT NOT NULL,
    medecin_id INT NOT NULL,
    date_rdv DATE NOT NULL,

    status ENUM(
        'EN_ATTENTE',
        'CONFIRME',
        'ANNULE',
        'TERMINE'
    ) DEFAULT 'EN_ATTENTE',

    CONSTRAINT fk_rdv_patient
        FOREIGN KEY (patient_id)
        REFERENCES patients(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_rdv_medecin
        FOREIGN KEY (medecin_id)
        REFERENCES medecins(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);
 
 
CREATE TABLE ordonnances (
    id INT AUTO_INCREMENT PRIMARY KEY,
    rendez_vous_id INT NOT NULL UNIQUE,
    contenu TEXT NOT NULL,

    CONSTRAINT fk_ordonnance_rdv
        FOREIGN KEY (rendez_vous_id)
        REFERENCES rendez_vous(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
);

 

INSERT INTO roles (label) VALUES
('ADMIN'),
('MEDECIN'),
('PATIENT');

INSERT INTO specialites (nom) VALUES
('Cardiologue'),
('Dentiste'),
('Pediatre'),
('Generaliste'),
('Dermatologue');