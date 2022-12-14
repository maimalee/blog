@php
    use Illuminate\Support\Facades\Auth;$showTopBar ??= true;
    $showSideBar ??= true;
    $showFooter ??= true;
@endphp

    <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>DASHMIN - Bootstrap Admin Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="/img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet"/>

    <!-- Customized Bootstrap Stylesheet -->
    <link href="/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js"
            integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"
            integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ"
            crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <!-- Template Stylesheet -->
    <link href="/css/style.css" rel="stylesheet">
    <link href="/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css">

    {{--select2 cdn --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"
            integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css"
          integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
    {{--    @vite(['resources/sass/app.scss', 'resources/js/app.js'])--}}

</head>

<body>
<div class="container-xxl position-relative bg-white d-flex p-0">
    <!-- Spinner Start -->
    <div id="spinner"
         class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <!-- Spinner End -->

    @if($showSideBar)
        <!-- Sidebar Start -->
        @if(Auth()->check() && Auth()->user()->role =='user')
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    <a href="index.html" class="navbar
                    1-brand mx-4 mb-3">
                        <h3 class="text-primary"><i class="fa fa-hashtag me-2"></i>DASHMIN</h3>
                    </a>
                    <div class="d-flex align-items-center ms-4 mb-4">
                        @if(Auth::check() && Auth()->user()->profile)
                            <div class="position-relative">
                                <img class="rounded-circle" src="/images/{{Auth()->user()['profile']}}" alt=""
                                     style="width: 40px; height: 40px;">
                                <div
                                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                            </div>

                        @else
                            <div class="position-relative">
                                <img class="rounded-circle" src="/images/th.webp" alt=""
                                     style="width: 40px; height: 40px;">
                                <div
                                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                            </div>

                        @endif
                        <div class="ms-3">
                            <h6 class="mb-0">{{Auth()->user()['name']}}</h6>
                            <sm>blog owner</sm>
                        </div>
                    </div>
                    <div class="navbar-nav w-100">
                        <a href="{{Route('home')}}" class="nav-item nav-link active">
                            <span>
                                <i class="fa fa-tachometer-alt me-2"></i>
                            Dashboard
                            </span>
                        </a>

                        <a href="{{Route('blogs.index')}}" class="nav-item nav-link">
                            <span>
                                <i class="fas fa-blog me-2"></i>
                            Blogs @if($global['singleUserBlogs'] ?? 0 > 0)
                                    <span class="mt-1 badge bg-primary">{{$global['singleUserBlogs']}}</span>
                                @endif
                            </span>
                            <div class="mt-2">

                            </div>
                        </a>

                        <a href="{{Route('notifications.index')}}"
                           class="nav-item nav-link d-flex justify-content-between">
                        <span>
                            <i class="fa fa-bell me-2"></i>
                            Notifications

                                @if(($global['notifications'] ?? 0) > 0)
                                <span class="mt-1 badge bg-primary">{{$global['notifications']}}</span>
                            @endif
                        </span>

                        </a>

                        <a href="{{Route('allBlogs')}}" class="nav-item nav-link">
                           <span>
                                <i class="fas fa-blog me-2"></i>
                            Friends Blogs
                               @if($global['friendsBlogs'] ?? 0 > 0)
                                   <span class="mt-1 badge bg-primary">{{$global['friendsBlogs']}}</span>
                               @endif
                           </span>
                        </a>

                        <a href="{{Route('friends.index')}}" class="nav-item nav-link">
                            <span>
                                <i class="fa fa-users me-2"></i>
                            Friends
                                @if($global['TotalFriends'] ?? 0 > 0)
                                    <span class="mt-1 badge bg-primary">{{$global['TotalFriends']}}</span>
                                @endif
                            </span>
                        </a>

                        <a href="#" class="nav-item nav-link">
                            <span>
                                <i class="fa fa-envelope me-2"></i>
                            Message

                            </span>
                        </a>

                        <a href="{{Route('friend.profile', Auth::user()['id'])}}" class="nav-item nav-link">
                            <span>
                                <i class="fa fa-user me-2"></i>
                            Profile

                            </span>
                        </a>


                        <form action="{{Route('logout')}}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 m-lg-2"></i>
                                Logout
                            </button>
                        </form>


                    </div>
                </nav>
            </div>
        @else
            <div class="sidebar pe-4 pb-3">
                <nav class="navbar bg-light navbar-light">
                    <a href="index.html" class="navbar-brand mx-4 mb-3">
                        <h3 class="text-primary">Admin DashBoard</h3>
                    </a>
                    <div class="d-flex align-items-center ms-4 mb-4">
                        @if(Auth::check() && Auth()->user()->profile)
                            <div class="position-relative">
                                <img class="rounded-circle" src="/images/{{Auth()->user()['profile']}}" alt=""
                                     style="width: 40px; height: 40px;">
                                <div
                                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                            </div>

                        @else
                            <div class="position-relative">
                                <img class="rounded-circle" src="/images/th.webp" alt=""
                                     style="width: 40px; height: 40px;">
                                <div
                                    class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                            </div>

                        @endif
                        @if(Auth()->check())
                            <div class="ms-3">
                                <h6 class="mb-0">{{Auth()->user()['name']}}</h6>
                            </div>
                        @endif
                    </div>
                    <div class="navbar-nav w-100">
                        <a href="{{Route('home')}}" class="nav-item nav-link active"><i
                                class="fa fa-tachometer-alt me-2"></i>Dashboard</a>
                        <a href="{{Route('admin.blog')}}" class="nav-item nav-link"><i
                                class="fa fa-th me-2"></i>
                            Blogs
                            @if($global['blogs'] ?? 0>0)
                                <span class="badge bg-primary">
                                    {{$global['blogs']}}
                                </span>
                            @endif
                        </a>
                        <a href="{{Route('comment.all')}}" class="nav-item nav-link">
                            <i class="fa fa-th me-2"></i>
                            Comments
                            @if($global['comments'] ?? 0 > 0)
                                <span class="badge bg-primary">
                                    {{$global['comments']}}
                                </span>
                            @endif
                        </a>
                        <a href="{{Route('users.all')}}" class="nav-item nav-link">
                            <i class="fa fa-users"></i>
                            Users
                            @if($global['users'] ?? 0 > 0)
                                <span class="mt-1 badge bg-primary">{{$global['users']}}</span>
                            @endif
                        </a>

                        <form action="{{Route('logout')}}" method="post">
                            @csrf
                            <button type="submit" class="dropdown-item">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400 m-lg-2"></i>
                                Logout
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

        @endif
    @endif
    <!-- Sidebar End -->


    <!-- Content Start -->
    @if($showTopBar)
        @if(Auth()->check())
            <div class="content">
                <!-- Navbar Start -->
                <nav class="navbar navbar-expand bg-light navbar-light sticky-top px-4 py-0">
                    <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                        <h2 class="text-primary mb-0"><i class="fa fa-hashtag"></i></h2>
                    </a>
                    <a href="#" class="sidebar-toggler flex-shrink-0">
                        <i class="fa fa-bars"></i>
                    </a>
                    <form class="d-none d-md-flex ms-4">
                        <input class="form-control border-0" type="search" placeholder="Search">
                    </form>
                    <div class="navbar-nav align-items-center ms-auto">
                        <div class="nav-item dropdown">
                            @if(Auth::check() && Auth()->user()->profile)
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown"></a>
                                <img class="rounded-circle me-lg-2" src="/images/{{Auth()->user()['profile']}}"
                                     alt=""
                                     style="width: 40px; height: 40px;">
                            @else
                                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                                    <img class="rounded-circle me-lg-2" src="/images/th.webp"
                                         alt=""
                                         style="width: 40px; height: 40px;">
                                    @endif
                                    <span class="d-none d-lg-inline-flex">{{Auth()->user()->name}}</span>
                                </a>

                        </div>
                    </div>
                </nav>
                <!-- Navbar End -->
                @endif
                @endif
                <!-- content -->

                @if(Session::has('message'))
                    <div class="container mt-2">
                        <p class="alert alert-info col-md-7">
                            {{Session::get('message')}}
                        </p>
                    </div>
                @endif
                @yield('content')
                <!-- End content -->

                @if($showFooter)
                    <!-- Footer Start -->
                    {{--                    <div class="container-fluid pt-4 px-4">--}}
                    {{--                        <div class="bg-light rounded-top p-4">--}}
                    {{--                            <div class="row">--}}
                    {{--                                <div class="col-12 col-sm-6 text-center text-sm-start">--}}
                    {{--                                    &copy; <a href="#">Your Site Name</a>, All Right Reserved.--}}
                    {{--                                </div>--}}
                    {{--                                <div class="col-12 col-sm-6 text-center text-sm-end">--}}
                    {{--                                    <!--/*** This template is free as long as you keep the footer author???s credit link/attribution link/backlink. If you'd like to use the template without the footer author???s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->--}}
                    {{--                                    Designed By <a href="https://htmlcodex.com">HTML Codex</a>--}}
                    {{--                                    Distributed By <a class="border-bottom" href="https://themewagon.com"--}}
                    {{--                                                      target="_blank">ThemeWagon</a>--}}
                    {{--                                </div>--}}
                    {{--                            </div>--}}
                    {{--                        </div>--}}
                    {{--                    </div>--}}
                    <!-- Footer End -->
                @endif
            </div>
            <!-- Content End -->


            <!-- Back to Top -->
            <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
</div>

<!-- JavaScript Libraries -->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="/lib/chart/chart.min.js"></script>
<script src="/lib/easing/easing.min.js"></script>
<script src="/lib/waypoints/waypoints.min.js"></script>
<script src="/lib/owlcarousel/owl.carousel.min.js"></script>
<script src="/lib/tempusdominus/js/moment.min.js"></script>
<script src="/lib/tempusdominus/js/moment-timezone.min.js"></script>
<script src="/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

<!-- Template Javascript -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script src="/vendor/jquery-easing/jquery.easing.min.js"></script>
<script src="/js/main.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="/vendor/datatables/jquery.dataTables.min.js"></script>
<script src="/vendor/datatables/dataTables.bootstrap4.min.js"></script>
<script src="//cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
        integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

@auth
    <script>
        $.ajaxSetup({
            headers: {
                'Authorization': `Bearer {{\auth()->user()['api_token']}}`
            }
        });
        $.get('/api/test')
    </script>
@endauth

@yield('script')

</body>

</html>
