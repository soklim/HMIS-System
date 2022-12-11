<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'HMIS') }}</title>
    <link rel="icon" href="/assets/images/logo.png" type="image/png" />

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!--Plug in-->
    <script src="/assets/js/jquery.min.js"></script>
    <link href="/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/assets/plugins/metismenu/css/metisMenu.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
    <link href="/assets/plugins/select2/css/select2.min.css" rel="stylesheet" />
    <link href="/assets/plugins/jquery-ui/jquery-ui.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="/assets/css/app.css" rel="stylesheet">
    <link href="/assets/css/icons.css" rel="stylesheet">
    <link href="/assets/plugins/sweet-alert2/sweetalert2.min.css" rel="stylesheet" />
    <script src="/assets/js/bootstrap.bundle.min.js"></script>
    <script src="/assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <script src="/assets/plugins/sweet-alert2/sweetalert2.min.js"></script>

    <script src="/assets/plugins/select2/js/select2.min.js"></script>
    <script src="/assets/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <style href="/assets/css/global.css" rel="stylesheet"></style>
    <script src="/assets/js/Global.js"></script>
    <!--app JS-->
    <script src="/assets/js/app.js"></script>
    <link href="/assets/plugins/datetimepicker/css/classic.css" rel="stylesheet" />
    <link href="/assets/plugins/datetimepicker/css/classic.time.css" rel="stylesheet" />
    <link href="/assets/plugins/datetimepicker/css/classic.date.css" rel="stylesheet" />
    <link rel="stylesheet" href="/assets/plugins/bootstrap-material-datetimepicker/css/bootstrap-material-datetimepicker.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Hanuman&display=swap');
    </style>
    <style>
        body {
            font-family: 'Hanuman', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 12px;
        }
        .form-select{
            font-size: 12px;
            height: 38px;
        }

        .select2-container .select2-selection--single {
            height: 38px !important;
        }
        .highlight {
            border: 1px solid red !important;
        }
    </style>

</head>
<body>

<!--wrapper-->
<div class="wrapper">
    <!--sidebar wrapper -->
    <div class="sidebar-wrapper" data-simplebar="true">
        <div class="sidebar-header">
            <div>
                <img src="/assets/images/MOH_logo.png" class="logo-icon" alt="logo icon" />
            </div>
            <div>
                <h4 class="logo-text text-center text-success" style="font-weight:bold;">HMIS</h4>
            </div>
            <div class="toggle-icon ms-auto text-success">
                <i class='bx bx-arrow-to-left'></i>
            </div>
        </div>
        <!--navigation-->
        <ul class="metismenu" id="menu" >
            @guest
                @if (Route::has('login'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>
                @endif
                @if (Route::has('register'))
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                    </li>
                @endif
            @else
                <?php
                $rolde_id = Auth::user()->role_id;
                $groupModule = DB::table('module_permissions')
                    ->join('modules', 'module_permissions.module_id', '=', 'modules.id')
                    ->join('group_modules', 'modules.group_id', '=', 'group_modules.id')
                    ->where('module_permissions.role_id', $rolde_id)->where('module_permissions.a_read', 1)
                    ->select('group_modules.*')->distinct('group_modules.id,group_modules.name,group_modules.icon')
                    ->get();

                ?>
                @foreach($groupModule as $item)
                    <li style="border-top: solid 1px #d6d6d6;border-bottom: solid 1px #d6d6d6">
                        <a class="has-arrow" href="javascript:;">
                            <div class="parent-icon"><i class='bx bx-{{$item->icon}}'></i>
                            </div>
                            <div class="menu-title">{{$item->name}}</div>
                        </a>
                        <ul>
                            <?php
                                $group_id = $item->id;
                                $module = DB::table('module_permissions')
                                    ->join('modules', 'module_permissions.module_id', '=', 'modules.id')
                                    ->join('group_modules', 'modules.group_id', '=', 'group_modules.id')
                                    ->where('module_permissions.role_id', $rolde_id)
                                    ->where('module_permissions.a_read', 1)
                                    ->where('modules.group_id', $group_id)
                                    ->select('modules.*')->distinct('modules.id,modules.name,modules.route_name ')
                                    ->get();

                            ?>
                            @foreach($module as $item1)

                            <li> <a href="{{$item1->route_name}}"><i class="bx bx-right-arrow-alt"></i>{{$item1->name}}</a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                @endforeach
            @endguest
        </ul>
        <!--end navigation-->
    </div>
    <!--end sidebar wrapper -->
    <!--start header -->
    <header>
        <div class="topbar d-flex align-items-center">
            <nav class="navbar navbar-expand">
                <div class="mobile-toggle-menu">
                    <i class='bx bx-menu'></i>
                </div>
                <div class="search-bar flex-grow-1">
                    <div class="position-relative search-bar-box">
                        <input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
                        <span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
                    </div>
                </div>
                <div class="top-menu ms-auto">
                    <ul class="navbar-nav align-items-center">
                        <li class="nav-item mobile-search-icon">
                            <a class="nav-link" href="#">
                                <i class='bx bx-search'></i>
                            </a>
                        </li>

                    </ul>
                </div>
                <div class="user-box dropdown">
                    <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <img src="/assets/images/user.png" class="user-img" alt="user avatar"/>
                        <div class="user-info ps-3">
                            @guest
                                <p class="user-name mb-0"> HMIS</p>
                            @else
                                <p class="user-name mb-0"> {{ Auth::user()->role->name }}</p>
                            @endguest
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;"><i class="bx bx-cog"></i><span>Settings</span></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;"><i class='bx bx-dollar-circle'></i><span>Earnings</span></a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="javascript:;"><i class='bx bx-download'></i><span>Downloads</span></a>
                        </li>
                        <li>
                            <div class="dropdown-divider mb-0"></div>
                        </li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            <i class='bx bx-log-out-circle'></i><span> {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </ul>
                </div>
            </nav>
        </div>
    </header>
    <!--end header -->
    <!--start page wrapper -->
    <div class="page-wrapper">
        <div class="page-content">
            @yield('content')
        </div>
    </div>
    <!--end page wrapper -->
    <!--start overlay-->
    <div class="overlay toggle-icon"></div>
    <!--end overlay-->
    <!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
    <!--End Back To Top Button-->
    <footer class="page-footer">
        <p class="mb-0">Copyright © All right reserved By HMIS v.1.0.</p>
    </footer>
    <script type="text/javascript">
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

    </script>
    <script src="/assets/plugins/metismenu/js/metisMenu.min.js"></script>
    <!--datetimepicker js -->
    <script src="/assets/plugins/datetimepicker/js/legacy.js"></script>
    <script src="/assets/plugins/datetimepicker/js/picker.js"></script>
    <script src="/assets/plugins/datetimepicker/js/picker.time.js"></script>
    <script src="/assets/plugins/datetimepicker/js/picker.date.js"></script>
    <script src="/assets/plugins/bootstrap-material-datetimepicker/js/moment.min.js"></script>
    <script src="/assets/plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.min.js"></script>
</div>
<!--end wrapper-->

</body>
</html>
