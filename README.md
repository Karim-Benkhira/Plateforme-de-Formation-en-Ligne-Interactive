# Plateforme Éducative en Ligne Interactive

![Logo de la plateforme](public/images/logo.svg)

Plateforme d'apprentissage interactive offrant:
- Gestion complète des cours (texte, PDF, vidéo)
- Génération de quiz par intelligence artificielle
- Examens sécurisés avec reconnaissance faciale
- Tableaux de bord analytiques pour enseignants et étudiants

## 🐳 Installation avec Docker (Recommandée)

### Prérequis

| Système | Composants requis |
|---------|-------------------|
| **Linux** | Docker, Docker Compose, Git |
| **Windows** | Docker Desktop, Git |
| **macOS** | Docker Desktop, Git |

### 🐧 Installation sur Linux

```bash
# 1. Installer Docker et Docker Compose
sudo apt update
sudo apt install docker.io docker-compose git -y

# 2. Ajouter votre utilisateur au groupe docker
sudo usermod -aG docker $USER
newgrp docker

# 3. Cloner le projet
git clone https://github.com/Karim-Benkhira/Plateforme-de-Formation-en-Ligne-Interactive.git
cd Plateforme-de-Formation-en-Ligne-Interactive

# 4. Démarrer les conteneurs
docker-compose up -d

# 5. Installer les dépendances Laravel
docker-compose exec app composer install

# 6. Générer la clé d'application
docker-compose exec app php artisan key:generate

# 7. Exécuter les migrations
docker-compose exec app php artisan migrate --seed

# 8. Créer les liens symboliques
docker-compose exec app php artisan storage:link

# 9. Accéder à l'application
# → http://localhost:8000
```

### 🪟 Installation sur Windows

```powershell
# 1. Installer Docker Desktop depuis https://www.docker.com/products/docker-desktop
# 2. Installer Git depuis https://git-scm.com/download/win
# 3. Redémarrer votre ordinateur après l'installation

# 4. Ouvrir PowerShell ou Command Prompt
# 5. Cloner le projet
git clone https://github.com/Karim-Benkhira/Plateforme-de-Formation-en-Ligne-Interactive.git
cd Plateforme-de-Formation-en-Ligne-Interactive

# 6. Démarrer les conteneurs
docker-compose up -d

# 7. Installer les dépendances Laravel
docker-compose exec app composer install

# 8. Générer la clé d'application
docker-compose exec app php artisan key:generate

# 9. Exécuter les migrations
docker-compose exec app php artisan migrate --seed

# 10. Créer les liens symboliques
docker-compose exec app php artisan storage:link

# 11. Accéder à l'application
# → http://localhost:8000
```

### Option 2: Installation manuelle

```bash
# 1. Cloner le dépôt
git clone https://github.com/votre-utilisateur/education-platform.git
cd education-platform

# 2. Installer les dépendances
composer install
npm install && npm run build

# 3. Configurer l'environnement
cp .env.example .env
php artisan key:generate

# 4. Configurer la base de données dans .env
# DB_DATABASE=education
# DB_USERNAME=root
# DB_PASSWORD=votre_mot_de_passe

# 5. Créer la base de données
mysql -u root -p -e "CREATE DATABASE education CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"

# 6. Exécuter les migrations et seeders
php artisan migrate --seed
php artisan storage:link

# 7. Démarrer le serveur
php artisan serve
# → http://127.0.0.1:8000
```

## 🚨 Résolution des problèmes courants

### Problème: "419 | PAGE EXPIRED"
```bash
# Solution: Vérifier le fichier public/index.php
# Assurez-vous qu'il commence par <?php sans aucun contenu HTML avant

# Nettoyer le cache
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan key:generate
```

### Problème: "Permission denied" sur Linux
```bash
# Donner les bonnes permissions
sudo chown -R $USER:$USER .
chmod -R 755 storage bootstrap/cache
docker-compose exec app chmod -R 777 /var/www/storage
```

### Problème: "Port already in use"
```bash
# Vérifier les ports utilisés
docker ps
netstat -tulpn | grep :8000

# Arrêter les conteneurs existants
docker-compose down
docker system prune -f

# Redémarrer
docker-compose up -d
```

### Problème: "Database connection refused"
```bash
# Vérifier que MySQL est démarré
docker-compose ps

# Redémarrer la base de données
docker-compose restart db

# Vérifier les logs
docker-compose logs db
```

### Problème: "Composer install fails"
```bash
# Nettoyer et réinstaller
docker-compose exec app rm -rf vendor composer.lock
docker-compose exec app composer clear-cache
docker-compose exec app composer install --no-dev --optimize-autoloader
```

### Problème: "Storage link not working"
```bash
# Recréer le lien symbolique
docker-compose exec app php artisan storage:link --force
```

## 👥 Comptes par défaut

**Ces comptes sont automatiquement créés lors de l'exécution de `php artisan migrate --seed`**

| Rôle       | Email                | Mot de passe | Nom d'utilisateur |
|------------|----------------------|--------------|-------------------|
| **Admin**  | test@example.com     | password     | testadmin         |
| **Admin**  | admin@test.com       | password     | admin             |
| **Enseignant** | teacher@test.com | password     | teacher           |
| **Étudiant** | student@test.com   | password     | student           |

### 🚀 Accès rapide
1. Aller à: `http://localhost:8000/login`
2. Utiliser n'importe quel compte ci-dessus
3. Mot de passe pour tous: `password`

> **Note**: Ces comptes sont créés automatiquement par le seeder et seront disponibles sur toute nouvelle installation du projet.

## 🚀 Fonctionnalités principales

### Pour les enseignants
- Création de cours avec contenu multimédia
- Génération automatique de quiz par IA
- Surveillance des examens avec reconnaissance faciale
- Analyse des performances des étudiants

### Pour les étudiants
- Interface intuitive d'apprentissage
- Accès à divers formats de contenu pédagogique
- Quiz interactifs avec feedback immédiat
- Suivi de progression personnalisé

### Pour les administrateurs
- Gestion complète des utilisateurs
- Supervision des cours et catégories
- Tableaux de bord analytiques
- Gestion des réclamations

## ⚙️ Configuration avancée

### Augmenter les limites de téléchargement

Créez ou modifiez `public/.user.ini`:
```ini
upload_max_filesize = 100M
post_max_size = 100M
max_execution_time = 300
memory_limit = 256M
```

## 🛠️ Commandes Docker utiles

```bash
# Démarrer/arrêter les conteneurs
docker-compose up -d                    # Démarrer en arrière-plan
docker-compose down                     # Arrêter et supprimer les conteneurs
docker-compose restart                  # Redémarrer tous les services

# Gestion des conteneurs
docker-compose ps                       # Voir l'état des conteneurs
docker-compose logs app                 # Voir les logs de l'application
docker-compose logs db                  # Voir les logs de la base de données

# Exécuter des commandes Laravel
docker-compose exec app php artisan migrate
docker-compose exec app php artisan cache:clear
docker-compose exec app php artisan config:clear
docker-compose exec app php artisan route:list

# Accéder aux shells
docker-compose exec app bash           # Shell de l'application
docker-compose exec db mysql -u root -p # Console MySQL

# Gestion des volumes et nettoyage
docker-compose down -v                 # Supprimer aussi les volumes
docker system prune -f                 # Nettoyer le système Docker
```

## 🔗 URLs d'accès

| Service | URL | Description |
|---------|-----|-------------|
| **Application** | http://localhost:8000 | Interface principale |
| **phpMyAdmin** | http://localhost:8081 | Gestion base de données |
| **pgAdmin** | http://localhost:5050 | Interface PostgreSQL (si utilisé) |

## 📊 Informations de base de données

| Paramètre | Valeur |
|-----------|--------|
| **Host** | localhost (ou db depuis les conteneurs) |
| **Port** | 3307 (externe), 3306 (interne) |
| **Database** | education |
| **Username** | root |
| **Password** | StrongP@ssw0rd! |

## 📄 Licence

Ce projet est sous licence [MIT](LICENSE).

---

Pour toute question ou assistance supplémentaire, veuillez consulter la documentation ou contacter l'équipe de développement.
