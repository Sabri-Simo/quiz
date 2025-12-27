@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">
                    <span class="flag">{{ $country->flag_emoji ?? '🏴' }}</span>
                    {{ $country->name }}
                </h1>
                <p class="text-muted">Choose difficulty level</p>
                
                <div class="row">
                    @foreach($difficulties as $difficulty)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 
                            @if($difficulty->level === 'easy') border-success
                            @elseif($difficulty->level === 'medium') border-warning
                            @else border-danger
                            @endif">
                            <div class="card-body">
                                <h3 class="card-title">{{ ucfirst($difficulty->level) }}</h3>
                                
                                <p><strong>Points per question:</strong> {{ $difficulty->points_per_question }}</p>
                                
                                @if($difficulty->userScores->first())
                                <div class="alert alert-info">
                                    <p class="mb-1"><strong>Your Score:</strong> {{ $difficulty->userScores->first()->score }}</p>
                                    <p class="mb-0">{{ $difficulty->userScores->first()->correct_answers }}/{{ $difficulty->userScores->first()->total_questions }} correct</p>
                                </div>
                                @endif
                                
                                <a href="{{ route('quiz.show', $difficulty) }}" 
                                   class="btn 
                                    @if($difficulty->level === 'easy') btn-success
                                    @elseif($difficulty->level === 'medium') btn-warning
                                    @else btn-danger
                                    @endif w-100">
                                    {{ $difficulty->userScores->first() ? 'Retake' : 'Start' }}
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                
                <div class="mt-3">
                    <a href="/countries" class="btn btn-secondary">← Back to Countries</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
