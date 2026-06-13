<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name') }}</title>
    <style>
        body { font-family: sans-serif; display: flex; align-items: center; justify-content: center; min-height: 100vh; margin: 0; background: #f8fafc; }
        .card { background: white; padding: 2rem 3rem; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,.1); text-align: center; }
        h1 { color: #1a1a1a; margin-bottom: .5rem; }
        p { color: #666; margin: 0; }
        a { color: #6366f1; text-decoration: none; }
    </style>
</head>
<body>
    <div class="card">
        <h1>{{ config('app.name') }}</h1>
        <p>API is running. See <a href="/api/users">/api/users</a> or <a href="/horizon">Horizon</a>.</p>
    </div>
</body>
</html>
