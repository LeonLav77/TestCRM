<!DOCTYPE html>
@php
    $form_action = route('users.store');
    $pageSlug = null;
    $roles = [
        'Admin',
        'Teacher',
        'Student',
    ];
    $name = "test";
    use Faker\Factory as Faker;
    $faker = Faker::create();
    $email = $faker->email();
    $password = "password";
    $role = "Admin";

    if(isset($user)){
        $form_action = route('users.update', $user->id);
        $pageSlug = $user->slug ?? null;
        $name = $user->name ?? null;
        $email = $user->email ?? null;
        $role = $user->role->name ?? null;
        $password_inputs = [];
    }
    $inputs = [
        [
		'label' => 'Name',
		'tag' => 'text',
		'attributes' => [
			'type' => 'text',
			'disabled' => false,
            'name' => 'name',
			'placeholder' => 'Enter your name',
			'maxlength' => 50,
            'value' => $name ?? null,
			'required' => true,
		],
	],
    [
		'label' => 'Email Address',
		'tag' => 'text',
		'attributes' => [
			'type' => 'text',
			'disabled' => false,
            'name' => 'email',
			'placeholder' => 'Enter your email',
			'maxlength' => 50,
            'value' => $email ?? null,
			'required' => true,
		],
	],
    [
		'label' => 'Role',
		'tag' => 'select',
		'attributes' => [
            'options' => $roles,
			'disabled' => false,
            'name' => 'role',
			'value' => $role ?? null,
			'required' => true,
		],
	],
    [
		'label' => 'Password',
		'tag' => isset($user) ? 'hidden' : 'text',
		'attributes' => [
			'type' => 'password',
			'disabled' => false,
            'name' => 'password',
            'hidden' => isset($user),
			'placeholder' => 'Enter your password',
			'maxlength' => 50,
            'value' => $password ?? null,
			'required' => true,
		],
	],
    [
		'label' => 'Password Confirmation',
		'tag' => isset($user) ? 'hidden' : 'text',
		'attributes' => [
			'type' => 'password',
			'disabled' => false,
            'name' => 'password_confirmation',
			'placeholder' => 'Please repeat your password',
			'maxlength' => 50,
            'value' => $password ?? null,
			'required' => true,
		],
	],
];
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<style>
    select {
        width: 20% !important;
    }
    div {
        margin-bottom: 13px;
    }
    .select-items {
        position: absolute;
        background-color: #525f7f !important;
        top: 100%;
        left: 0;
        right: 0;
        z-index: 99;
    }
</style>
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <meta name="csrf-token" content="{{ csrf_token() }}">
        <!-- Extra details for Live View on GitHub Pages -->
        <!-- Canonical SEO -->
        <link rel="canonical" href="https://www.creative-tim.com/product/black-dashboard-laravel" />
        <!--  Social tags      -->
        <meta name="keywords" content="creative tim, html dashboard, html css dashboard, web dashboard, bootstrap 4 dashboard, bootstrap 4, css3 dashboard, bootstrap 4 admin, Black dashboard Laravel bootstrap 4 dashboard, frontend, responsive bootstrap 4 dashboard, free dashboard, free admin dashboard, free bootstrap 4 admin dashboard">
        <meta name="description" content="Black Dashboard Laravel is a beautiful Bootstrap 4 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you.">
        <!-- Schema.org markup for Google+ -->
        <meta itemprop="name" content="Black Dashboard Laravel by Creative Tim">
        <meta itemprop="description" content="Black Dashboard Laravel is a beautiful Bootstrap 4 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you.">
        <meta itemprop="image" content="https://s3.amazonaws.com/creativetim_bucket/products/164/original/opt_blk_laravel_thumbnail.jpg?1561102244">
        <!-- Twitter Card data -->
        <meta name="twitter:card" content="product">
        <meta name="twitter:site" content="@creativetim">
        <meta name="twitter:title" content="Black Dashboard Laravel by Creative Tim">
        <meta name="twitter:description" content="Black Dashboard Laravel is a beautiful Bootstrap 4 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you.">
        <meta name="twitter:creator" content="@creativetim">
        <meta name="twitter:image" content="https://s3.amazonaws.com/creativetim_bucket/products/164/original/opt_blk_laravel_thumbnail.jpg?1561102244">
        <!-- Open Graph data -->
        <meta property="fb:app_id" content="655968634437471">
        <meta property="og:title" content="Black Dashboard Laravel by Creative Tim" />
        <meta property="og:type" content="article" />
        <meta property="og:url" content="https://black-dashboard-laravel.creative-tim.com/" />
        <meta property="og:image" content="https://s3.amazonaws.com/creativetim_bucket/products/164/original/opt_blk_laravel_thumbnail.jpg?1561102244" />
        <meta property="og:description" content="Black Dashboard Laravel is a beautiful Bootstrap 4 admin dashboard with a large number of components, designed to look beautiful and organized. If you are looking for a tool to manage and visualize data about your business, this dashboard is the thing for you." />
        <meta property="og:site_name" content="Creative Tim" />
        <title>{{ config('app.name', 'Black Dashboard Laravel - Free Laravel Preset') }}</title>
        <!-- Favicon -->
        <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('black') }}/img/apple-icon.png">
        <link rel="icon" type="image/png" href="{{ asset('black') }}/img/favicon.png">
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet" />
        <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet">
        <!-- Icons -->
        <link href="{{ asset('black') }}/css/nucleo-icons.css" rel="stylesheet" />
        <!-- CSS -->
        <link href="{{ asset('black') }}/css/black-dashboard.css?v=1.0.0" rel="stylesheet" />
        <link href="{{ asset('black') }}/css/theme.css" rel="stylesheet" />

    </head>
<body class="">

    <div class="wrapper">
        @include('layouts.navbars.sidebar')
            
        <div class="main-panel">
            @include('layouts.navbars.navbar')
            <div class="content">
                <form class="form form-notify" action="{{ $form_action }}" method="post" autocomplete="off" id="main-form"
                enctype="multipart/form-data">
                    @csrf
                    @if(isset($user))
                        @method('PUT')
                    @endif
                    @include('layouts.forms.input_renderer', ['fields' => $inputs])
                    @include('layouts.forms.submit_button')
                </form>
            </div>
                <script src="{{ asset('black') }}/js/core/jquery.min.js"></script>
                <script src="{{ asset('black') }}/js/core/popper.min.js"></script>
                <script src="{{ asset('black') }}/js/core/bootstrap.min.js"></script>
                <script src="{{ asset('black') }}/js/plugins/perfect-scrollbar.jquery.min.js"></script>
                <script src="{{ asset('black') }}/js/plugins/bootstrap-notify.js"></script>

                <script src="{{ asset('black') }}/js/black-dashboard.min.js?v=1.0.0"></script>
                <script src="{{ asset('black') }}/js/theme.js"></script>

    @stack('js')

    <script>
        $(document).ready(function() {
            $().ready(function() {
                $sidebar = $('.sidebar');
                $navbar = $('.navbar');
                $main_panel = $('.main-panel');

                $full_page = $('.full-page');

                $sidebar_responsive = $('body > .navbar-collapse');
                sidebar_mini_active = true;
                white_color = false;

                window_width = $(window).width();

                fixed_plugin_open = $('.sidebar .sidebar-wrapper .nav li.active a p').html();

                $('.fixed-plugin a').click(function(event) {
                    if ($(this).hasClass('switch-trigger')) {
                        if (event.stopPropagation) {
                            event.stopPropagation();
                        } else if (window.event) {
                            window.event.cancelBubble = true;
                        }
                    }
                });

                $('.fixed-plugin .background-color span').click(function() {
                    $(this).siblings().removeClass('active');
                    $(this).addClass('active');

                    var new_color = $(this).data('color');

                    if ($sidebar.length != 0) {
                        $sidebar.attr('data', new_color);
                    }

                    if ($main_panel.length != 0) {
                        $main_panel.attr('data', new_color);
                    }

                    if ($full_page.length != 0) {
                        $full_page.attr('filter-color', new_color);
                    }

                    if ($sidebar_responsive.length != 0) {
                        $sidebar_responsive.attr('data', new_color);
                    }
                });

                $('.switch-sidebar-mini input').on("switchChange.bootstrapSwitch", function() {
                    var $btn = $(this);

                    if (sidebar_mini_active == true) {
                        $('body').removeClass('sidebar-mini');
                        sidebar_mini_active = false;
                        blackDashboard.showSidebarMessage('Sidebar mini deactivated...');
                    } else {
                        $('body').addClass('sidebar-mini');
                        sidebar_mini_active = true;
                        blackDashboard.showSidebarMessage('Sidebar mini activated...');
                    }

                    // we simulate the window Resize so the charts will get updated in realtime.
                    var simulateWindowResize = setInterval(function() {
                        window.dispatchEvent(new Event('resize'));
                    }, 180);

                    // we stop the simulation of Window Resize after the animations are completed
                    setTimeout(function() {
                        clearInterval(simulateWindowResize);
                    }, 1000);
                });

                $('.switch-change-color input').on("switchChange.bootstrapSwitch", function() {
                        var $btn = $(this);

                        if (white_color == true) {
                            $('body').addClass('change-background');
                            setTimeout(function() {
                                $('body').removeClass('change-background');
                                $('body').removeClass('white-content');
                            }, 900);
                            white_color = false;
                        } else {
                            $('body').addClass('change-background');
                            setTimeout(function() {
                                $('body').removeClass('change-background');
                                $('body').addClass('white-content');
                            }, 900);

                            white_color = true;
                        }
                });

                $('.light-badge').click(function() {
                    $('body').addClass('white-content');
                });

                $('.dark-badge').click(function() {
                    $('body').removeClass('white-content');
                });
            });
        });
    </script>

</body>
</html>
