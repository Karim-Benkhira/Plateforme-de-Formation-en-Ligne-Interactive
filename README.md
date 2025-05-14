# Plateforme Éducative en Ligne

![Logo de la plateforme](public/images/logo.svg)

Plateforme d'apprentissage interactive offrant:
- Gestion complète des cours (texte, PDF, vidéo)
- Génération de quiz par intelligence artificielle
- Examens sécurisés avec reconnaissance faciale
- Tableaux de bord analytiques pour enseignants et étudiants

## 📋 Guide d'installation rapide

### Prérequis

| Composant | Version minimale |
|-----------|------------------|
| PHP       | 8.1+             |
| MySQL     | 5.7+             |
| Node.js   | 14+              |
| Composer  | 2.0+             |

### Option 1: Installation avec Docker (Recommandée)

```bash
# 1. Cloner le dépôt
git clone https://github.com/Karim-Benkhira/Plateforme-de-Formation-en-Ligne-Interactive.git
cd Plateforme-de-Formation-en-Ligne-Interactive

# 2. Lancer l'installation automatisée
chmod +x docker-setup.sh
./docker-setup.sh

# 3. Accéder à l'application
# → http://localhost:8000
# → phpMyAdmin: http://localhost:8080
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

## 👥 Comptes de démonstration

| Rôle       | Email                | Mot de passe |
|------------|----------------------|--------------|
| Admin      | admin@example.com    | password     |
| Enseignant | teacher@example.com  | password     |
| Étudiant   | student@example.com  | password     |

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

### Commandes Docker utiles

```bash
# Démarrer/arrêter les conteneurs
docker-compose up -d
docker-compose down

# Exécuter des commandes Artisan
docker-compose exec app php artisan [commande]

# Accéder au shell
docker-compose exec app bash
```

## 🔧 Résolution des problèmes

| Problème | Solution |
|----------|----------|
| **Content Too Large** | Augmenter `upload_max_filesize` et `post_max_size` dans les paramètres PHP |
| **Problèmes de permissions** | Exécuter `chmod -R 775 storage bootstrap/cache` |
| **Erreurs de base de données** | Vérifier les informations de connexion dans `.env` |
| **Method Not Allowed** | Utiliser la méthode HTTP correcte (POST pour les formulaires) |

## 📄 Licence

Ce projet est sous licence [MIT](LICENSE).

---

Pour toute question ou assistance supplémentaire, veuillez consulter la documentation ou contacter l'équipe de développement.
