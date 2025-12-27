<?php

use Illuminate\Support\Facades\Route;

Route::get('/test', function() {
    return '
    <!DOCTYPE html>
    <html>
    <head>
        <title>TEST</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
    <body>
        <div class="container mt-4">
            <h1>DIRECT HTML TEST - NO BLADE</h1>
            <p>If this works, the problem is with Blade compilation.</p>
            <p><a href="/dashboard">Try Dashboard</a></p>
        </div>
    </body>
    </html>
    ';
});
