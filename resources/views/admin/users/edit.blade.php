@extends('adminlte::page')

@section('title', 'Editar Usuario')

@section('content_header')
    <h1><i class="fas fa-user-edit"></i> Editar Usuario: {{ $user->name }}</h1>
@stop

@section('content')
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <form action="{{ route('admin.users.update', $user) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" name="name" id="name"
                            class="form-control @error('name') is-invalid @enderror"
                            value="{{ old('name', $user->name) }}" required>
                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email"
                            class="form-control @error('email') is-invalid @enderror"
                            value="{{ old('email', $user->email) }}" required>
                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="password">Contraseña <small class="text-muted">(dejar vacío para mantener la actual)</small></label>
                        <input type="password" name="password" id="password"
                            class="form-control @error('password') is-invalid @enderror">
                        @error('password') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group">
                        <label for="role">Rol</label>
                        <select name="role" id="role"
                            class="form-control @error('role') is-invalid @enderror" required>
                            <option value="capturista" {{ old('role', $user->role) === 'capturista' ? 'selected' : '' }}>Capturista</option>
                            <option value="supervisor" {{ old('role', $user->role) === 'supervisor' ? 'selected' : '' }}>Supervisor</option>
                            <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Administrador</option>
                        </select>
                        @error('role') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>

                    <div class="form-group" id="div-almacen">
                        <label for="almacen_id">Almacén</label>
                        <select name="almacen_id" id="almacen_id"
                            class="form-control @error('almacen_id') is-invalid @enderror">
                            <option value="">Seleccionar...</option>
                            @foreach($almacenes as $almacen)
                                <option value="{{ $almacen->id }}" {{ old('almacen_id', $user->almacen_id) == $almacen->id ? 'selected' : '' }}>
                                    {{ $almacen->nombre }}
                                </option>
                            @endforeach
                        </select>
                        @error('almacen_id') <span class="invalid-feedback">{{ $message }}</span> @enderror
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Actualizar
                    </button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>
</div>
@stop

@section('js')
<script>
$(function() {
    function toggleAlmacen() {
        if ($('#role').val() === 'capturista') {
            $('#div-almacen').show();
            $('#almacen_id').prop('required', true);
        } else {
            $('#div-almacen').hide();
            $('#almacen_id').prop('required', false).val('');
        }
    }
    toggleAlmacen();
    $('#role').change(toggleAlmacen);
});
</script>
@stop
