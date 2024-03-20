<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct()
    {
    }

    public function login(Request $request)
    {
        $request->request->add([
            'grant_type' => 'password',
            'client_id' => config('passport.personal_access_client.id'),
            'client_secret' => config('passport.personal_access_client.secret'),
            'username' => $request->email,
            'password' => $request->password,
        ]);
        $tokenRequest = $request->create('/oauth/token', 'POST', $request->all());

        $token =  \Route::dispatch($tokenRequest);
        $content = $token->getContent();
        $data = json_decode($content, true); // Convertir la réponse JSON en tableau PHP

        if (isset($data['access_token'])) {
            $accessToken = $data['access_token']; // Récupérer l'access_token
            Session::put('access_token', $accessToken);
            Cookie::queue("access_token", json_encode(Session::get("access_token")), 240);
            
            return redirect('/index'); // Redirigez vers un tableau de bord ou une autre page
        } 

        return redirect()->back()->with(['error'=> 'Les informations sont invalides']);
    }

    public function logout()
    {
        Cookie::queue(Cookie::forget('access_token'));
        // Récupérer l'utilisateur authentifié
        $user = \Auth::user();

        // Révoquer le token d'accès associé à l'utilisateur
        $user->token()->revoke();

        // Vous pouvez également invalider tous les autres tokens pour cet utilisateur si nécessaire
        $user->tokens()->delete();

        // Rediriger l'utilisateur après la déconnexion
        return redirect('/login');
    }
}
