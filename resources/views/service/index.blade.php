<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Example</title>
    
    <!-- Vite 配置 - 这是热更新的关键！ -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    @livewireStyles
</head>
<body>
<h1>{{ $greeting }}</h1>
<p>Change the name with query string, e.g. <code>?name=Alice</code></p>
<livewire:service-greeting />
@livewireScripts
</body>
</html>


