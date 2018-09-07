<header>

    <nav class="navbar navbar-default navbar-static-top">
        <div class="container">
            <div class="navbar-header">

                <!-- Collapsed Hamburger -->
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                    <span class="sr-only">Toggle Navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>

                <!-- Branding Image -->
                <a class="navbar-brand" href="{{ url('/') }}">
                    Prodavnica
                </a>
            </div>

            <div class="collapse navbar-collapse" id="app-navbar-collapse">
                <!-- Left Side Of Navbar -->
                <ul class="nav navbar-nav">
                    <li><a href="{{ url('/') }}">Početna strana</a></li>
                    <li><a href="{{ url('/admin') }}">Admin</a></li>
                </ul>

                <!-- Right Side Of Navbar -->
                <ul class="nav navbar-nav navbar-right">
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">Prijavi se</a></li>
                        <li><a href="{{ url('/register') }}">Registruj se</a></li>
                    @else
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                {{ Auth::user()->name }} <span class="caret"></span>
                            </a>

                            <ul class="dropdown-menu">
                                {{--<li><a href="/my/orders">Moje narudžbe</a></li>--}}
                                {{--<li><a href="/my/account">Podesavanja</a></li>--}}
                                <li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Odjavi se</a></li>

                            </ul>
                            {{--<ul class="dropdown-menu" role="menu">--}}
                                {{--<li><a href="{{ url('/my/orders') }}"><i class="fa fa-btn fa-sign-out"></i>Orders</a></li>--}}
                                {{--<li><a href="{{ url('/my/account') }}"><i class="fa fa-btn fa-sign-out"></i>Account</a></li>--}}
                                {{--<li><a href="{{ url('/logout') }}"><i class="fa fa-btn fa-sign-out"></i>Logout</a></li>--}}
                            {{--</ul>--}}
                        </li>
                    @endif
                </ul>
            </div>
        </div>
    </nav>

    <div class="container-fluid">
        <div class="row">
            {{--                    --}}
            {{-- drugi red header-a --}}
            {{--                    --}}
            <div class="row">
                <div class="col-xs-3 col-xs-offset-1">
                    <form class="form-horizontal" method="get" action="/pages/search">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control">
                                <span class="input-group-btn"><button class="btn btn-default" type="submit">Pretraži</button></span>
                            </div>
                        </div>
                    </form>
                </div>
                <div class='col-xs-1'>
                    <ul class='nav nav-pills'>
                        <li>
                            <a href="/shopping_cart"><img src="/src/glyphicons/glyphicons-203-shopping-cart.png"><span
                                        class="badge">@if(Auth::user() && isset($shopping_cart_orders)){{count($shopping_cart_orders)}} @else {{"-"}}@endif</span></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>



</header>

