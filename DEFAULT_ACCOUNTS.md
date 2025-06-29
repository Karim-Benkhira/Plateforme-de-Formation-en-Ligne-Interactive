# Default User Accounts

This document lists the default user accounts that are automatically created when setting up the project from scratch.

## 🚀 Quick Setup

After cloning the project and running migrations, execute the seeder to create default accounts:

```bash
# Run migrations
php artisan migrate

# Create default accounts
php artisan db:seed
```

## 👑 Admin Accounts

### Primary Admin Account
- **Email**: `test@example.com`
- **Password**: `password`
- **Username**: `testadmin`
- **Role**: `admin`
- **Access**: Full admin dashboard and all features

### Secondary Admin Account
- **Email**: `admin@test.com`
- **Password**: `password`
- **Username**: `admin`
- **Role**: `admin`
- **Access**: Full admin dashboard and all features

## 👨‍🏫 Teacher Account

- **Email**: `teacher@test.com`
- **Password**: `password`
- **Username**: `teacher`
- **Role**: `teacher`
- **Access**: Teacher dashboard, course management, quiz creation

## 👨‍🎓 Student Account

- **Email**: `student@test.com`
- **Password**: `password`
- **Username**: `student`
- **Role**: `user`
- **Access**: Student dashboard, course enrollment, AI practice

## 🔄 Fresh Installation Process

When someone clones the project and sets it up locally:

1. **Clone the repository**
   ```bash
   git clone [repository-url]
   cd Plateforme-de-Formation-en-Ligne-Interactive
   ```

2. **Set up Docker environment**
   ```bash
   docker-compose up -d
   ```

3. **Install dependencies**
   ```bash
   docker-compose exec app composer install
   ```

4. **Set up environment**
   ```bash
   cp .env.example .env
   docker-compose exec app php artisan key:generate
   ```

5. **Run migrations**
   ```bash
   docker-compose exec app php artisan migrate
   ```

6. **Seed default accounts** (This step creates all the accounts above)
   ```bash
   docker-compose exec app php artisan db:seed
   ```

7. **Access the application**
   - URL: `http://localhost:8000`
   - Login with any of the accounts listed above

## ✅ Verification

After running the seeder, you can verify the accounts were created:

```bash
docker-compose exec app php artisan tinker --execute="
use App\Models\User;
echo 'Admin accounts: ' . User::where('role', 'admin')->count() . PHP_EOL;
echo 'All users: ' . User::count() . PHP_EOL;
"
```

## 🔐 Security Notes

### For Development:
- These default accounts are perfect for development and testing
- All accounts use the simple password `password` for convenience

### For Production:
- **IMPORTANT**: Change all default passwords before deploying to production
- Consider removing or disabling default accounts in production
- Use strong, unique passwords for all accounts

## 🛠️ Customization

### Adding More Default Accounts

Edit `database/seeders/DatabaseSeeder.php` and add more accounts in the `createDefaultAdminAccounts()` method:

```php
User::firstOrCreate(
    ['email' => 'your-email@example.com'],
    [
        'username' => 'your-username',
        'password' => bcrypt('your-password'),
        'role' => 'admin', // or 'teacher', 'user'
        'email_verified_at' => now(),
    ]
);
```

### Changing Default Passwords

In the same file, modify the `password` field:

```php
'password' => bcrypt('your-new-password'),
```

## 📋 Account Summary Table

| Email | Username | Password | Role | Dashboard Access |
|-------|----------|----------|------|------------------|
| `test@example.com` | `testadmin` | `password` | `admin` | `/admin` |
| `admin@test.com` | `admin` | `password` | `admin` | `/admin` |
| `teacher@test.com` | `teacher` | `password` | `teacher` | `/teacher` |
| `student@test.com` | `student` | `password` | `user` | `/student` |

## 🎯 Ready to Use

These accounts are automatically created and ready to use immediately after running the seeder. No additional setup required!

### Quick Login Test:
1. Go to `http://localhost:8000/login`
2. Use `test@example.com` / `password`
3. You'll be redirected to the admin dashboard

---

**Note**: These accounts are created using `firstOrCreate()` so they won't be duplicated if you run the seeder multiple times.
