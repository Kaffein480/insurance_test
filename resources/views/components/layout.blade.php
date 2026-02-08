<!DOCTYPE html>
<html>

<head>
    <title>Insurance</title>
    <link rel="stylesheet" href="https://cdn.simplecss.org/simple-v1.css">
</head>

<body>

    @if (session('status'))
    <div style="
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
        padding: 12px 16px;
        border-radius: 8px;
        margin: 15px 0;
        font-size: 14px;
        box-shadow: 0 2px 6px rgba(0,0,0,0.05);
    ">
        {{ session('status') }}
    </div>
    @endif

    @if (!request()->is('dashboard*')
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