# 🎓 Mini LMS Pédagogique

> Application de gestion de l'apprentissage (Learning Management System) construite avec **Laravel 11**, **Blade**, **Tailwind CSS** et **SQLite**.

---

## ✨ Fonctionnalités

### Espace Admin
- Gestion complète des **Formations**, **Chapitres**, **Sous-chapitres**
- Gestion des **Contenus pédagogiques** (saisie manuelle + import rapide de texte IA)
- Gestion des **Quiz** avec questions à choix multiple (4 réponses, 1 correcte)
- Gestion des **Apprenants** et inscription à une formation
- Gestion des **Notes** des apprenants (matière + note sur 20)

### Espace Apprenant
- Tableau de bord personnalisé avec la formation inscrite
- Navigation : Formation → Chapitres → Sous-chapitres → Contenus
- Passage de **quiz interactifs** avec calcul du score automatique
- Consultation de ses **notes** et de son **historique de quiz**

### Sécurité
- Authentification via **Laravel Breeze**
- Middleware `admin` et `apprenant` pour séparer les espaces
- L'apprenant ne voit que le contenu de **sa propre formation**

---

## 🛠️ Prérequis

| Outil | Version minimale |
|-------|-----------------|
| PHP | 8.3 |
| Composer | 2.x |
| Node.js | 18.x |
| NPM | 9.x |

---

## 🚀 Installation

### 1. Cloner le projet

```bash
git clone https://github.com/votre-user/mini-lms.git
cd mini-lms
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Configurer l'environnement

```bash
cp .env.example .env
php artisan key:generate
```

> La base de données SQLite est configurée par défaut. Le fichier `database/database.sqlite` sera créé automatiquement.

### 4. Créer et peupler la base de données

```bash
php artisan migrate --seed
```

Cela exécute les migrations + le `DatabaseSeeder` qui crée les deux comptes de base.

Pour ajouter les données de démonstration (formation anglais + quiz) :

```bash
php artisan db:seed --class=ContenusSeeder
php artisan db:seed --class=QuizSeeder
```

### 5. Installer les dépendances JavaScript et compiler les assets

```bash
npm install && npm run dev
```

### 6. Lancer le serveur de développement

```bash
php artisan serve
```

L'application est disponible sur : **http://localhost:8000**

---

## 🔑 Comptes de test

| Rôle | Email | Mot de passe |
|------|-------|--------------|
| **Admin** | admin@lms.fr | password |
| **Apprenant** | apprenant@lms.fr | password |

> L'apprenant de test est automatiquement inscrit à la formation "Anglais niveau débutant".

---

## 🗂️ Structure des entités

```
Formation
└── Chapitre
    └── SousChapitre
        ├── Contenu (texte pédagogique)
        └── Quiz
            └── Question
                └── Reponse

Apprenant (lié à User + Formation)
Note (liée à Apprenant)
ResultatQuiz (lié à User + Quiz)
```

---

## 🧭 Parcours Admin

1. Se connecter avec `admin@lms.fr`
2. Créer une **Formation** (Formations → Nouvelle Formation)
3. Ajouter des **Chapitres** à la formation
4. Ajouter des **Sous-chapitres** à chaque chapitre
5. Rédiger des **Contenus** pédagogiques ou les importer via le bloc IA
6. Créer un **Quiz** avec ses questions et réponses
7. Inscrire un **Apprenant** à la formation
8. Attribuer des **Notes** via le menu Notes

---

## 🎒 Parcours Apprenant

1. Se connecter avec `apprenant@lms.fr`
2. Le dashboard affiche la formation inscrite et ses chapitres
3. Naviguer dans les leçons : **Chapitres → Sous-chapitres → Contenu**
4. Passer un **Quiz** en répondant aux questions
5. Consulter son score et l'historique via **"Mes résultats"**

---

## 🧰 Stack technique

| Couche | Technologie |
|--------|------------|
| Framework | Laravel 11 |
| Auth | Laravel Breeze |
| Frontend | Blade + Tailwind CSS (via Vite) |
| Base de données | SQLite |
| JS Alpine | Alpine.js (inclus avec Breeze) |

---

## 📄 Licence

Projet pédagogique — libre d'utilisation et de modification.
