@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0">{{ __('Edit Quiz') }}</h2>
                </div>
                <div class="card-body">
                    <form action="{{ route('teacher.quizzes.update', $quiz) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">{{ __('Quiz Title') }} <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $quiz->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">{{ __('Quiz Description') }}</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $quiz->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="duration" class="form-label">{{ __('Duration (minutes)') }} <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('duration') is-invalid @enderror" id="duration" name="duration" value="{{ old('duration', $quiz->duration) }}" min="1" required>
                            @error('duration')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="type" class="form-label">{{ __('Quiz Type') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                <option value="practice" {{ old('type', $quiz->type) == 'practice' ? 'selected' : '' }}>{{ __('Practice Quiz') }}</option>
                                <option value="exam" {{ old('type', $quiz->type) == 'exam' ? 'selected' : '' }}>{{ __('Exam') }}</option>
                            </select>
                            @error('type')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="status" class="form-label">{{ __('Quiz Status') }} <span class="text-danger">*</span></label>
                            <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                <option value="closed" {{ old('status', $quiz->status) == 'closed' ? 'selected' : '' }}>{{ __('Closed') }}</option>
                                <option value="open" {{ old('status', $quiz->status) == 'open' ? 'selected' : '' }}>{{ __('Open') }}</option>
                            </select>
                            @error('status')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3 form-check">
                            <input type="checkbox" class="form-check-input @error('requires_face_recognition') is-invalid @enderror" id="requires_face_recognition" name="requires_face_recognition" value="1" {{ old('requires_face_recognition', $quiz->requires_face_recognition) ? 'checked' : '' }}>
                            <label class="form-check-label" for="requires_face_recognition">{{ __('Require Face Recognition') }}</label>
                            <div class="form-text">{{ __('If checked, students will need to verify their identity using face recognition before taking the quiz.') }}</div>
                            @error('requires_face_recognition')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="{{ route('teacher.lessons.edit', $quiz->lesson_id) }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>{{ __('Back to Lesson') }}
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>{{ __('Update Quiz') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-header bg-primary text-white">
                    <h3 class="mb-0">{{ __('Quiz Questions') }}</h3>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4>{{ __('Questions') }}</h4>
                        <div>
                            <a href="{{ route('teacher.questions.create', ['quiz_id' => $quiz->id]) }}" class="btn btn-success">
                                <i class="fas fa-plus-circle me-2"></i>{{ __('Add Question') }}
                            </a>
                            <a href="{{ route('teacher.quizzes.generate-questions', $quiz) }}" class="btn btn-info ms-2">
                                <i class="fas fa-magic me-2"></i>{{ __('Auto-Generate Questions') }}
                            </a>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th width="50%">{{ __('Question') }}</th>
                                    <th width="15%">{{ __('Type') }}</th>
                                    <th width="10%">{{ __('Points') }}</th>
                                    <th width="20%">{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody id="questionsTable">
                                @forelse($quiz->questions as $index => $question)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ Str::limit($question->question_text, 100) }}</td>
                                        <td>
                                            <span class="badge bg-{{ $question->type == 'multiple_choice' ? 'primary' : ($question->type == 'true_false' ? 'success' : 'info') }}">
                                                {{ str_replace('_', ' ', ucfirst($question->type)) }}
                                            </span>
                                        </td>
                                        <td>{{ $question->points }}</td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('teacher.questions.edit', $question) }}" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteQuestionModal{{ $question->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                            
                                            <!-- Delete Question Modal -->
                                            <div class="modal fade" id="deleteQuestionModal{{ $question->id }}" tabindex="-1" aria-labelledby="deleteQuestionModalLabel{{ $question->id }}" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="deleteQuestionModalLabel{{ $question->id }}">{{ __('Delete Question') }}</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            {{ __('Are you sure you want to delete this question?') }}
                                                            <p class="text-danger">{{ __('This will also delete all options and student answers associated with this question.') }}</p>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                                                            <form action="{{ route('teacher.questions.destroy', $question) }}" method="POST">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="text-center">{{ __('No questions found.') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const typeSelect = document.getElementById('type');
        const faceRecognitionCheck = document.getElementById('requires_face_recognition');
        
        typeSelect.addEventListener('change', function() {
            if (this.value === 'exam') {
                faceRecognitionCheck.checked = true;
            }
        });
        
        // Make questions sortable
        const questionsTable = document.getElementById('questionsTable');
        if (questionsTable && typeof Sortable !== 'undefined') {
            new Sortable(questionsTable, {
                animation: 150,
                onEnd: function(evt) {
                    // Update question order via AJAX
                    const questionIds = Array.from(questionsTable.querySelectorAll('tr')).map(row => row.dataset.questionId);
                    
                    fetch('{{ route("teacher.questions.reorder") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ questions: questionIds })
                    });
                }
            });
        }
    });
</script>
@endpush
