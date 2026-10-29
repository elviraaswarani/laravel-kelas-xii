<div class="header">
  <div class="container">
    <div class="w3layouts_logo">
      <a href="{{ route('home') }}"><h1>One<span>Movies</span></h1></a>
    </div>
    <div class="w3_search">
      <form action="{{ route('movies') }}" method="get" role="search">
        <label class="sr-only" for="movie-search">Cari film</label>
        <input id="movie-search" type="search" name="search" placeholder="Search movies" value="{{ request('search') }}">
        <button type="submit" aria-label="Cari film">Go</button>
      </form>
    </div>
    <div class="w3l_sign_in_register">
      <ul>
        @guest
          <li><a href="#" data-toggle="modal" data-target="#myModal">Login / Register</a></li>
        @else
          <li><span class="auth-user-name">{{ Auth::user()->name }}</span></li>
          @if (Auth::user()->role?->name === 'admin')
            <li><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
          @endif
          <li>
            <form action="{{ route('logout') }}" method="post" class="logout-form">
              @csrf
              <button type="submit">Logout</button>
            </form>
          </li>
        @endguest
      </ul>
    </div>
    <div class="clearfix"> </div>
  </div>
</div>