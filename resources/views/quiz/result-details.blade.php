@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">
                    <span class="flag">{{ $userScore->country->flag_emoji ?? '🏴' }}</span>
                    {{ $userScore->country->name }} - {{ ucfirst($userScore->difficulty->level) }}
                </h1>
                
                @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
                @endif
                
                <div class="alert alert-info">
                    <h3>Quiz Result</h3>
                    <p><strong>Total Score:</strong> {{ $userScore->score }}</p>
                    <p><strong>Correct Answers:</strong> {{ $userScore->correct_answers }}/{{ $userScore->total_questions }}</p>
                    <p><strong>Percentage:</strong> {{ $userScore->total_questions > 0 ? round(($userScore->correct_answers / $userScore->total_questions) * 100) : 0 }}%</p>
                    <p><strong>Completed at:</strong> {{ $userScore->completed_at->format('Y-m-d H:i') }}</p>
                </div>
                
                <h3>Question Details</h3>
                
                @foreach($userAnswers as $userAnswer)
                    @php
                        $question = $userAnswer->question;
                        $isCorrect = $userAnswer->is_correct;
                    @endphp
                    
                    <div class="card mb-4 {{ $isCorrect ? 'border-success' : 'border-danger' }}">
                        <div class="card-body">
                            <h5 class="card-title">Question {{ $loop->iteration }}</h5>
                            <p class="card-text"><strong>{{ $question->question_text }}</strong></p>
                            
                            @if($question->explanation)
                            <div class="alert alert-light">
                                <small>💡 {{ $question->explanation }}</small>
                            </div>
                            @endif
                            
                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <h6>Your Answer:</h6>
                                    @if($userAnswer->choice)
                                        <p>{{ $userAnswer->choice->choice_text }}</p>
                                    @else
                                        <p class="text-muted">No answer selected</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6>Correct Answer(s):</h6>
                                    @foreach($question->choices->where('is_correct', true) as $choice)
                                        <p>{{ $choice->choice_text }}</p>
                                    @endforeach
                                </div>
                            </div>
                            
                            <div class="mt-3">
                                <span class="badge {{ $isCorrect ? 'bg-success' : 'bg-danger' }}">
                                    {{ $isCorrect ? 'Correct' : 'Incorrect' }}
                                </span>
                                <span class="ms-2">Points earned: {{ $userAnswer->points_earned }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
                
                <div class="mt-4">
                    <a href="{{ route('dashboard') }}" class="btn btn-secondary">← Dashboard</a>
                    <a href="{{ route('countries.index') }}" class="btn btn-primary">New Quiz</a>
                    <a href="{{ route('quiz.results') }}" class="btn btn-info">All Results</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
