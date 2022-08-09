<!DOCTYPE html>
@php
    $pageSlug = null;
    $me = Auth::user();
@endphp
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.header')
        <style>
            .pointer {
                cursor: pointer;
            }
        </style>    
            </head>
<body class="">

@if (session('status'))
<div class="alert alert-success" role="alert">
    {{ session('status') }}
  </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger float">
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
        <div class="row">
    <div class="col-md-12">
        <div class="card ">
            <div class="card-header">
                <div class="row">
                    <div class="col-8">
                        <h4 class="card-title">Users</h4>
                    </div>
                    <div class="col-4 text-right">
                        <a href="{{ route('users.create') }}" class="btn btn-sm btn-primary">Add user</a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                
                <div class="">
                    <table class="table tablesorter " id="">
                        <thead class=" text-primary">
                            <tr><th scope="col">Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Role</th>
                            <th scope="col">Creation Date</th>
                            <th scope="col"></th>
                        </tr></thead>
                        <tbody>
                            @foreach ($users as $user)
                                @can('see-user', $user)
                                <tr>
                                    <td>{{$user->name}}</td>
                                    <td>{{$user->email}}</td>
                                    <td>{{$user->role->name ?? '-------'}}</td>
                                    <td>{{$user->created_at}}</td>
                                    @can('edit-delete-user', $user)  
                                        <td class="text-right">
                                            <div class="dropdown">
                                                <a class="btn btn-sm btn-icon-only text-light" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </a>
                                                {{-- Edit dropdown list --}}
                                                <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                                    <a class="dropdown-item" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="post">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit" class="dropdown-item pointer">Delete</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    @endcan

                                </tr>
                                @endcan
                            @endforeach
                        </form>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer py-4">
                <nav class="d-flex justify-content-end" aria-label="...">
                    
                </nav>
            </div>
        </div>
    </div>
</div>
                </div>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            <input type="hidden" name="_token" value="ub2DzAIrgUnghVvu3l3KAbbq0UztNO8yfkrDNm6n">            </form>
            <div class="fixed-plugin">
    </div>

</body>
</html>
