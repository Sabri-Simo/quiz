<!DOCTYPE html>
<html>
<head>
    <title>Test</title>
</head>
<body>
    <h1>Test Morocco Data</h1>
    <h2>{{ $country->name }} {{ $country->flag_emoji }}</h2>
    
    <h3>Difficulties:</h3>
    <ul>
        @foreach($difficulties as $difficulty)
            <li>{{ $difficulty->level }} - {{ $difficulty->questions_count ?? 0 }} questions</li>
        @endforeach
    </ul>
    
    <h3>Sample Questions:</h3>
    <ul>
        @foreach($questions as $question)
            <li>{{ $question->question_text }}</li>
        @endforeach
    </ul>
</body>
</html>