<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Primary Meta Tags -->
    <title> สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</title>
    @yield('meta')

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/x-icon">

    <!-- Google Fonts -->
    <!-- <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;500;600&display=swap" rel="stylesheet"> -->
    <!-- fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Sans+Thai:wght@100;200;300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('template-front/css/font-awesome.min.css') }}">

    <!-- Bootstrap Framework -->
    <link rel="stylesheet" href="{{ asset('template-front/css/bootstrap.min.css') }}">

    <!-- Animate.css Plugin -->
    <link rel="stylesheet" href="{{ asset('template-front/css/animate.min.css') }}">

    <!-- Owl Carousel Plugin -->
    <link rel="stylesheet" href="{{ asset('template-front/css/owl.carousel.min.css') }}">

    <!-- Magnific Popup Plugin -->
    <link rel="stylesheet" href="{{ asset('template-front/css/magnific-popup.css') }}">

    <!-- Main Stylesheet -->
    <link rel="stylesheet" href="{{ asset('template-front/css/style.css') }}">

    <!-- Responsive Stylesheet -->
    <link rel="stylesheet" href="{{ asset('template-front/css/responsive.css') }}">

    <!-- Theme Color Stylesheet -->
    <link rel="stylesheet" href="{{ asset('template-front/css/theme-color.css') }}">

    <!-- Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('template-front/css/custom.css') }}">

    <!-- Magnific Stylesheet -->
    <link rel="stylesheet" href="{{ asset('magnific-popup.css') }}">
    <style>
        .sec-title {
            background: #662c81;
            background: url("{{ asset('images/title.png') }}");
            background-size: cover;
        }

        body,
        h1,
        .h1,
        h2,
        .h2,
        h3,
        .h3,
        h4,
        .h4,
        h5,
        .h5,
        h6,
        .h6 {
            font-family: 'IBM Plex Sans Thai', sans-serif;
        }

        .toggle-mobile {
            display: flex;
            justify-content: center;
        }

        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, .125);
            border-radius: .25rem;
        }

        .card-img-top {
            width: 100%;
            border-top-left-radius: calc(.25rem - 1px);
            border-top-right-radius: calc(.25rem - 1px);
        }

        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            padding: 1.25rem;
        }

        .rounded {
            border-radius: .25rem !important;
        }

        .mb-1 {
            margin-bottom: .375rem !important;
        }

        .responsive-h1 {
            font-size: 32px;
            line-height: 1.2;
        }

        .card-img {
            width: 100%;
            height: 230px;
            background-size: cover;
            background-position: center;
            border-top-left-radius: .25rem;
            border-top-right-radius: .25rem;
        }

        .font-size-11 {
            font-size: 11px;
        }

        .font-size-12 {
            font-size: 12px;
        }

        .owl-dots {
            position: absolute;
            left: 0;
            right: 0;
            bottom: -10px;
            text-align: center;
        }

        .height-b-150 {
            height: 150px;
        }

        /* Tablet */
        @media (max-width: 768px) {
            .responsive-h1 {
                font-size: 24px;
            }
        }

        /* Mobile */
        @media (max-width: 480px) {
            .responsive-h1 {
                font-size: 18px;
            }

            .height-b-150 {
                height: 200px;
            }
        }

        @media (max-width: 600px) {
            .toggle-mobile {
                justify-content: flex-end;
            }
        }
    </style>
    @yield('style')
</head>

<body id="body">

    <div class="wrapper">

        <div class="header--infobar">
            <div class="container">
                <div class="logo float--left">
                    <a href="{{ route('index') }}">
                        <img src="{{ asset('images/logo.png') }}" alt="" width="50" height="50">
                        <div style="margin-left: 10px;">
                            <div>สำนักศิลปะและวัฒนธรรม</div>
                            <small>มหาวิทยาลัยราชภัฏเทพสตรี</small>
                        </div>
                    </a>
                </div>
                <ul class="info nav float--right hidden-xs">
                    <li>
                        <div class="icon">
                            <i class="fa fa-phone-square"></i>
                        </div>

                        <div class="content">
                            <p>เบอร์โทรศัพท์</p>
                            <p><a href="tel:+123456123456">036 - 413096</a></p>
                        </div>
                    </li>

                    <li>
                        <div class="icon">
                            <i class="fa fa-map-marker"></i>
                        </div>

                        <div class="content">
                            <p>มหาวิทยาลัยราชภัฏเทพสตรี</p>
                            <p> 321 ต.ทะเลชุบศร อ.เมือง จ.ลพบุรี 15000</p>
                        </div>
                    </li>

                    <li>
                        <div class="icon">
                            <i class="fa fa-clock-o"></i>
                        </div>

                        <div class="content">
                            <p>08:30 - 16:30 pm</p>
                            <p>จันทร์ - ศุกร์</p>
                        </div>
                    </li>
                </ul>
            </div>
        </div>

        <nav class="header--navbar navbar bg--color-theme" data-sticky="999">
            <div class="container-fluid toggle-mobile">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#headerNav" aria-expanded="false">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                </div>

                <div id="headerNav" class="collapse navbar-collapse">
                    <?php

                    use App\Http\Controllers\Frontend\HomeController;

                    $newClass = new HomeController;
                    $QueryMenu = $newClass->Ordermenu();

                    echo '<ul class="header--nav-links nav float--left">';
                    if (isset($QueryMenu) && count($QueryMenu) > 0) {
                        foreach ($QueryMenu as $row) {
                            $children_count = 0;
                            if (isset($row['children']) && count($row['children']) > 0) {
                                $children_count = 1;
                            }
                            if ($children_count == 0) {
                                echo '<li> <a href="' . url($row['link']) . '">' . $row['name'] . '</a> </li>';
                            } elseif ($children_count == 1) {
                                $html = '<li class="dropdown">';
                                $html .= '<a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"> ' . $row['name'] . '<span class="caret"></span> </a>';
                                $html .= '<ul class="dropdown-menu">';
                                foreach ($row['children'] as $row2) {
                                    $html .= '<li><a href="' . url($row2['link']) . '">' . $row2['name'] . '</a></li>';
                                }
                                $html .= '</ul>';
                                $html .= '</li>';
                                echo $html;
                            }
                        }
                    }
                    echo '</ul>';
                    ?>
                </div>
            </div>
        </nav>

    </div>

    <!-- // *****************CONTENT***************** // -->
    @yield('content')
    <!-- // *****************CONTENT***************** // -->

    <div class="footer--section">
        <div class="footer--widgets">
            <div class="container">
                <div class="row AdjustRow">
                    <div class="col-md-4 col-xs-6 col-xxs-12">
                        <div class="widget">
                            <div class="widget--title">
                                <h2 class="h3">ติดต่อเรา</h2>
                            </div>
                            <div class="contact--widget">
                                <ul class="nav">
                                    <li>สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</li>
                                    <li>321 ตำบลทะเลชุบศร อำเภอเมือง จังหวัดลพบุรี 15000</li>
                                </ul>
                                <ul class="nav">
                                    <li><a href="tel:+036413096"> เบอร์โทรศัพท์: 036 - 413096</a></li>
                                </ul>
                                <ul class="nav">
                                    <li><a href="mailto:thepsatriculture@lawasri.tru.ac.th">E-mail : thepsatriculture@lawasri.tru.ac.th</a></li>
                                    <li><a href="https://www.facebook.com/artcultureTRU99/"> Facebook : artcultureTRU99 </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6 col-xxs-12">
                        <div class="widget">
                            <div class="widget--title">
                                <h2 class="h3">หน่วยงานภายนอก</h2>
                            </div>
                            <div class="links--widget">
                                <ul class="nav">
                                    <li>
                                        <a href="https://www.m-culture.go.th/lopburi/main.php?filename=index" target="_blank">สำนักงานวัฒนธรรมจังหวัดลพบุรี</a>
                                    </li>
                                    <li>
                                        <a href="https://www.mhesi.go.th/" target="_blank">กระทรวงการอุดมศึกษา วิทยาศาสตร์ วิจัยและนวัตกรรม</a>
                                    </li>
                                    <li>
                                        <a href="https://www.facebook.com/CAC.RUT" target="_blank">สภาศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏแห่งประเทศไทย</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 col-xs-6 col-xxs-12">
                        <div class="widget">
                            <div class="widget--title">
                                <h2 class="h3">เว็บไซต์ที่เกี่ยวข้อง</h2>
                            </div>
                            <div class="links--widget">
                                <ul class="nav">
                                    <li>
                                        <a href="http://website2021.lopburi.go.th/" target="_blank">จังหวัดลพบุรี</a>
                                    </li>
                                    <li>
                                        <a href="https://reg.tru.ac.th/registrar/home.asp">มหาวิทยาลัยราชภัฏเทพสตรี</a>
                                    </li>
                                    <li>
                                        <a href="https://www.lopburi.org/culture-lopburi" target="_blank">สถานที่ท่องเที่ยวเชิงวัฒนธรรม จังหวัดลพบุรี</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="footer--copyright">
            <div class="container">
                <p>
                    Copyright 2023 &copy; <a href="#">สำนักศิลปะและวัฒนธรรม มหาวิทยาลัยราชภัฏเทพสตรี</a>. <i class="fa fa-unlock-alt" aria-hidden="true"></i>
                    <a target="_blank" href="{{ route('login') }}"> เข้าสู่ระบบ </a>
                </p>
            </div>
        </div>
    </div>

    <div id="backToTop" class="bg--color-theme" data-animate-scroll="a">
        <a href="#body"><i class="fa fa-angle-up"></i></a>
    </div>

    <!-- jQuery Library -->
    <script src="{{ asset('template-front/js/jquery-3.2.1.min.js') }}"></script>

    <!-- Bootstrap Framework -->
    <script src="{{ asset('template-front/js/bootstrap.min.js') }}"></script>

    <!-- StickyJS Plugin -->
    <script src="{{ asset('template-front/js/jquery.sticky.min.js') }}"></script>

    <!-- Owl Carousel Plugin -->
    <script src="{{ asset('template-front/js/owl.carousel.min.js') }}"></script>

    <!-- Magnific Popup Plugin -->
    <script src="{{ asset('template-front/js/jquery.magnific-popup.min.js') }}"></script>

    <!-- Waypoints Plugin -->
    <script src="{{ asset('template-front/js/jquery.waypoints.min.js') }}"></script>

    <!-- Counter-Up Plugin -->
    <script src="{{ asset('template-front/js/jquery.counterup.min.js') }}"></script>

    <!-- Validation Plugin -->
    <script src="{{ asset('template-front/js/jquery.validate.min.js') }}"></script>

    <!-- Isotope Plugin -->
    <script src="{{ asset('template-front/js/isotope.min.js') }}"></script>

    <!-- Parallax Plugin -->
    <script src="{{ asset('template-front/js/parallax.min.js') }}"></script>

    <!-- AniamteScroll Plugin -->
    <script src="{{ asset('template-front/js/animatescroll.min.js') }}"></script>

    <!-- Main Script -->
    <script src="{{ asset('template-front/js/main.js') }}"></script>

    <!-- Magnific Script -->
    <script src="{{ asset('jquery.magnific-popup.js') }}"></script>
    <script src="{{ asset('jquery.magnific-popup.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            $('.zoom-gallery').magnificPopup({
                delegate: 'a',
                type: 'image',
                closeOnContentClick: false,
                closeBtnInside: false,
                mainClass: 'mfp-with-zoom mfp-img-mobile',
                image: {
                    verticalFit: true,
                    titleSrc: function(item) {
                        return item.el.attr('title') + ' &middot; <a class="image-source-link" href="' + item.el.attr('data-source') + '" target="_blank">image source</a>';
                    }
                },
                gallery: {
                    enabled: true
                },
                zoom: {
                    enabled: true,
                    duration: 300, // don't foget to change the duration also in CSS
                    opener: function(element) {
                        return element.find('img');
                    }
                }

            });
        });

        $('.owl-other').owlCarousel({
            autoplay: true,
            autoplayTimeout: 7000,
            margin: 10,
            loop: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 4
                }
            }
        })
    </script>
    <!-- <script id="becookies.tech-scripts" src="https://cookies.tru.ac.th/script.js" data-id="682d0028a6c69ed23bfa108f" charset="utf-8"></script> -->
    @yield('script')
</body>

</html>