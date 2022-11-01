<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\Administradores;
use App\User;

class UserController extends Controller
{
    
    public function index(Request $request)
    {
        $name = $request->get('name');

        $users = User::orderBy('id', 'DESC')
        ->name($name)
        ->paginate(4);

        return view('paginas.asignaciones', compact('users'));
    }
    
}
