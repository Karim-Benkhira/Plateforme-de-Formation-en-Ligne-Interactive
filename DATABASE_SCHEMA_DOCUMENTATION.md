# Database Schema Documentation

## 📊 Complete Database Schema

### Core Tables

#### 1. **users** (Authentication & User Management)
```sql
- id: bigint (PK, auto_increment)
- name: varchar(255)
- email: varchar(255) UNIQUE
- email_verified_at: timestamp NULL
- password: varchar(255)
- role: enum('admin', 'teacher', 'student') DEFAULT 'student'
- profile_picture: varchar(255) NULL
- bio: text NULL
- phone: varchar(255) NULL
- date_of_birth: date NULL
- address: text NULL
- is_active: boolean DEFAULT true
- last_login_at: timestamp NULL
- remember_token: varchar(100) NULL
- created_at: timestamp
- updated_at: timestamp
```

#### 2. **categories** (Course Categories)
```sql
- id: bigint (PK, auto_increment)
- name: varchar(255)
- description: text NULL
- image: varchar(255) NULL
- is_active: boolean DEFAULT true
- created_at: timestamp
- updated_at: timestamp
```

#### 3. **courses** (Main Course Entity)
```sql
- id: bigint (PK, auto_increment)
- title: varchar(255)
- description: text
- image: varchar(255) NULL
- category_id: bigint (FK → categories.id)
- teacher_id: bigint (FK → users.id)
- level: enum('beginner', 'intermediate', 'advanced') DEFAULT 'beginner'
- duration: int (minutes)
- price: decimal(8,2) DEFAULT 0.00
- is_published: boolean DEFAULT false
- enrollment_limit: int NULL
- prerequisites: text NULL
- learning_objectives: text NULL
- created_at: timestamp
- updated_at: timestamp
```

#### 4. **sections** (Course Sections)
```sql
- id: bigint (PK, auto_increment)
- course_id: bigint (FK → courses.id)
- title: varchar(255)
- description: text NULL
- order: int DEFAULT 0
- is_published: boolean DEFAULT true
- created_at: timestamp
- updated_at: timestamp
```

#### 5. **lessons** (Individual Lessons)
```sql
- id: bigint (PK, auto_increment)
- section_id: bigint (FK → sections.id)
- title: varchar(255)
- content: longtext
- video_url: varchar(255) NULL
- duration: int NULL (minutes)
- order: int DEFAULT 0
- is_published: boolean DEFAULT true
- created_at: timestamp
- updated_at: timestamp
```

#### 6. **contents** (Additional Course Content)
```sql
- id: bigint (PK, auto_increment)
- course_id: bigint (FK → courses.id)
- title: varchar(255)
- content: longtext
- type: enum('text', 'video', 'pdf', 'link') DEFAULT 'text'
- file_path: varchar(255) NULL
- order: int DEFAULT 0
- is_published: boolean DEFAULT true
- created_at: timestamp
- updated_at: timestamp
```

### Assessment Tables

#### 7. **quizzes** (Course Quizzes)
```sql
- id: bigint (PK, auto_increment)
- course_id: bigint (FK → courses.id)
- name: varchar(255)
- description: text NULL
- duration: int (minutes)
- passing_score: int DEFAULT 70
- max_attempts: int DEFAULT 3
- is_published: boolean DEFAULT false
- randomize_questions: boolean DEFAULT false
- show_results: boolean DEFAULT true
- created_at: timestamp
- updated_at: timestamp
```

#### 8. **questions** (Quiz Questions)
```sql
- id: bigint (PK, auto_increment)
- quiz_id: bigint (FK → quizzes.id)
- question: text
- type: enum('multiple_choice', 'true_false', 'short_answer') DEFAULT 'multiple_choice'
- options: json NULL
- correct_answer: text
- explanation: text NULL
- points: int DEFAULT 1
- order: int DEFAULT 0
- created_at: timestamp
- updated_at: timestamp
```

#### 9. **quiz_results** (Student Quiz Results)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id)
- quiz_id: bigint (FK → quizzes.id)
- correct_answers: int DEFAULT 0
- answers_count: int DEFAULT 0
- score: decimal(5,2) DEFAULT 0.00
- details: json NULL
- started_at: timestamp NULL
- completed_at: timestamp NULL
- created_at: timestamp
- updated_at: timestamp
```

### AI Practice System Tables

#### 10. **practice_sessions** (AI Quiz Sessions)
```sql
- id: bigint (PK, auto_increment)
- session_id: varchar(255) UNIQUE
- user_id: bigint (FK → users.id)
- course_id: bigint (FK → courses.id)
- total_questions: int DEFAULT 0
- difficulty: enum('easy', 'medium', 'hard') DEFAULT 'medium'
- question_type: enum('multiple_choice', 'true_false', 'mixed') DEFAULT 'multiple_choice'
- language: varchar(10) DEFAULT 'en'
- questions_answered: int DEFAULT 0
- correct_answers: int DEFAULT 0
- score_percentage: decimal(5,2) DEFAULT 0.00
- started_at: timestamp NULL
- completed_at: timestamp NULL
- total_time_seconds: int NULL
- ai_service_used: varchar(50) NULL
- used_fallback: boolean DEFAULT false
- content_summary: text NULL
- status: enum('active', 'completed', 'abandoned') DEFAULT 'active'
- created_at: timestamp
- updated_at: timestamp
```

#### 11. **practice_questions** (AI Generated Questions)
```sql
- id: bigint (PK, auto_increment)
- session_id: varchar(255) (FK → practice_sessions.session_id)
- question_id: varchar(255)
- question_text: text
- question_type: enum('multiple_choice', 'true_false', 'short_answer') DEFAULT 'multiple_choice'
- options: json NULL
- correct_answer: text
- explanation: text NULL
- difficulty: enum('easy', 'medium', 'hard') DEFAULT 'medium'
- user_answer: text NULL
- is_correct: boolean NULL
- answered_at: timestamp NULL
- time_taken_seconds: int NULL
- created_at: timestamp
- updated_at: timestamp
```

### Face Verification Tables

#### 12. **student_photos** (Face Verification)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id) UNIQUE
- photo_path: varchar(255)
- photo_url: varchar(255)
- face_encoding: json NULL
- photo_hash: varchar(255) NULL
- verification_status: enum('pending', 'verified', 'rejected') DEFAULT 'pending'
- uploaded_at: timestamp
- verified_at: timestamp NULL
- created_at: timestamp
- updated_at: timestamp
```

### Enrollment & Progress Tables

#### 13. **course_user** (Course Enrollments)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id)
- course_id: bigint (FK → courses.id)
- enrolled_at: timestamp
- completed_at: timestamp NULL
- progress_percentage: decimal(5,2) DEFAULT 0.00
- last_accessed_at: timestamp NULL
- created_at: timestamp
- updated_at: timestamp
```

#### 14. **lesson_progress** (Individual Lesson Progress)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id)
- lesson_id: bigint (FK → lessons.id)
- is_completed: boolean DEFAULT false
- completion_percentage: decimal(5,2) DEFAULT 0.00
- time_spent: int DEFAULT 0 (seconds)
- last_position: int DEFAULT 0
- completed_at: timestamp NULL
- created_at: timestamp
- updated_at: timestamp
```

### System Tables

#### 15. **achievements** (Student Achievements)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id)
- type: varchar(255)
- title: varchar(255)
- description: text NULL
- icon: varchar(255) NULL
- points: int DEFAULT 0
- earned_at: timestamp
- created_at: timestamp
- updated_at: timestamp
```

#### 16. **activity_logs** (System Activity Tracking)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id) NULL
- action: varchar(255)
- description: text NULL
- ip_address: varchar(45) NULL
- user_agent: text NULL
- created_at: timestamp
- updated_at: timestamp
```

#### 17. **reclamations** (Support Tickets)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id)
- subject: varchar(255)
- message: text
- status: enum('open', 'in_progress', 'resolved', 'closed') DEFAULT 'open'
- priority: enum('low', 'medium', 'high', 'urgent') DEFAULT 'medium'
- assigned_to: bigint (FK → users.id) NULL
- resolved_at: timestamp NULL
- created_at: timestamp
- updated_at: timestamp
```

#### 18. **two_factor_auths** (2FA Security)
```sql
- id: bigint (PK, auto_increment)
- user_id: bigint (FK → users.id) UNIQUE
- secret: varchar(255)
- recovery_codes: json NULL
- is_enabled: boolean DEFAULT false
- enabled_at: timestamp NULL
- created_at: timestamp
- updated_at: timestamp
```

## 🔗 Key Relationships

### One-to-Many Relationships
- **categories** → **courses** (category_id)
- **users** → **courses** (teacher_id)
- **courses** → **sections** (course_id)
- **sections** → **lessons** (section_id)
- **courses** → **contents** (course_id)
- **courses** → **quizzes** (course_id)
- **quizzes** → **questions** (quiz_id)
- **users** → **quiz_results** (user_id)
- **quizzes** → **quiz_results** (quiz_id)
- **users** → **practice_sessions** (user_id)
- **courses** → **practice_sessions** (course_id)
- **practice_sessions** → **practice_questions** (session_id)
- **users** → **achievements** (user_id)
- **users** → **activity_logs** (user_id)
- **users** → **reclamations** (user_id)

### One-to-One Relationships
- **users** → **student_photos** (user_id)
- **users** → **two_factor_auths** (user_id)

### Many-to-Many Relationships
- **users** ↔ **courses** (through course_user pivot table)
- **users** ↔ **lessons** (through lesson_progress tracking table)

## 📋 Indexes & Constraints

### Primary Keys
- All tables have auto-incrementing `id` as primary key

### Unique Constraints
- users.email
- student_photos.user_id
- practice_sessions.session_id
- two_factor_auths.user_id

### Foreign Key Constraints
- All FK relationships enforce referential integrity
- CASCADE on delete for dependent records
- RESTRICT on delete for referenced records

### Performance Indexes
- users(email, role)
- courses(category_id, teacher_id, is_published)
- quiz_results(user_id, quiz_id)
- practice_sessions(user_id, course_id, status)
- course_user(user_id, course_id)
