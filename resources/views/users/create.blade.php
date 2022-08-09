<!DOCTYPE html>
@php
    $form_action = route('users.store');
    $pageSlug = null;
    $roles = [
        'Admin',
        'Teacher',
        'Student',
    ];
    // $name = "test";
    // use Faker\Factory as Faker;
    // $faker = Faker::create();
    // $email = $faker->email();
    // $password = "password";
    // $role = "Admin";
    $password_inputs = 
    [    
        [
            'label' => 'Password',
            'tag' => isset($user) ? 'hidden' : 'text',
            'attributes' => [
                'type' => 'password',
                'disabled' => false,
                'name' => 'password',
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
        ]
    ];
    if(isset($user)){
        $form_action = route('users.update', $user->id);
        $pageSlug = $user->slug ?? null;
        $name = $user->name ?? null;
        $email = $user->email ?? null;
        $role = $user->role->name ?? null;
        $password_inputs = [];
    }
    if (old('name')) {
        $name = old('name');
    }
    if (old('email')) {
        $email = old('email');
    }
    if (old('role')) {
        $role = old('role');
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

];
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<style>
    div {
        margin-bottom: 13px;
    }
    .alert-fixed {
    position:fixed; 
    top: 0px; 
    right: 0px; 
    width: 60%;
    margin: 10px;
    padding: 10px;
    z-index:9999; 
    border-radius:60px
}
</style>
    <head>
        @include('partials.header')
    </head>
<body class="">
    @if ($errors->any())
        <div class="alert-fixed alert-danger" role="alert">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
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
                    @include('layouts.forms.input_renderer', ['fields' => $password_inputs])
                    @include('layouts.forms.submit_button')
                </form>
            </div>

</body>
</html>
