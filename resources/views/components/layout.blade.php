<!DOCTYPE html>
<html>

<head>
    <title>Insurance</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple.min.css">
</head>

<body>

    @if (session('status'))
    <div class="notice">{{ session('status') }}</div>
    @endif

    {{ $slot }}

</body>

</html>