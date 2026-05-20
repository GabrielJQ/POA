@extends('adminlte::page')

@section('title', 'Administrar Usuarios')

@section('content_header')
    <h1>Administrar Usuarios</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body table-responsive p-0">
        <table class="table table-hover text-nowrap">
            <thead>
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Almacén</th>
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
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@stop
