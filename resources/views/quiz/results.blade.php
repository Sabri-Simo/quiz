@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">All Quiz Results</h1>
                
                @if($userScores->isEmpty())
                <div class="alert alert-info">
                    No quiz results yet. <a href="/countries">Take your first quiz!</a>
                </div>
                @else
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Country</th>
                                <th>Difficulty</th>
                                <th>Score</th>
                                <th>Correct</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userScores as $score)
                            <tr>
                                <td>
                                    {{ $score->country->flag_emoji ?? '🏴' }}
                                    {{ $score->country->name }}
                                </td>
                                <td>
                                    <span class="badge 
                                        @if($score->difficulty->level === 'easy') bg-success
                                        @elseif($score->difficulty->level === 'medium') bg-warning
                                        @else bg-danger
                                        @endif">
                                        {{ ucfirst($score->difficulty->level) }}
                                    </span>
                                </td>
                                <td class="{{ $score->score >= 0 ? 'text-success' : 'text-danger' }}">
                                    <strong>{{ $score->score }}</strong>
                                </td>
                                <td>{{ $score->correct_answers }}/{{ $score->total_questions }}</td>
                                <td>{{ $score->completed_at ? $score->completed_at->format('Y-m-d') : 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('quiz.result-details', $score) }}" class="btn btn-sm btn-info">
                                        View Details
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                
                <div class="mt-3">
                    {{ $userScores->links() }}
                </div>
                @endif
                
                <div class="mt-3">
                    <a href="/dashboard" class="btn btn-secondary">← Dashboard</a>
                    <a href="/countries" class="btn btn-primary">New Quiz</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
