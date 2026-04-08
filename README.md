# LMS Pédagogique - Plateforme d'Apprentissage Moderne

[![Laravel](https://img.shields.io/badge/Laravel-11-FF2D20?style=for-the-badge&logo=laravel)](https://laravel.com)
[![Vite](https://img.shields.io/badge/Vite-6-646CFF?style=for-the-badge&logo=vite)](https://vitejs.dev)
[![TailwindCSS](https://img.shields.io/badge/TailwindCSS-3-38B2AC?style=for-the-badge&logo=tailwind-css)](https://tailwindcss.com)

Une plateforme de gestion de l'apprentissage (LMS) moderne et intuitive, conçue pour faciliter la création, la gestion et le suivi des formations en ligne. Le projet intègre des fonctionnalités avancées boostées par l'Intelligence Artificielle (Gemini).

## 🚀 Application en ligne
L'application est déployée sur Railway : [lms-pedagogique.up.railway.app](https://web-production-e5d58.up.railway.app)

---

## 👥 Identifiants de test
Pour tester les différentes interfaces, vous pouvez utiliser les comptes suivants :

| Rôle | Email | Mot de passe |
| :--- | :--- | :--- |
| **Administrateur** | `admin@lms.fr` | `password` |
| **Apprenant** | `elevemarie@gmail.com` | `mariemarie` |

---

## ✨ Fonctionnalités

### 🛠️ Espace Administrateur
- **Gestion du Catalogue** : Création et édition de formations, chapitres, sous-chapitres et contenus pédagogiques.
- **Gestion des Utilisateurs** : Inscription et suivi des apprenants.
- **Évaluations** : Création de quiz interactifs avec gestion des questions.
- **Assistant IA (Gemini)** : Assistant intégré pour générer du contenu pédagogique ou aider à la structuration des cours.
- **Importation Intelligente** : Système d'import de contenus facilité par l'IA.

### 🎓 Espace Apprenant
- **Tableau de bord** : Vue globale sur les formations suivies et la progression.
- **Parcours Pédagogique** : Navigation fluide entre les chapitres et les contenus.
- **Quiz et Auto-évaluation** : Passage de quiz en temps réel avec correction immédiate.
- **Suivi des Résultats** : Historique des notes et progression par formation.

---

## 🛠️ Technologies utilisées
- **Framework** : [Laravel 11](https://laravel.com)
- **Frontend** : [Blade](https://laravel.com/docs/11.x/blade), [Tailwind CSS](https://tailwindcss.com), [Alpine.js](https://alpinejs.dev)
- **Build Tool** : [Vite](https://vitejs.dev)
- **Base de données** : SQLite (par défaut)
- **IA** : API Google Gemini (via `AssistantIAController`)

---

## 💻 Installation en local

### Pré-requis
- PHP 8.2+
- Composer
- Node.js & NPM

### Étapes d'installation
1. **Clonage du projet** :
   ```bash
   git clone https://github.com/chaimaBrz/lms-pedagogique.git
   cd lms-pedagogique
   ```

2. **Installation des dépendances PHP** :
   ```bash
   composer install
   ```

3. **Installation des dépendances Frontend** :
   ```bash
   npm install
   ```

4. **Configuration de l'environnement** :
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Préparation de la base de données** :
   ```bash
   touch database/database.sqlite
   php artisan migrate --seed
   ```

6. **Lancement du projet** :
   ```bash
   # Terminal 1 : Serveur PHP
   php artisan serve
   
   # Terminal 2 : Compilation Assets
   npm run dev
   ```

L'application sera accessible sur [http://localhost:8000](http://localhost:8000).

---

## 📁 Structure du projet
- `app/Http/Controllers/` : Logique applicative (séparée entre Admin et Apprenant).
- `app/Models/` : Modèles Eloquent (Formation, Chapitre, SousChapitre, Quiz, etc.).
- `resources/views/` : Interfaces utilisateur basées sur Blade et Tailwind.
- `database/migrations/` : Structure de la base de données.
- `routes/web.php` : Définition des routes et des middlewares de sécurité.

---

⭐ *Projet développé dans le cadre d'une modernisation de plateforme LMS.*
