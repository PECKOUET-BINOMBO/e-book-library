# E-book Library

**Description :**
E-book Library est une application de gestion de livre électronique, elle permet entre autre à un utilisateur de pouvoir emprunter un ou plusieurs livre(s) électronique(s) et de les rendre. L'utilisateur devra créer un compte et aura la possibilité de consulter son profil, le modifier, supprimer son compte ou voir son historique d'emprunt(s). De même l'administrateur pourra créer des compte admin dont les proprietaires recevront leurs identifiants par mail, qu'ils pourront modifer une fois connecter. Un admin pourra créer des comptes et les gérer, ajouter et géere des livres, categories, auteurs, éditeurs, ... Consulter la liste des utilsateurs, des livres et voir un état actuel de la librairie (le nombre de livre disponible, emprunté,...)

## Fonctionnalités

Liste des fonctionnalités principales de l'application.
- Authentification des utilisateurs, Admin et gestion des rôles,
- consultation du profil, historique d'emprunt et suppression compte
- Emprunt et retour de livre
- COnsultation d el'état de la Librairie par les administrateurs
## Prérequis

- **PHP** : "^8.2"
- **Composer** : Gestionnaire de dépendances PHP
- **Base de données** : 

## Installation

1. **Cloner le dépôt :**
   ```bash
   git clone https://github.com/PECKOUET-BINOMBO/bibliothèque-de-livres-électroniques.git
   cd nom-du-projet
   ```

2. **Installer les dépendances :**
   ```bash
   composer install
   npm install
   npm run dev
   ```

3. **Configurer l'environnement :**
   - Copier le fichier `.env.example` et renommez-le en `.env`.
   - Modifier les variables d'environnement dans `.env` selon vos configurations locales (base de données, mail, etc.).

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Migrer la base de données :**
   ```bash
   php artisan migrate --seed
   ```

5. **Lancer le serveur :**
   ```bash
   php artisan serve
   ```

## Utilisation

- **URL de base** : `http://localhost:8000`
- **Informations de connexion :** Si vous avez créé un utilisateur admin par défaut, indiquer les identifiants ici.


## Contribuer

Les contributions sont les bienvenues ! Pour contribuer :

1. Forker le projet
2. Créer une nouvelle branche (`git checkout -b feature/ma-nouvelle-fonctionnalité`)
3. Commiter vos changements (`git commit -m 'Ajouter une nouvelle fonctionnalité'`)
4. Pousser votre branche (`git push origin feature/ma-nouvelle-fonctionnalité`)
5. Ouvrir une Pull Request

## Licence

Ce projet n'est pas sous licence.

## Auteurs

- **Paul Emile PECKOUET-BINOMBO** - *Developpeur Fullstack* - [GitHub](https://github.com/PECKOUET-BINOMBO)

