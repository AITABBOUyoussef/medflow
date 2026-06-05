# 🏥 MedFlow - Plateforme de Gestion de Cabinet Médical

![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-00000F?style=for-the-badge&logo=mysql&logoColor=white)
![TailwindCSS](https://img.shields.io/badge/tailwindcss-%2338B2AC.svg?style=for-the-badge&logo=tailwind-css&logoColor=white)
![JavaScript](https://img.shields.io/badge/javascript-%23323330.svg?style=for-the-badge&logo=javascript&logoColor=%23F7DF1E)

## 📖 À propos du projet
**MedFlow** est une application web développée pour simplifier la prise de rendez-vous médicaux et l'administration d'une clinique. Basée sur une architecture **MVC (Modèle-Vue-Contrôleur)** et un système de contrôle d'accès strict **RBAC (Role-Based Access Control)**, elle offre des interfaces dédiées, sécurisées et intuitives pour chaque type d'utilisateur.

---

## ✨ Fonctionnalités Principales (RBAC)

### 👤 Épic 1 : Espace Patient
- Recherche multicritères de médecins (par nom ou spécialité).
- Consultation des créneaux horaires disponibles.
- Réservation de rendez-vous en temps réel (Statut : `EN_ATTENTE`).
- Tableau de bord personnel : historique des consultations et téléchargement d'ordonnances.

### 👨‍⚕️ Épic 2 : Espace Médecin
- Visualisation du planning hebdomadaire interactif.
- Gestion des rendez-vous : validation (`CONFIRME`) ou annulation (`ANNULE`).
- Clôture des consultations (`TERMINE`).
- Saisie et archivage sécurisé des ordonnances textuelles liées aux rendez-vous.

### ⚙️ Épic 3 : Espace Administration
- Gestion intégrale de l'équipe médicale (Création de comptes, assignation de spécialités, activation/désactivation).
- Gestion du référentiel des spécialités médicales.
- Tableau de bord analytique (KPIs) : taux d'annulation, nombre de consultations, etc.

---

## 🛠️ Architecture & Technologies Utilisées

* **Frontend :** HTML5, Vanilla JavaScript, Tailwind CSS (Design System moderne et Glassmorphism).
* **Backend :** PHP 8+ (Programmation Orientée Objet & Architecture MVC).
* **Base de Données :** MySQL (Modélisation relationnelle avec contraintes d'intégrité).
* **Gestion de Projet :** Méthode Agile (Scrum), Jira, GitHub.

---

## 📊 Modélisation UML & ERD

### 1. Diagramme des Cas d'Utilisation (Use Case)
 
<img width="1017" height="867" alt="usecaqe1" src="https://github.com/user-attachments/assets/09501aa9-614d-450c-a515-146ad2567bc2" />
### 2. Diagramme des Cas Class
<img width="1128" height="891" alt="umlumluml" src="https://github.com/user-attachments/assets/8f554f0d-071a-496e-bbd2-37d64424b810" />
### 3. Diagramme ERD
<img width="1130" height="892" alt="ERD" src="https://github.com/user-attachments/assets/aa0242e3-f344-4925-869e-b7b020e59b26" />
