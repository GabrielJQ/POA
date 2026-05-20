<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Entities\Almacen;
use App\Domain\Entities\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('almacen')->orderBy('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $almacenes = Almacen::orderBy('nombre')->get();
        return view('admin.users.create', compact('almacenes'));
    }

    public function store(StoreUserRequest $request)
    {
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'almacen_id' => $request->role === 'capturista' ? $request->almacen_id : null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario creado exitosamente.');
    }

    public function edit(User $user)
    {
        $almacenes = Almacen::orderBy('nombre')->get();
        return view('admin.users.edit', compact('user', 'almacenes'));
    }

    public function update(UpdateUserRequest $request, User $user)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'almacen_id' => $request->role === 'capturista' ? $request->almacen_id : null,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario actualizado exitosamente.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return redirect()->route('admin.users.index')
                ->with('error', 'No puedes eliminar tu propio usuario.');
        }

        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'Usuario eliminado exitosamente.');
    }
}
