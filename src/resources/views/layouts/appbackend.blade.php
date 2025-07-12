<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title> สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี </title>
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}">

    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- App css -->
    <link href="{{ asset('template-end/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" id="bootstrap-stylesheet" />
    <link href="{{ asset('template-end/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('template-end/css/app.min.css') }}" rel="stylesheet" type="text/css" id="app-stylesheet" />
    <style>
        body {
            font-family: 'IBM Plex Sans Thai', sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .btn {
            font-family: 'IBM Plex Sans Thai', sans-serif;
        }

        .logo-lg {
            height: 70px;
            border-bottom: 1px solid #ff9800;
        }

        .page-title-box {
            padding: 12px 20px;
        }

        .drinkcard-cc {
            color: #fff;
            padding: 0.25rem;
            border-radius: 5px;
        }

        .note-popover .popover-content,
        .card-header.note-toolbar {
            z-index: 2;
        }

        #sidebar-menu>ul>li>a {
            color: #030303;
        } 
    </style>
    @yield('style')
</head>

<body>

    <div id="wrapper">
        <div class="navbar-custom">
            @guest
            @else
            <ul class="list-unstyled topnav-menu float-right mb-0">
                <li class="dropdown notification-list">
                    <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                        <img src="{{ asset('images/admin.png') }}" alt="user-image" class="rounded-circle bg-white">
                        <span class="pro-user-name ml-1">
                            {{ Auth::user()->name }} <i class="mdi mdi-chevron-down"></i>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right profile-dropdown ">

                        <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0"> ยินดีต้อนรับเข้าสู่ระบบ </h6>
                        </div>

                        <a href="{{ route('profile') }}" class="dropdown-item notify-item">
                            <i class="fe-settings"></i>
                            <span>ตั้งค่าข้อมูลส่วนตัว</span>
                        </a>

                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item notify-item" onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                            <i class="fe-log-out"></i>
                            <span>ออกจากระบบ</span>
                        </a>
                        <form id="logout-form" action="{{ route('signOut') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </div>
                </li>
            </ul>
            @endguest

            <div class="logo-box">
                <a href="{{ route('home') }}" class="logo text-center">
                    <span class="logo-lg">
                        <img src="{{ asset('images/logo.png') }}" height="35">
                        <span class="text-primary"> สำนักศิลปะและวัฒนธรรม </span>

                    </span>
                    <span class="logo-sm">
                        <img src="{{ asset('images/logo.png') }}" height="35">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                        <i class="fe-menu"></i>
                    </button>
                </li>
            </ul>
        </div>

        <div class="left-side-menu">
            <div class="slimscroll-menu">
                <div id="sidebar-menu">
                    <ul class="metismenu" id="side-menu">
                        <li class="menu-title"> Management Data </li>
                        <li>
                            <a href="{{ route('home') }}">
                                <i class="fe-home"></i>
                                <span> หน้าหลัก </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('news.list') }}">
                                <i class="dripicons-broadcast"></i>
                                <span> ข่าวประชาสัมพันธ์ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('activity.list') }}">
                                <i class="fe-grid"></i>
                                <span> โครงการ/กิจกรรม </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('acticonservation.list') }}">
                                <i class="fe-layers"></i>
                                <span> กิจกรรมหน่วยอนุรักษ์ฯ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('research.list') }}">
                                <i class="fe-file-text"></i>
                                <span> งานวิจัยและบทความ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('book.list') }}">
                                <i class="fe-book"></i>
                                <span> หนังสือและวารสารสำนัก </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('learning.list') }}">
                                <i class="fe-box"></i>
                                <span> แหล่งเรียนรู้ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('journals.list') }}">
                                <i class="fe-folder"></i>
                                <span> วารสาร/หมายข่าว </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('qualitie.list') }}">
                                <i class="fa fa-asterisk"></i>
                                <span> งานประกันคุณภาพ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('networks.list') }}">
                                <i class="fa fa-sitemap"></i>
                                <span> เครือข่ายความร่วมมือ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('reportannuals.list') }}">
                                <i class="fa fa-universal-access"></i>
                                <span> ประกันคุณภาพการศึกษา </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('studys.list') }}">
                                <i class="fa fa-book"></i>
                                <span> พระนารายณ์ศึกษา </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('culturehalls.list') }}">
                                <i class="fa fa-building"></i>
                                <span> หอวัฒนธรรม </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('slideshow.list') }}">
                                <i class="fe-image"></i>
                                <span> รูปสไลด์ </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('popups.list') }}">
                                <i class="fe-image"></i>
                                <span> Pop Up </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('appeals.list') }}">
                                <i class="fa fa-comments"></i>
                                <span> ร้องเรียนร้องทุกข์ </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('menu.list') }}">
                                <i class="fe-list"></i>
                                <span> จัดการเมนู </span>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('page.list') }}">
                                <i class="fe-file-plus"></i>
                                <span> จัดการหน้า (Page) </span>
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('roles.list') }}">
                                <i class="fe-users"></i>
                                <span> ผู้ใช้งานระบบ </span>
                            </a>
                        </li>


                    </ul>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>

        <div class="content-page">
            @yield('content')
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            2022 - {{date('Y')}} &copy; Culture TRU | สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="{{ asset('template-end/js/vendor.min.js') }}"></script>
    <script src="{{ asset('template-end/js/app.min.js') }}"></script>
    @yield('script')
</body>

</html>