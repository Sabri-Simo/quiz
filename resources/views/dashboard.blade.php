@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Welcome, {{ auth()->user()->name }}!</h1>
                
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-primary text-white">
                            <div class="card-body text-center">
                                <h3>{{ $totalScore ?? 0 }}</h3>
                                <p>Total Score</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body text-center">
                                <h3>{{ $completedQuizzes ?? 0 }}</h3>
                                <p>Quizzes Done</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body text-center">
                                <a href="/countries" class="btn btn-light">Start Quiz</a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="/countries" class="btn btn-primary btn-lg">Go to Countries →</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
