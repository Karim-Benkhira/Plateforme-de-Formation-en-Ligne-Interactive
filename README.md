# Plateforme d'Apprentissage en Ligne

Une plateforme d'apprentissage interactive avec gestion des cours, génération de quiz par IA, et reconnaissance faciale pour des examens sécurisés.

![Logo de la plateforme](public/images/logo.png)

## 📋 Prérequis

Avant de commencer, assurez-vous d'avoir installé les éléments suivants sur votre machine locale:

- [PHP](https://www.php.net/downloads) (version 8.1 ou supérieure)
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/) (version 14 ou supérieure)
- [npm](https://www.npmjs.com/get-npm) ou [Yarn](https://yarnpkg.com/getting-started/install)
- [MySQL](https://dev.mysql.com/downloads/mysql/) (version 5.7 ou supérieure)
- [Git](https://git-scm.com/downloads)

## 🚀 Installation

Suivez ces étapes pour installer et configurer le projet sur votre environnement local:

### 1. Cloner le dépôt

```bash
git clone https://github.com/votre-nom-utilisateur/nom-du-depot.git
cd nom-du-depot
```

### 2. Installer les dépendances PHP

```bash
composer install
```

### 3. Installer les dépendances JavaScript

```bash
npm install
# ou si vous utilisez Yarn
yarn install
```

### 4. Compiler les assets

```bash
npm run dev
# ou si vous utilisez Yarn
yarn dev
```

### 5. Configurer le fichier d'environnement

```bash
cp .env.example .env
php artisan key:generate
```

### 6. Configurer la base de données

Ouvrez le fichier `.env` et configurez les paramètres de votre base de données:

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=education
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

### 7. Créer la base de données

Connectez-vous à MySQL et créez une base de données nommée `education`:

```sql
CREATE DATABASE education CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 8. Exécuter les migrations et les seeders

```bash
php artisan migrate
php artisan db:seed
```

### 9. Créer un lien symbolique pour le stockage

```bash
php artisan storage:link
```

### 10. Démarrer le serveur de développement

```bash
php artisan serve
```

Votre application sera accessible à l'adresse [http://127.0.0.1:8000](http://127.0.0.1:8000).

## 🔐 Authentification

### Comptes par défaut

Après avoir exécuté les seeders, les comptes suivants seront disponibles:

- **Admin**:
  - Email: admin@example.com
  - Mot de passe: password

- **Enseignant**:
  - Email: teacher@example.com
  - Mot de passe: password

- **Étudiant**:
  - Email: student@example.com
  - Mot de passe: password

## 📝 Configuration supplémentaire

### Augmenter la taille maximale des fichiers téléchargés

Si vous rencontrez des problèmes lors du téléchargement de fichiers volumineux, vous devrez modifier les paramètres PHP:

1. Créez ou modifiez le fichier `public/.user.ini`:

```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
max_input_time = 300
memory_limit = 256M
```

2. Ou modifiez votre fichier `php.ini` global avec les mêmes paramètres.

### Configuration de la reconnaissance faciale

La fonctionnalité de reconnaissance faciale utilise la bibliothèque face-api.js. Les modèles sont déjà inclus dans le projet.

## 🛠️ Résolution des problèmes courants

### Erreur "Content Too Large"

Si vous rencontrez cette erreur lors de l'envoi de formulaires:

1. Vérifiez que les paramètres PHP pour `upload_max_filesize` et `post_max_size` sont suffisamment élevés.
2. Redémarrez votre serveur PHP après avoir modifié ces paramètres.

### Problèmes de permissions

Si vous rencontrez des problèmes de permissions sur les dossiers de stockage:

```bash
chmod -R 775 storage bootstrap/cache
```

### Erreurs de base de données

Si vous rencontrez des erreurs liées à la base de données:

1. Vérifiez que votre serveur MySQL est en cours d'exécution.
2. Vérifiez que les informations de connexion dans le fichier `.env` sont correctes.
3. Assurez-vous que la base de données `education` existe.

## 📚 Fonctionnalités principales

- **Gestion des cours**: Création et gestion de cours avec différents types de contenu (texte, PDF, vidéo, YouTube).
- **Génération de quiz par IA**: Création automatique de quiz basés sur le contenu des cours.
- **Examens sécurisés**: Vérification de l'identité des étudiants par reconnaissance faciale.
- **Tableau de bord analytique**: Suivi des performances des étudiants et des statistiques des cours.

## 📱 Captures d'écran

![Tableau de bord](screenshots/dashboard.png)
![Page des cours](screenshots/courses.png)
![Examen sécurisé](screenshots/secure-exam.png)

## 📄 Licence

Ce projet est sous licence [MIT](LICENSE).
