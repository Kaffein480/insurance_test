<x-layout>

<h1>Register</h1>

<form method="post" action="{{ route('register.process') }}">
    @csrf

    <label for="name">Name</label>
    <input type="text" name="name" id="name" value="{{ old('name') }}">

    @error('name')
        <span role="alert">{{ $message }}</span>
    @enderror

    <label for="email">Email</label>
    <input type="email" name="email" id="email" value="{{ old('email') }}">

    @error('email')
        <span role="alert">{{ $message }}</span>
    @enderror

    <label for="password">Password</label>
    <input type="password" name="password" id="password">

    @error('password')
        <span role="alert">{{ $message }}</span>
    @enderror

    <label for="password_confirmation">Confirm Password</label>
    <input type="password" name="password_confirmation" id="password_confirmation">

    <div>
        <button type="submit">Register</button>
    </div>
</form>

</x-layout>


