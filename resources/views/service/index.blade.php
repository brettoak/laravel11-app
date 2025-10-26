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
<livewire:service-greeting />
<livewire:service-greeting2 />
<livewire:service-greeting3 />
<livewire:service-greeting4 />
<livewire:service-greeting5 />
@livewireScripts
</body>
</html>


