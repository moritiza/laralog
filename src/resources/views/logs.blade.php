<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/384241e27b.js" crossorigin="anonymous"></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <style>

        a {
            color: #000;
        }

        a:hover {
            text-decoration: none;
            color: #000;
        }

        .active-list-item {
            background-color: rgba(0, 0, 0, 0.03) !important;
        }

        .logs-menu > li {
            padding: 0 !important;
        }

        .logs-menu > li > a {
            padding: 10px 12px !important;
        }

        .counter-btn {
            margin-left: 7px;
        }

        .counter-btn:hover {
            pointer-events: none;
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

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
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


            <div class="container">

                <div class="row">
                    <div class="col-md-3">
                        <div class="card mt-5">
                            <div class="card-header">
                                <h5 class="card-title"><i class="fa fa-calendar mr-2"></i>MoriTiza Log Viewer</h5>
                                <h6 class="card-subtitle mt-3 text-muted">by Morteza Nasiri</h6>
                            </div>

                        </div>

                        <div class="card mt-3">
                            <ul class="list-group list-group-flush logs-menu">
                                @if (count($singleLogs) > 0)
                                    @if ($currentLog === 'laravel')
                                        <li class="list-group-item active-list-item"><a href="logs" style="display: block;">laravel.log</a></li>
                                    @else
                                        <li class="list-group-item"><a href="logs" style="display: block;">laravel.log</a></li>
                                    @endif
                                @endif

                                @if (count($dailyLogs) > 0)
                                    @foreach ($dailyLogs as $log => $content)
                                        @if ($log === $currentLog)
                                            <li class="list-group-item active-list-item"><a href="?log={{ $log }}" style="display: block;">{{ $log }}</a></li>
                                        @else
                                            <li class="list-group-item"><a href="?log={{ $log }}" style="display: block;">{{ $log }}</a></li>
                                        @endif
                                    @endforeach
                                @endif

                            </ul>
                        </div>
                    </div>

                    @php $counter = array(
                                        'info' => 0,
                                        'error' => 0,
                                        'warning' => 0,
                                        'debug' => 0,
                                        'notice' => 0,
                                        'alert' => 0,
                                        'emergency' => 0,
                                        'critical' => 0
                                    )
                    @endphp

                    @if ($currentLog === 'laravel')
                        @foreach ($singleLogs as $log => $content)
                            @php preg_match('/(DEBUG|INFO|NOTICE|WARNING|ERROR|CRITICAL|ALERT|EMERGENCY)/', $content, $matches) @endphp

                            @if ($matches[0] === 'INFO')
                                @php $counter['info'] += 1 @endphp
                            @elseif ($matches[0] === 'ERROR')
                                @php $counter['error'] += 1 @endphp
                            @elseif ($matches[0] === 'WARNING')
                                @php $counter['warning'] += 1 @endphp
                            @elseif ($matches[0] === 'DEBUG')
                                @php $counter['debug'] += 1 @endphp
                            @elseif ($matches[0] === 'NOTICE')
                                @php $counter['notice'] += 1 @endphp
                            @elseif ($matches[0] === 'ALERT')
                                @php $counter['alert'] += 1 @endphp
                            @elseif ($matches[0] === 'EMERGENCY')
                                @php $counter['emergency'] += 1 @endphp
                            @elseif ($matches[0] === 'CRITICAL')
                                @php $counter['critical'] += 1 @endphp
                            @endif
                        @endforeach
                    @elseif ($currentLog !== null)
                        @foreach ($dailyLogs[$currentLog] as $log => $content)
                            @php preg_match('/(DEBUG|INFO|NOTICE|WARNING|ERROR|CRITICAL|ALERT|EMERGENCY)/', $content, $matches) @endphp

                            @if ($matches[0] === 'INFO')
                                @php $counter['info'] += 1 @endphp
                            @elseif ($matches[0] === 'ERROR')
                                @php $counter['error'] += 1 @endphp
                            @elseif ($matches[0] === 'WARNING')
                                @php $counter['warning'] += 1 @endphp
                            @elseif ($matches[0] === 'DEBUG')
                                @php $counter['debug'] += 1 @endphp
                            @elseif ($matches[0] === 'NOTICE')
                                @php $counter['notice'] += 1 @endphp
                            @elseif ($matches[0] === 'ALERT')
                                @php $counter['alert'] += 1 @endphp
                            @elseif ($matches[0] === 'EMERGENCY')
                                @php $counter['emergency'] += 1 @endphp
                            @elseif ($matches[0] === 'CRITICAL')
                                @php $counter['critical'] += 1 @endphp
                            @endif
                        @endforeach
                    @endif

                    <div class="col-md-9">
                        <div class="card mt-5">
                            <div class="card-header">
                            <span class="btn btn-info btn-sm">INFO
                                <span class="badge badge-light">{{ $counter['info'] }}</span>
                            </span>
                            <span class="btn btn-danger btn-sm counter-btn">ERROR
                                <span class="badge badge-light">{{ $counter['error'] }}</span>
                            </span>
                            <span class="btn btn-warning btn-sm counter-btn">WARNING
                                <span class="badge badge-light">{{ $counter['warning'] }}</span>
                            </span>
                            <span class="btn btn-success btn-sm counter-btn">DEBUG
                                <span class="badge badge-light">{{ $counter['debug'] }}</span>
                            </span>
                            <span class="btn btn-primary btn-sm counter-btn">NOTICE
                                <span class="badge badge-light">{{ $counter['notice'] }}</span>
                            </span>
                            <span class="btn btn-light btn-sm counter-btn">ALERT
                                <span class="badge badge-light">{{ $counter['alert'] }}</span>
                            </span>
                            <span class="btn btn-dark btn-sm counter-btn">EMERGENCY
                                <span class="badge badge-light">{{ $counter['emergency'] }}</span>
                            </span>
                            <span class="btn btn-secondary btn-sm counter-btn">CRITICAL
                                <span class="badge badge-light">{{ $counter['critical'] }}</span>
                            </span>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th style="width: 15% !important;">Level</th>
                                                <th style="width: 20% !important;">Date</th>
                                                <th style="width: 65% !important;">Description</th>
                                            </tr>
                                        </thead>

                                        @if ($currentLog === 'laravel')
                                            <tbody>
                                                @php $i = 1 @endphp
                                                @foreach ($paginatedSingleLogs as $log => $content)
                                                    <tr>
                                                        @php preg_match('/(DEBUG|INFO|NOTICE|WARNING|ERROR|CRITICAL|ALERT|EMERGENCY)/', $content, $matches) @endphp

                                                        <td style="font-size: 17px;">
                                                            @if ($matches[0] === 'INFO')
                                                                <span class="badge badge-info">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'ERROR')
                                                                <span class="badge badge-danger">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'WARNING')
                                                                <span class="badge badge-warning">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'DEBUG')
                                                                <span class="badge badge-success">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'NOTICE')
                                                                <span class="badge badge-primary">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'ALERT')
                                                                <span class="badge badge-light">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'EMERGENCY')
                                                                <span class="badge badge-dark">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'CRITICAL')
                                                                <span class="badge badge-secondary">{{ strtolower($matches[0]) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ substr($content, 1, 10) }}<br />{{ substr($content, 12, 8) }}</td>
                                                        @php preg_match('/: .*/', $content, $matches) @endphp
                                                        <td><span id="lessText{{ $i }}">{{ substr(ltrim($matches[0], ': '), 0, 60) }}</span>
                                                            @if (strlen($matches[0]) > 59) <span class="badge badge-primary" id="showMore{{ $i }}" onclick="showMore({{ $i }})" style="cursor: pointer;">show more</span> @endif
                                                            <span id="moreText{{ $i }}" style="display: none;">{{ ltrim($matches[0], ': ') }}
                                                            <span class="badge badge-primary" id="showLess{{ $i }}" onclick="showLess({{ $i }})" style="cursor: pointer;">show less</span></span>
                                                        </td>
                                                    </tr>
                                                @php $i++ @endphp
                                                @endforeach
                                            </tbody>

                                        @elseif ($currentLog !== null)
                                            <tbody>
                                                @php $i = 1 @endphp
                                                @foreach ($paginatedDailyLogs as $log => $content)
                                                    <tr>
                                                    @php preg_match('/(DEBUG|INFO|NOTICE|WARNING|ERROR|CRITICAL|ALERT|EMERGENCY)/', $content, $matches) @endphp

                                                        <td style="font-size: 17px;">
                                                            @if ($matches[0] === 'INFO')
                                                                <span class="badge badge-info">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'ERROR')
                                                                <span class="badge badge-danger">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'WARNING')
                                                                <span class="badge badge-warning">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'DEBUG')
                                                                <span class="badge badge-success">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'NOTICE')
                                                                <span class="badge badge-primary">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'ALERT')
                                                                <span class="badge badge-light">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'EMERGENCY')
                                                                <span class="badge badge-dark">{{ strtolower($matches[0]) }}</span>
                                                            @elseif ($matches[0] === 'CRITICAL')
                                                                <span class="badge badge-secondary">{{ strtolower($matches[0]) }}</span>
                                                            @endif
                                                        </td>
                                                        <td>{{ substr($content, 1, 10) }}<br />{{ substr($content, 12, 8) }}</td>
                                                        @php preg_match('/: .*/', $content, $matches) @endphp
                                                        <td><span id="lessText{{ $i }}">{{ substr(ltrim($matches[0], ': '), 0, 60) }}</span>
                                                            @if (strlen($matches[0]) > 59) <span class="badge badge-primary" id="showMore{{ $i }}" onclick="showMore({{ $i }})" style="cursor: pointer;">show more</span> @endif
                                                            <span id="moreText{{ $i }}" style="display: none;">{{ ltrim($matches[0], ': ') }}
                                                                <span class="badge badge-primary" id="showLess{{ $i }}" onclick="showLess({{ $i }})" style="cursor: pointer;">show less</span>
                                                            </span>
                                                        </td>
                                                    </tr>
                                                @php $i++ @endphp
                                                @endforeach
                                            </tbody>
                                        @endif
                                    </table>
                                </div>
                            </div>

                            @if ($currentLog === 'laravel' && count($singleLogs) > 5)
                                <div class="card-footer">
                                    {{ $paginatedSingleLogs->links() }}
                                </div>
                            @elseif (isset($dailyLogs[$currentLog]) && count($dailyLogs[$currentLog]) > 5)
                                <div class="card-footer">
                                    {{ $paginatedDailyLogs->links() }}
                                </div>
                            @endif

                        </div>
                    </div>
                </div>

            </div>


        </main>
    </div>

    <script>
        function showMore(i)
        {
            var element = document.getElementById('showMore' + i);
            var lessText = document.getElementById('lessText' + i);
            var moreText = document.getElementById('moreText' + i);

            element.style.display = "none";
            lessText.style.display = "none";
            moreText.style.display = "inline";
        }

        function showLess(i)
        {
            var element = document.getElementById('showMore' + i);
            var lessText = document.getElementById('lessText' + i);
            var moreText = document.getElementById('moreText' + i);

            element.style.display = "inline";
            lessText.style.display = "inline";
            moreText.style.display = "none";
        }
    </script>
</body>
</html>
