<x-layout>

<h1>Login</h1>

<form method="post" action="{{ route('login.process') }}">
    @csrf

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    <label>
        <input type="checkbox"
               name="remember"{{ old('remember') == 'on' ? ' checked' : ''}}>
               remember me
    </label>

    <div>
        <button type="submit">Log in</button>
    </div>

</x-layout>
