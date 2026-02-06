<!DOCTYPE html>
<html>

<head>
    <title>Insurance</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple-v1.css">
</head>

<body>

    @if (session('status'))
    <div class="notice">{{ session('status') }}</div>
    @endif

    @if (!request()->is('dashboard*')
    && !request()->is('login')
    && !request()->is('register')
    && !request()->is('/'))
    <a href="{{ url()->previous() }}"
        style="
        position: fixed;
        top: 15px;
        left: 15px;
        text-decoration: none;
        padding: 6px 12px;
        border: 1px solid #ccc;
        border-radius: 6px;
        background: white;
        font-size: 14px;">
        ← Kembali
    </a>
    @endif

    {{ $slot }}

</body>

</html>