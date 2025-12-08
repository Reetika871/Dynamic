<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Meal Planner</title>
  @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="p-6 space-y-4">
  <nav class="space-x-3">
    <a href="{{ route('recipes.index') }}">Recipes</a>
    <a href="{{ route('meals.index') }}">Meals</a>
    <a href="{{ route('goals.index') }}">Goals</a>
    <a href="{{ route('biometrics.index') }}">Biometrics</a>
  </nav>
  @if(session('ok'))
    <div class="bg-green-100 p-2">{{ session('ok') }}</div>
  @endif
  @yield('content')
</body>
</html>
