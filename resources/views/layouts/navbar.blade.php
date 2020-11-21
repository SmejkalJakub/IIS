<nav class="navbar navbar-expand-sm bg-dark navbar-dark sticky-top" style="padding: 0px">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="collapsibleNavbar">
        <ul class="navbar-nav">
            <li class="nav-item {{ ($activeBar == 'home') ? 'active bg-success' : '' }}">
                <a class="nav-link" style="display: inline-block; padding-left: 14pt; padding-right: 14pt" href="{{route('home')}}">HOME</a>
            </li>
            <li class="nav-item dropdown {{ ($activeBar == 'tests') ? 'active bg-success' : '' }}">
                <a class="nav-link dropdown-toggle" href="#" style="display: inline-block; padding-left: 14pt; padding-right: 14pt" data-toggle="dropdown">TESTS </a>
                <div class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
                    <a class="dropdown-item" href="{{route('tests..', ['student', 'available'])}}">Available</a>
                    <a class="dropdown-item" href="{{route('tests..', ['student', 'registered'])}}">Registered</a>
                    <a class="dropdown-item" href="{{route('tests..', ['student', 'active'])}}">Active</a>
                    <a class="dropdown-item" href="{{route('tests..', ['student', 'history'])}}">History</a>

                    @if(App\Http\Controllers\AuthController::checkUser('assistant'))
                        <div class="dropdown-divider"></div>
                        <h5 class="dropdown-header text-center">Correction</h5>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('tests..', ['assistant', 'available'])}}">Available</a>
                        <a class="dropdown-item" href="{{route('tests..', ['assistant', 'registered'])}}">Registered</a>
                        <a class="dropdown-item" href="{{route('tests..', ['assistant', 'active'])}}">Active</a>
                        <a class="dropdown-item" href="{{route('tests..', ['assistant', 'history'])}}">History</a>
                    @endif

                    @if(App\Http\Controllers\AuthController::checkUser('profesor'))
                        <div class="dropdown-divider"></div>
                        <h5 class="dropdown-header text-center">Creation</h5>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{route('tests..', ['professor', 'myTests'])}}">My tests</a>
                    @endif
                </div>
            </li>

            @if(App\Http\Controllers\AuthController::checkUser('profesor'))
                <li class="nav-item {{ ($activeBar == 'categories') ? 'active bg-success' : '' }}">
                    <a class="nav-link" style="display: inline-block; padding-left: 14pt; padding-right: 14pt" href="{{route('categories')}}">CATEGORIES</a>
                </li>
            @endif

            @if(App\Http\Controllers\AuthController::checkUser('admin'))
                <li class="nav-item {{ ($activeBar == 'users') ? 'active bg-success' : '' }}">
                    <a class="nav-link" style="display: inline-block; padding-left: 14pt; padding-right: 14pt" href="{{route('user-list')}}">USERS</a>
                </li>
            @endif
        </ul>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item {{ ($activeBar == 'userSetting') ? 'active bg-success' : '' }}">
                <a class="nav-link" style="display: inline-block; padding-left: 14pt; padding-right: 14pt" href="{{route('user')}}">{{Auth::user()->first_name}} {{Auth::user()->surname}}</a>
            </li>
        </ul>
    </div>
</nav>
