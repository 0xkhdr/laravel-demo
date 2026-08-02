<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Nothing.tech Design System Portfolio">
    <title>Nothing Portfolio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @include('components.nav')

    <main class="pt-16">
        @include('components.hero')
        @include('sections.about')
        @include('sections.experience')
        @include('sections.projects')
        @include('sections.skills')
        @include('sections.contact')
    </main>

    @include('components.footer')
</body>
</html>
