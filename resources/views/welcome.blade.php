@if (Auth::check())
    @include('home')
@else
    @include('auth.login')
@endif

