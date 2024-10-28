<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GestionConnection extends Controller
{
    public function login(LoginUserRequest $request)
    {

        Log::info('Login attempt', $request->all());
        $credentials = $request->only('email' , 'password');
        
        
        
        $user = null;
        if (!empty($credentials['email'])) {
            $user = User::where('email', $credentials['email'])->first();
        } elseif (!empty($credentials['NEQ'])) {
            $user = User::where('NEQ', $credentials['NEQ'])->first();
        }

        if ($user && Hash::check($credentials['password'], $user->password)) {
            
            Auth::login($user);

            return redirect()->route('VoirFiche');
        }

        return redirect()->route('ConnexionEmployer')->with('erreur', 'Email ou mot de passe incorrect.');
        
    }


    public function Logout(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();
        return redirect()->route('ConnexionEmployer')->with('success', "Déconnexion réussie");
    }
}
