# Class Structure Documentation

## 📋 Model Classes (Eloquent Models)

### Core Models

#### 1. **User** (app/Models/User.php)
```php
class User extends Authenticatable
{
    // Attributes
    protected $fillable = ['name', 'email', 'password', 'role', 'profile_picture', 'bio', 'phone', 'date_of_birth', 'address', 'is_active'];
    protected $hidden = ['password', 'remember_token'];
    protected $casts = ['email_verified_at' => 'datetime', 'date_of_birth' => 'date', 'is_active' => 'boolean'];
    
    // Relationships
    public function courses(): HasMany // Teacher's courses
    public function enrolledCourses(): BelongsToMany // Student enrollments
    public function quizResults(): HasMany
    public function practiceSessions(): HasMany
    public function achievements(): HasMany
    public function activityLogs(): HasMany
    public function reclamations(): HasMany
    public function studentPhoto(): HasOne
    public function twoFactorAuth(): HasOne
    public function lessonProgress(): HasMany
    
    // Methods
    public function isAdmin(): bool
    public function isTeacher(): bool
    public function isStudent(): bool
    public function hasRole(string $role): bool
    public function getAvatarAttribute(): string
    public function getFullNameAttribute(): string
}
```

#### 2. **Course** (app/Models/Course.php)
```php
class Course extends Model
{
    // Attributes
    protected $fillable = ['title', 'description', 'image', 'category_id', 'teacher_id', 'level', 'duration', 'price', 'is_published', 'enrollment_limit', 'prerequisites', 'learning_objectives'];
    protected $casts = ['price' => 'decimal:2', 'is_published' => 'boolean', 'duration' => 'integer'];
    
    // Relationships
    public function category(): BelongsTo
    public function teacher(): BelongsTo
    public function sections(): HasMany
    public function contents(): HasMany
    public function quizzes(): HasMany
    public function students(): BelongsToMany
    public function practiceSessions(): HasMany
    
    // Methods
    public function isPublished(): bool
    public function getEnrollmentCountAttribute(): int
    public function hasAvailableSlots(): bool
    public function getProgressForUser(User $user): float
    public function getTotalLessonsAttribute(): int
    public function getCompletedLessonsForUser(User $user): int
}
```

#### 3. **Category** (app/Models/Category.php)
```php
class Category extends Model
{
    // Attributes
    protected $fillable = ['name', 'description', 'image', 'is_active'];
    protected $casts = ['is_active' => 'boolean'];
    
    // Relationships
    public function courses(): HasMany
    
    // Methods
    public function isActive(): bool
    public function getCoursesCountAttribute(): int
}
```

#### 4. **Section** (app/Models/Section.php)
```php
class Section extends Model
{
    // Attributes
    protected $fillable = ['course_id', 'title', 'description', 'order', 'is_published'];
    protected $casts = ['is_published' => 'boolean', 'order' => 'integer'];
    
    // Relationships
    public function course(): BelongsTo
    public function lessons(): HasMany
    
    // Methods
    public function isPublished(): bool
    public function getTotalDurationAttribute(): int
    public function getLessonsCountAttribute(): int
}
```

#### 5. **Lesson** (app/Models/Lesson.php)
```php
class Lesson extends Model
{
    // Attributes
    protected $fillable = ['section_id', 'title', 'content', 'video_url', 'duration', 'order', 'is_published'];
    protected $casts = ['is_published' => 'boolean', 'duration' => 'integer', 'order' => 'integer'];
    
    // Relationships
    public function section(): BelongsTo
    public function progress(): HasMany // LessonProgress
    
    // Methods
    public function isPublished(): bool
    public function hasVideo(): bool
    public function getProgressForUser(User $user): ?LessonProgress
    public function isCompletedByUser(User $user): bool
}
```

### Assessment Models

#### 6. **Quiz** (app/Models/Quiz.php)
```php
class Quiz extends Model
{
    // Attributes
    protected $fillable = ['course_id', 'name', 'description', 'duration', 'passing_score', 'max_attempts', 'is_published', 'randomize_questions', 'show_results'];
    protected $casts = ['duration' => 'integer', 'passing_score' => 'integer', 'max_attempts' => 'integer', 'is_published' => 'boolean', 'randomize_questions' => 'boolean', 'show_results' => 'boolean'];
    
    // Relationships
    public function course(): BelongsTo
    public function questions(): HasMany
    public function results(): HasMany // QuizResult
    
    // Methods
    public function isPublished(): bool
    public function getQuestionsCountAttribute(): int
    public function getTotalPointsAttribute(): int
    public function getAttemptsForUser(User $user): int
    public function canUserAttempt(User $user): bool
}
```

#### 7. **Question** (app/Models/Question.php)
```php
class Question extends Model
{
    // Attributes
    protected $fillable = ['quiz_id', 'question', 'type', 'options', 'correct_answer', 'explanation', 'points', 'order'];
    protected $casts = ['options' => 'array', 'points' => 'integer', 'order' => 'integer'];
    
    // Relationships
    public function quiz(): BelongsTo
    
    // Methods
    public function isMultipleChoice(): bool
    public function isTrueFalse(): bool
    public function isShortAnswer(): bool
    public function getOptionsArray(): array
    public function checkAnswer(string $answer): bool
}
```

#### 8. **QuizResult** (app/Models/QuizResult.php)
```php
class QuizResult extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'quiz_id', 'correct_answers', 'answers_count', 'score', 'details', 'started_at', 'completed_at'];
    protected $casts = ['details' => 'array', 'score' => 'decimal:2', 'started_at' => 'datetime', 'completed_at' => 'datetime'];
    
    // Relationships
    public function user(): BelongsTo
    public function quiz(): BelongsTo
    
    // Methods
    public function isPassed(): bool
    public function getPercentageAttribute(): float
    public function getDurationAttribute(): ?int
    public function getGradeAttribute(): string
}
```

### AI Practice Models

#### 9. **PracticeSession** (app/Models/PracticeSession.php)
```php
class PracticeSession extends Model
{
    // Attributes
    protected $fillable = ['session_id', 'user_id', 'course_id', 'total_questions', 'difficulty', 'question_type', 'language', 'questions_answered', 'correct_answers', 'score_percentage', 'started_at', 'completed_at', 'total_time_seconds', 'ai_service_used', 'used_fallback', 'content_summary', 'status'];
    protected $casts = ['started_at' => 'datetime', 'completed_at' => 'datetime', 'used_fallback' => 'boolean', 'score_percentage' => 'decimal:2'];
    
    // Relationships
    public function user(): BelongsTo
    public function course(): BelongsTo
    public function practiceQuestions(): HasMany
    
    // Scopes
    public function scopeActive($query)
    public function scopeCompleted($query)
    public function scopeForUser($query, $userId)
    public function scopeForCourse($query, $courseId)
    
    // Methods
    public function isActive(): bool
    public function isCompleted(): bool
    public function complete(): void
    public function abandon(): void
    public function calculateScore(): void
    public function getProgressPercentageAttribute(): float
    public function getAverageTimePerQuestionAttribute(): ?float
    public function getDurationAttribute(): string
    public function getGradeAttribute(): string
    public function getStatistics(): array
    
    // Static Methods
    public static function getRecentForUser($userId, $limit = 10)
    public static function getPerformanceSummary($userId, $courseId = null): array
}
```

#### 10. **PracticeQuestion** (app/Models/PracticeQuestion.php)
```php
class PracticeQuestion extends Model
{
    // Attributes
    protected $fillable = ['session_id', 'question_id', 'question_text', 'question_type', 'options', 'correct_answer', 'explanation', 'difficulty', 'user_answer', 'is_correct', 'answered_at', 'time_taken_seconds'];
    protected $casts = ['options' => 'array', 'is_correct' => 'boolean', 'answered_at' => 'datetime', 'time_taken_seconds' => 'integer'];
    
    // Relationships
    public function practiceSession(): BelongsTo
    
    // Scopes
    public function scopeAnswered($query)
    public function scopeCorrect($query)
    public function scopeIncorrect($query)
    
    // Methods
    public function isAnswered(): bool
    public function isCorrect(): bool
    public function answer(string $userAnswer): void
    public function getFormattedOptionsAttribute(): array
}
```

### Security & Verification Models

#### 11. **StudentPhoto** (app/Models/StudentPhoto.php)
```php
class StudentPhoto extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'photo_path', 'photo_url', 'face_encoding', 'photo_hash', 'verification_status', 'uploaded_at', 'verified_at'];
    protected $casts = ['face_encoding' => 'array', 'uploaded_at' => 'datetime', 'verified_at' => 'datetime'];
    
    // Relationships
    public function user(): BelongsTo
    
    // Methods
    public function isVerified(): bool
    public function isPending(): bool
    public function isRejected(): bool
    public function hasFaceEncoding(): bool
    public function verify(): void
    public function reject(): void
}
```

#### 12. **TwoFactorAuth** (app/Models/TwoFactorAuth.php)
```php
class TwoFactorAuth extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'secret', 'recovery_codes', 'is_enabled', 'enabled_at'];
    protected $casts = ['recovery_codes' => 'array', 'is_enabled' => 'boolean', 'enabled_at' => 'datetime'];
    
    // Relationships
    public function user(): BelongsTo
    
    // Methods
    public function isEnabled(): bool
    public function enable(): void
    public function disable(): void
    public function generateRecoveryCodes(): array
    public function verifyCode(string $code): bool
}
```

### Progress & Analytics Models

#### 13. **LessonProgress** (app/Models/LessonProgress.php)
```php
class LessonProgress extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'lesson_id', 'is_completed', 'completion_percentage', 'time_spent', 'last_position', 'completed_at'];
    protected $casts = ['is_completed' => 'boolean', 'completion_percentage' => 'decimal:2', 'time_spent' => 'integer', 'last_position' => 'integer', 'completed_at' => 'datetime'];
    
    // Relationships
    public function user(): BelongsTo
    public function lesson(): BelongsTo
    
    // Methods
    public function markCompleted(): void
    public function updateProgress(float $percentage): void
    public function addTimeSpent(int $seconds): void
    public function updatePosition(int $position): void
}
```

#### 14. **Achievement** (app/Models/Achievement.php)
```php
class Achievement extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'type', 'title', 'description', 'icon', 'points', 'earned_at'];
    protected $casts = ['points' => 'integer', 'earned_at' => 'datetime'];
    
    // Relationships
    public function user(): BelongsTo
    
    // Methods
    public function getIconUrlAttribute(): string
    public function isRecent(): bool
}
```

### System Models

#### 15. **ActivityLog** (app/Models/ActivityLog.php)
```php
class ActivityLog extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'action', 'description', 'ip_address', 'user_agent'];
    
    // Relationships
    public function user(): BelongsTo
    
    // Methods
    public function getFormattedDateAttribute(): string
    public function getBrowserAttribute(): string
}
```

#### 16. **Reclamation** (app/Models/Reclamation.php)
```php
class Reclamation extends Model
{
    // Attributes
    protected $fillable = ['user_id', 'subject', 'message', 'status', 'priority', 'assigned_to', 'resolved_at'];
    protected $casts = ['resolved_at' => 'datetime'];
    
    // Relationships
    public function user(): BelongsTo
    public function assignedTo(): BelongsTo
    
    // Methods
    public function isOpen(): bool
    public function isResolved(): bool
    public function resolve(): void
    public function assign(User $user): void
}
```

## 🔗 Model Relationships Summary

### Inheritance Hierarchy
```
Model (Laravel Base)
├── User (Authenticatable)
├── Course
├── Category
├── Section
├── Lesson
├── Quiz
├── Question
├── QuizResult
├── PracticeSession
├── PracticeQuestion
├── StudentPhoto
├── TwoFactorAuth
├── LessonProgress
├── Achievement
├── ActivityLog
└── Reclamation
```

### Composition Relationships
- **Course** contains **Sections** contains **Lessons**
- **Quiz** contains **Questions**
- **PracticeSession** contains **PracticeQuestions**
- **User** has **StudentPhoto**, **TwoFactorAuth**

### Aggregation Relationships
- **Category** aggregates **Courses**
- **User** aggregates **Achievements**, **ActivityLogs**, **Reclamations**
- **Course** aggregates **Quizzes**, **Contents**

## 🔧 Service Classes

### AI Services

#### 1. **GeminiAIService** (app/Services/GeminiAIService.php)
```php
class GeminiAIService
{
    // Properties
    protected string $apiKey
    protected string $baseUrl
    protected string $model

    // Constructor
    public function __construct()

    // Main Methods
    public function generatePracticeQuestions(string $courseContent, int $numQuestions, string $difficulty, string $questionType, string $language): array
    public function testConnection(): array

    // Private Methods
    private function buildPracticePrompt(string $courseContent, int $numQuestions, string $difficulty, string $questionType, string $language): string
    private function callGeminiAPI(string $prompt): string
    private function parsePracticeResponse(string $response, string $questionType): array
    private function getFormatInstructions(string $questionType, string $language): string
    private function getDifficultySpecificInstructions(string $difficulty, string $language): string
    private function getLanguageSpecificInstructions(string $language): string
    private function validateAndCleanQuestions(array $questions, string $questionType): array
    private function generateFallbackQuestions(string $courseContent, int $numQuestions, string $difficulty, string $questionType, string $language): array
}
```

#### 2. **FaceVerificationService** (app/Services/FaceVerificationService.php)
```php
class FaceVerificationService
{
    // Properties
    protected string $pythonScriptPath

    // Constructor
    public function __construct()

    // Main Methods
    public function processStudentPhoto(string $imagePath, int $userId): array
    public function verifyFaceForExam(string $capturedImageBase64, StudentPhoto $studentPhoto): array

    // Private Methods
    private function validateImage(string $imagePath): bool
    private function optimizeImage(string $imagePath): string
    private function callPythonScript(array $arguments): array
}
```

#### 3. **AdaptiveLearningService** (app/Services/AdaptiveLearningService.php)
```php
class AdaptiveLearningService
{
    // Main Methods
    public function generateLearningPath(User $student, Course $course): array
    public function getPersonalizedRecommendations(User $student): array
    public function updateLearningProgress(User $student, Course $course, array $performance): void

    // Private Methods
    private function getStudentCoursePerformance(User $student, Course $course): array
    private function identifyWeakAreas(User $student, Course $course): array
    private function determineRecommendedDifficulty(array $performance): string
    private function getRecommendedContent(Course $course, array $weakAreas): array
    private function getRecommendedQuestions(Course $course, array $weakAreas, string $difficulty): array
}
```

## 🎮 Controller Classes

### Main Controllers

#### 1. **AIQuizController** (app/Http/Controllers/AIQuizController.php)
```php
class AIQuizController extends Controller
{
    // Properties
    protected GeminiAIService $geminiService

    // Constructor
    public function __construct(GeminiAIService $geminiService)

    // Main Methods
    public function showAIPractice(): View
    public function generateQuiz(Request $request): JsonResponse
    public function getQuestion(Request $request): JsonResponse
    public function submitAnswer(Request $request): JsonResponse
    public function getSessionResults(Request $request): JsonResponse
    public function getSessionHistory(Request $request): JsonResponse

    // Private Methods
    private function extractCourseContent(Course $course): string
    private function analyzeContentForQuestions(string $content): array
    private function generateFallbackQuestions(string $content, int $numQuestions, string $difficulty, string $questionType, string $language): array
    private function createPracticeSession(array $data): PracticeSession
    private function storePracticeQuestions(PracticeSession $session, array $questions): void
}
```

#### 2. **FaceVerificationController** (app/Http/Controllers/FaceVerificationController.php)
```php
class FaceVerificationController extends Controller
{
    // Properties
    protected FaceVerificationService $faceService

    // Constructor
    public function __construct(FaceVerificationService $faceService)

    // Main Methods
    public function showPhotoUpload(): View
    public function storePhoto(Request $request): RedirectResponse
    public function deletePhoto(): RedirectResponse
    public function showExamVerification(Quiz $quiz): View
    public function verifyForExam(Request $request, Quiz $quiz): JsonResponse

    // Private Methods
    private function validatePhotoUpload(Request $request): void
    private function processUploadedPhoto(UploadedFile $file, User $user): array
    private function handleCapturedPhoto(string $photoData, User $user): array
}
```

#### 3. **StudentController** (app/Http/Controllers/StudentController.php)
```php
class StudentController extends Controller
{
    // Main Methods
    public function dashboard(): View
    public function courses(): View
    public function enrolledCourses(): View
    public function courseDetails(Course $course): View
    public function enrollInCourse(Course $course): RedirectResponse
    public function lessonView(Lesson $lesson): View
    public function updateLessonProgress(Request $request, Lesson $lesson): JsonResponse
    public function quizzes(): View
    public function takeQuiz(Quiz $quiz): View
    public function submitQuiz(Request $request, Quiz $quiz): RedirectResponse
    public function achievements(): View
    public function profile(): View
    public function updateProfile(Request $request): RedirectResponse
}
```

#### 4. **TeacherController** (app/Http/Controllers/TeacherController.php)
```php
class TeacherController extends Controller
{
    // Main Methods
    public function dashboard(): View
    public function courses(): View
    public function createCourse(): View
    public function storeCourse(Request $request): RedirectResponse
    public function editCourse(Course $course): View
    public function updateCourse(Request $request, Course $course): RedirectResponse
    public function courseStudents(Course $course): View
    public function courseAnalytics(Course $course): View
    public function quizzes(): View
    public function createQuiz(Course $course): View
    public function storeQuiz(Request $request, Course $course): RedirectResponse
    public function editQuiz(Quiz $quiz): View
    public function updateQuiz(Request $request, Quiz $quiz): RedirectResponse
}
```

## 🔄 Class Interaction Patterns

### Service Layer Pattern
- Controllers use Services for business logic
- Services interact with Models for data persistence
- Services handle external API communications

### Repository Pattern (Implicit)
- Models act as repositories for data access
- Eloquent ORM provides abstraction layer
- Relationships define data access patterns

### Observer Pattern
- Model events trigger automatic actions
- Activity logging through model observers
- Achievement system responds to user actions

### Strategy Pattern
- AI service selection (Gemini vs Fallback)
- Multiple authentication methods
- Different question generation strategies
