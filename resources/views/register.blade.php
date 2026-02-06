<x-layout>

    <h1>Register</h1>

    <form method="post" action="{{ route('register.process') }}">
        @csrf

        <div>
            <label for="name" style="display:block; text-align:left; margin-top:0;">Name</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}">
        </div>


        @error('name')
        <span role="alert">{{ $message }}</span>
        @enderror

        <div>
            <label for="email" style="display:block; text-align:left; margin-top:0;">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>

        @error('email')
        <span role="alert">{{ $message }}</span>
        @enderror

        <div>
            <label for="password" style="display:block; text-align:left; margin-top:0;">Password</label>
            <input type="password" name="password" id="password">
        </div>

        @error('password')
        <span role="alert">{{ $message }}</span>
        @enderror

        <div>
            <label for="password_confirmation" style="display:block; text-align:left; margin-top:0;">Confirm Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation">
        </div>

        <div>
            <a href="{{ route('login') }}" style="display:block; margin-top:10px;">log in</a>
        </div>

        <div>
            <button type=" submit">Register</button>
        </div>
    </form>

</x-layout>
