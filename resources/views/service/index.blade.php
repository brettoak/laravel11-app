<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Service Example</title>
    @livewireStyles
</head>
<body>
<h1>{{ $greeting }}</h1>
<p>Change the name with query string, e.g. <code>?name=Alice</code></p>
<livewire:service-greeting />
@livewireScripts
</body>
</html>


