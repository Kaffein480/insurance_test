<x-layout>

    <h1>Login</h1>

    <form method="post" action="{{ route('login.process') }}">
        @csrf


        <div><label for="email" style="display:block; text-align:left; margin-top:0;">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>

        @error('email')
        <span role="alert">{{ $message }}</span>
        @enderror

        <div> <label for="password" style="display:block; text-align:left; margin-top:0;">Password</label>
            <input type="password" name="password" id="password">
        </div>

        @error('password')
        <span role="alert">{{ $message }}</span>
        @enderror

        <div><a href="{{ route('register') }}">Register</a>

            <div>
                <button type="submit">Log in</button>
            </div>
        </div>




</x-layout>