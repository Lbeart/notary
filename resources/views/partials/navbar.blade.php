<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="{{ url('/') }}">Notary System</a>
    <div class="collapse navbar-collapse">
      <ul class="navbar-nav ms-auto">
        @auth
          <li class="nav-item"><a class="nav-link" href="#">Hi, {{ auth()->user()->name }}</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('logout') }}">Logout</a></li>
        @else
         <li class="nav-item">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="nav-link btn btn-link" style="display: inline; padding: 0; margin: 0; border: none; background: none;">
            Dil
        </button>
    </form>
</li>
          <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Register</a></li>
        @endauth
      </ul>
    </div>
  </div>
</nav>
