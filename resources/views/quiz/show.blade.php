@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">
                    <span class="flag">{{ $difficulty->country->flag_emoji ?? '🏴' }}</span>
                    {{ $difficulty->country->name }} - {{ ucfirst($difficulty->level) }}
                </h1>
                
                <div class="alert alert-info">
                    <strong>Scoring:</strong><br>
                    • Correct answer: +{{ $difficulty->points_per_question }} points<br>
                    • Wrong answer: -2 points<br>
                    • Unanswered: 0 points<br>
                    • Some questions have 1 correct answer, some have 2
                </div>
                
                <div class="alert alert-warning">
                    <strong>Important:</strong> You must select ALL correct answers to get points!
                </div>
                
                <form action="{{ route('quiz.submit', $difficulty) }}" method="POST" id="quiz-form">
                    @csrf
                    
                    @foreach($questions as $index => $question)
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Question {{ $index + 1 }}</h5>
                            <p class="card-text"><strong>{{ $question->question_text }}</strong></p>
                            
                            @if($question->explanation)
                            <div class="alert alert-light">
                                <small>💡 {{ $question->explanation }}</small>
                            </div>
                            @endif
                            
                            <div class="mt-3">
                                @foreach($question->choices as $choice)
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="checkbox" 
                                           name="answers[{{ $question->id }}][]" 
                                           value="{{ $choice->id }}" 
                                           id="q{{ $question->id }}c{{ $choice->id }}">
                                    <label class="form-check-label" for="q{{ $question->id }}c{{ $choice->id }}">
                                        {{ $choice->choice_text }}
                                    </label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-lg w-100" id="submit-btn">
                            Submit Quiz
                        </button>
                        <p class="text-center text-muted mt-2">
                            {{ count($questions) }} questions
                        </p>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById('quiz-form').addEventListener('submit', function(e) {
        const submitBtn = document.getElementById('submit-btn');
        submitBtn.disabled = true;
        submitBtn.innerHTML = 'Submitting...';
        
        // Count how many questions were answered
        const checkboxes = document.querySelectorAll('input[type="checkbox"]:checked');
        if (checkboxes.length === 0) {
            if (!confirm('You haven\'t answered any questions. Submit anyway?')) {
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Submit Quiz';
                e.preventDefault();
                return false;
            }
        }
        
        if (!confirm('Are you sure you want to submit? You cannot change answers after.')) {
            submitBtn.disabled = false;
            submitBtn.innerHTML = 'Submit Quiz';
            e.preventDefault();
            return false;
        }
        
        return true;
    });
</script>
@endsection
