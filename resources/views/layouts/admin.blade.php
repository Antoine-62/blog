<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://cdn.WebRTC-Experiment.com/RecordRTC.js"></script>
    <script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	 

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">
	

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
	<style>
#container {
	margin: 0px auto;
	width: 500px;
	height: 375px;
	border: 10px #333 solid;
}
#videoElement {
	width: 500px;
	height: 375px;
	background-color: #666;
}

#myProgress1 {
  width: 100%;
  background-color: grey;
}

#myBar1 {
  width: 0%;
  height: 30px;
  background-color: green;
}

#myProgress2 {
  width: 100%;
  background-color: grey;
}

#myBar2 {
  width: 0%;
  height: 30px;
  background-color: green;
}

#myProgress3 {
  width: 100%;
  background-color: grey;
}

#myBar3 {
  width: 0%;
  height: 30px;
  background-color: green;
}

#myProgress4 {
  width: 100%;
  background-color: grey;
}

#myBar4 {
  width: 0%;
  height: 30px;
  background-color: green;
}

#myProgress5 {
  width: 100%;
  background-color: grey;
}

#myBar5 {
  width: 0%;
  height: 30px;
  background-color: green;
}

</style>
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>
								
								
								<?php 
									#the path to go to profile route
									$slug =DB::table('users')->where('id',Auth::user()->id)->value('slug');
									$profil='MyProfil/'.$slug;
									?>
									
									
                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
								<a class="dropdown-item" href="{{ URL($profil)}}">
                                        {{ __('View profile') }}
                                    </a>
									
                                    <form action="{{ URL($profil)}}" method="POST" style="display: none;">
                                       {{ csrf_field() }}
										@method('get')
                                    </form>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>									
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
		
	<main class="py-4">
			
			<img src="{{ URL::to('uploads/'.DB::table('banner_image')->value('Name'))}}" alt="failure"/>
			
			@if (Auth::user()->isAdmin())
		<section style="float:left; width: 25%;">
            <div class="container">
                 <ul>
                       <li class="nav-item"><a class="nav-link" href="{{ route('AddUser') }}"> {{ __('Register') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('Home2') }}"> {{ __('Home') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('About-us') }}"> {{ __('About us') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('display-Member') }}"> {{ __('Product') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('form') }}"> {{ __('Add a Product') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('ProducQ-Form') }}"> {{ __('Add a ProductQ') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}"> {{ __('FAQ') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('admin/add/faq') }}"> {{ __('Add a question (FAQ)') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('AddPermission') }}"> {{ __('Add permission') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('display-Permission') }}"> {{ __('Permission List') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('display-User') }}"> {{ __('User List') }}</a></li>
                       <li class="nav-item"><a class="nav-link" href="{{ route('AddBannerImage') }}"> {{ __('Banner Image') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('getGlobalVariable') }}"> {{ __('Test Global Variable') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('Contact-us') }}"> {{ __('Contact us') }}</a></li>
                      </ul>
            </div>
        </section>
		@else
			<section style="float:left; width: 25%;">
            <div class="container">
                 <ul>
					   <li class="nav-item"><a class="nav-link" href="{{ route('Home2') }}"> {{ __('Home') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('About-us') }}"> {{ __('About us') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('display-Member') }}"> {{ __('Product') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('form') }}"> {{ __('Add a Product') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('ProducQ-Form') }}"> {{ __('Add a ProductQ') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}"> {{ __('FAQ') }}</a></li>
					   <li class="nav-item"><a class="nav-link" href="{{ route('Contact-us') }}"> {{ __('Contact us') }}</a></li>
                      </ul>
            </div>
        </section>

@endif
<section style="float:right; width: 75%;">
		
		
		

	@if (Session::has('message'))
	<h3><strong>{{ Session::get('message') }}</strong></h3>
 @endif
            @yield('content')
        </main>
    </div>
</section>
</body>
</html>
