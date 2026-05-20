@extends('adminlte::page')

@section('title', 'Administrar Usuarios')

@section('content_header')
    <h1>
        <i class="fas fa-users-cog"></i> Administrar Usuarios
        <a href="{{ route('admin.users.create') }}" class="btn btn-success btn-sm float-right">
            <i class="fas fa-plus"></i> Nuevo Usuario
        </a>
    </h1>
@stop

@section('content')
@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
@endif

<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Almacén</th>
                    <th style="width: 120px">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @switch($user->role)
                            @case('admin')
                                <span class="badge badge-danger">Administrador</span>
                                @break
                            @case('supervisor')
                                <span class="badge badge-warning">Supervisor</span>
                                @break
                            @case('capturista')
                                <span class="badge badge-primary">Capturista</span>
                                @break
                        @endswitch
                    </td>
                    <td>{{ $user->almacen?->nombre ?? '—' }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-info" title="Editar">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" style="display:inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" title="Eliminar"
                                onclick="return confirm('¿Eliminar usuario {{ $user->name }}?')">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
