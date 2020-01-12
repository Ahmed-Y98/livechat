<nav class="navbar navbar-expand-lg navbar-light bg-light fixed-top">
    <a class="navbar-brand" href="/">{{env('APP_NAME')}}</a>
    <button class="navbar-toggler" data-target="#my-nav" data-toggle="collapse" aria-controls="my-nav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
   
    <div id="my-nav" class="collapse navbar-collapse">
        <ul class="navbar-nav ml-auto">
            @guest
                <li class="nav-item">
                    <a class="nav-link " href="/register">register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link " href="/login">login</a>
                </li>
            @endguest
            @auth
            <li class="nav-item">
                <a class="nav-link log" href="/logout">logout</a>
            </li>
            @endauth
        </ul>
    </div>
   
</nav>