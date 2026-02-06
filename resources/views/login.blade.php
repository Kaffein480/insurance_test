<x-layout>

    <h1>Login</h1>

    <form method="post" action="{{ route('login.process') }}">
        @csrf


        <div><label for="email" style="display:block; text-align:left; margin-top:0;">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}">
        </div>

        <div> <label for="password" style="display:block; text-align:left; margin-top:0;">Password</label>
            <input type="password" name="password" id="password">
        </div>

        <div><label style="display:block; text-align:left; margin-top:0;">
                <input type="checkbox"
                    name="remember" {{ old('remember') == 'on' ? ' checked' : ''}}>
                remember me
            </label></div>

        <div><a href="{{ route('register') }}">Register</a>

            <div>
                <button type="submit">Log in</button>
            </div>
        </div>




</x-layout>