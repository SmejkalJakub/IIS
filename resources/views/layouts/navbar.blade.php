<nav class="navbar navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="{{route('home')}}">Best Tests</a>
        </div>
        <ul class="nav navbar-nav">
            <li class="{{ ($activeBar == 'home') ? 'active' : '' }}"><a href="{{route('home')}}">Home</a></li>
            <li class="{{ ($activeBar == 'tests') ? 'active' : '' }}"><a href="{{route('tests')}}">Tests</a></li>
            @if(Auth::user()->hasRole('profesor'))
                <li class="{{ ($activeBar == 'categories') ? 'active' : '' }}"><a href="{{route('categories')}}">Categories</a></li>
            @endif
            @if(Auth::user()->hasRole('admin'))
                <li class="{{ ($activeBar == 'users') ? 'active' : '' }}"><a href="{{route('user-list')}}">Users</a></li>
            @endif
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li class="{{ ($activeBar == 'userSetting') ? 'active' : '' }}"><a href="{{route('user')}}"><span class="glyphicon glyphicon-user"></span> {{Auth::user()->first_name}} {{Auth::user()->surname}}</a></li>
            <li><a href="{{route('logout')}}"><span></span> Logout</a></li>
        </ul>
    </div>
</nav>
