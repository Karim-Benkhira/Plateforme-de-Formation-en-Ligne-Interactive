# 🚀 BrightPath Installation Guide

## 1. Clone the Repository

```bash
git clone https://github.com/your-username/brightpath.git
cd brightpath
```

## 2. Install PHP Dependencies

Make sure you have [Composer](https://getcomposer.org/) installed.

```bash
composer install
```

## 3. Copy and Configure Environment File

```bash
cp .env.example .env
```

Edit `.env` and set your database and mail credentials.

## 4. Generate Application Key

```bash
php artisan key:generate
```

## 5. Run Migrations

```bash
php artisan migrate
```

## 6. Link Storage

```bash
php artisan storage:link
```

## 7. Start the Development Server

```bash
php artisan serve
```

Visit [http://localhost:8000](http://localhost:8000) in your browser.

---

## Troubleshooting

- Make sure your PHP version matches Laravel’s requirements.
- Ensure your database is running and credentials are correct in `.env`.

---

# 🧑‍💻 BrightPath User Guide

Welcome to BrightPath! This guide will help you get started as a user or admin.

---

## 1. Creating a User Account

1. Visit the [registration page](http://localhost:8000/register).
2. Fill in your name, email, and password.
3. Click **Register**.
4. You can now log in and access your dashboard.

---

## 2. Logging In

1. Go to the [login page](http://localhost:8000/login).
2. Enter your email and password.
3. Click **Login**.

---

## 3. Admin: Creating a Category

1. Log in as an admin.
2. In the sidebar or top menu, click **Categories**.
3. Click **Add Category** or **Create New Category**.
4. Enter the category name and description.
5. Click **Save**.

---

## 4. Admin: Creating a Course

1. Log in as an admin.
2. Click **Courses** in the sidebar or menu.
3. Click **Add Course**.
4. Fill in the course details (title, description, category, etc.).
5. Click **Save**.

---

## 5. Admin: Creating a Quiz

1. Go to the **Quizzes** section.
2. Click **Add Quiz**.
3. Enter the quiz title, select the course, and add questions.
4. For each question, provide options and mark the correct answer (answers separated by commas).
5. Click **Save**.

---

## 6. Enrolling in a Course (User)

1. Log in as a user.
2. Browse the **Courses** page.
3. Click on a course to view content.

---

## 7. Taking a Quiz (User)

1. Go to **the course** detail page.
2. Click on the available quiz.
3. Answer the questions and submit.
4. View your score.

---

## 8. Submitting a Reclamation (User)

1. Go to the **Support** or **Reclamations** section.
2. Fill in the subject and message.
3. Click **Send**.

---

## 9. Managing Reclamations (Agent/Admin)

1. Go to the **Reclamations** section.
2. View the list of submitted reclamations.
3. Click on a reclamation to view details.
4. Respond, mark as resolved, or update the status as needed.

---

## 10. Viewing the Leaderboard

- Go to the **Dashboard**.
- The leaderboard shows the top users by quiz scores.

---

## 11. Logging Out

- Click your profile icon or name in the top right.
- Select **Logout**.

---

**Enjoy learning and managing with BrightPath!**

---