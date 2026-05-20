<?php

namespace App\Http\Controllers\Admin;

use App\Domain\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('almacen')->orderBy('role')->orderBy('name')->get();
        return view('admin.users.index', compact('users'));
    }
}
