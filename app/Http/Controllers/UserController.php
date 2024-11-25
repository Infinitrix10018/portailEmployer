<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all()
        ->where('role', '!=', 'Fournisseur');

        return view('views.pageChangementRole', compact('users'));
    }

    public function updateRoles(Request $request)
{
    $roles = $request->input('roles');

    foreach ($roles as $userId => $role) {
        $user = User::find($userId);
        if ($user) {
            $user->role = $role;
            $user->save();
        }
    }

    return redirect()->back()->with('success', 'Roles mis à jour avec succès.');
}
}
