@extends('layouts.minimal')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h1 class="card-title">Choose a Country</h1>
                <p class="text-muted">Select a country to start the quiz</p>
                
                <div class="row">
                    @foreach($countries as $country)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h3 class="card-title">
                                    <span class="flag">{{ $country->flag_emoji ?? '🏴' }}</span>
                                    {{ $country->name }}
                                </h3>
                                
                                <div class="mt-3">
                                    @foreach($country->difficulties as $difficulty)
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="badge 
                                            @if($difficulty->level === 'easy') bg-success
                                            @elseif($difficulty->level === 'medium') bg-warning text-dark
                                            @else bg-danger
                                            @endif">
                                            {{ ucfirst($difficulty->level) }}
                                        </span>
                                        <small>
                                            @if($difficulty->userScores->first())
                                                Score: {{ $difficulty->userScores->first()->score }}
                                            @else
                                                Not tried
                                            @endif
                                        </small>
                                    </div>
                                    @endforeach
                                </div>
                                
                                <a href="{{ route('country.difficulties', $country) }}" 
                                   class="btn btn-primary mt-3 w-100">
                                    Select
                                </a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
