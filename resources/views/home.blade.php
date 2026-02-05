<x-layout>

<h1>Welcome</h1>

<div>
    @auth
        Hi {{ Auth::user()->name }}.
        
        <a href="{{ route('dashboard') }}">Dashboard</a>

        <a href="{{ route('logout') }}"
           onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">Log out</a>.

        <form id="logout-form"
              action="{{ route('logout') }}"
              method="post"
              style="display: none;">
            @csrf
        </form>
    @else
        <a href="{{ route('register') }}">Register</a> or
        <a href="{{ route('login') }}">log in</a>.
    @endauth
</div>

</x-layout>
