<?php

namespace Modules\Acl\Http\Controllers\Api\V1;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Acl\Entities\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use App\Http\Resources\UserCurrentResource;
use Modules\Acl\Http\Requests\LoginRequest;
use Modules\Acl\Http\Resources\UserResource;
use Modules\Acl\Repositories\RoleRepository;
use Modules\Acl\Repositories\UserRepository;
use Modules\Acl\Http\Requests\ProfilShowRequest;
use Modules\Acl\Http\Requests\ProfilUpdateRequest;
use Modules\Acl\Http\Requests\ResetPasswordRequest;
use Modules\Acl\Http\Requests\ForgotPasswordRequest;
use Modules\Acl\Http\Requests\UserTelMobileStoreRequest;
use Modules\Acl\Http\Requests\UserEmailConfirmationRequest;
use Modules\Acl\Http\Requests\UserTelMobileVerifierRequest;

class AuthController extends \App\Http\Controllers\Api\V1\ApiController {
    use \Modules\Acl\Traits\EnvoiNotificationUserTrait;
    /**
     * @var PostRepository
     */
    protected $userRepository;
    protected $roleRepositoryEloquent;
    
    public function __construct(UserRepository $userRepository, 
            RoleRepository $roleRepositoryEloquent) {
        parent::__construct();
        $this->userRepository = $userRepository;
        $this->roleRepositoryEloquent = $roleRepositoryEloquent;
    }

    /**
     * Connexion de l'utilisateur
     *
     * @param  Request  $request
     * @return Response
     */
    public function login(LoginRequest $request) {
        //Specifying Additional Conditions
        //Auth::attempt(['email' => $email, 'password' => $password, 'active' => 1])

        $email = $request->email;
        $password = $request->password;
        $user = User::where('email', $email)->first();
        if ($user) {
            if (Hash::check($password, $user->password)) {
                //https://laravel.com/docs/9.x/passport#personal-access-tokens
                //Prendre le user depuis le tenant
                // $user = $this->userRepository->findByUuidOrFail($user->uuid)->first();
                //créer le token
                $token = $user->createToken($user->uuid)->accessToken;
                $donnees = [
                    'access_token' => $token,
                ];
                return reponse_json_transform($donnees);
            }
        }

        $data = [
            'erreur' => __('Email ou mot de passe non valide!')
        ];
        return reponse_json_transform($data, 400);
    }
    
    /**
     * Déconnexion de l'utilisateur
     *
     * @param  Request  $request
     * @return Response
     */
    public function logout(Request $request) {
        $userId = $request->user()->id;
        $request->user()->token()->revoke();
        
        //Dispatcher l'évènement de login
        event(new \Modules\Acl\Events\AuthLogoutEvent($userId, $request->ipInfo));
        
        $data = [
            'message' => __('Déconnexion avec succès')
        ];
        return reponse_json_transform($data);
    }

    /**
     * Obtient l'utilisateur connecté
     *
     * @return Response
     */
    public function user() {
        return new UserCurrentResource(user_api());
    }
        
   /**
     * Obtenir les informations sur le profil.
     *
     * @return Response
     */
    public function showProfil(ProfilShowRequest $request)
    {
        $item = $this->userRepository->findByUuidOrFail($request->uuid)->first(); 
        return new UserResource($item);
    }
    
   /**
     * Update a resource.
     *
     * @return Response
     */
    public function updateProfil(ProfilUpdateRequest $request)
    {
        $user = user_api();  //existe-il cet element?
        $attributs = $request->except(['uuid']);
        $item = DB::transaction(function () use ($attributs, $user) {
            $item = $this->userRepository->modifier($attributs, $user);
            return $item;
        });
        $item = $item->fresh();
        return new UserResource($item);
    }
    
    /**
     * Handle an incoming password reset link request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function forgotPassword(ForgotPasswordRequest $request) {
        // We will send the password reset link to this user. Once we have attempted
        // to send the link, we will examine the response then see the message we
        // need to show to the user. Finally, we'll send out a proper response.
        $status = Password::sendResetLink(
                        $request->only('email')
        );

        if ($status == Password::RESET_LINK_SENT) {
            $data['message'] = __($status);
            return reponse_json_transform($data);
        }

        $data = [
            'email' => [trans($status)]
        ];
        failed_validation_throw_exception($data);
    }

    /**
     * Handle an incoming new password request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        if ($status == Password::PASSWORD_RESET) {
            $data['message'] = __($status);
            return reponse_json_transform($data);
        }
        
        //Token est expiré. On va personnalisé le message
        if ($status == Password::INVALID_TOKEN) {
            $status .= " ".__("Veuillez redemander un nouveau lien de réinitialisation");
        }

        $data = [
            'email' => [trans($status)]
        ];
        failed_validation_throw_exception($data);
    }
        
    /**
     * Validation du courriel de l'utilisateur
     *
     * @return Response
     */
    public function emailConfirmation(UserEmailConfirmationRequest $request) {
        $uuid = $request->uuid;
        if (!$request->hasValidSignature()) {
            $message = __("Lien expiré ou signature non valide");
            $message .= ". ".__("Un nouveau courriel est envoyé à votre boîte de messagerie");
            $user = $this->userRepository->findByField('uuid', $uuid)->first();
            $this->confirmationCourriel($user);
            return reponse_json_transform([
                "message" => $message
                    ], 401);
        }
        $user = $this->userRepository->findByField('uuid', $uuid)->first();
        
        //Confirmer cet email
        if($user->email_verified_at){
            $message = __("Email déjà confirmé");
        }else{
            $message = __("Email confirmé avec succès");
            $user->email_verified_at = now();
            $user->save();
        }
        $data['message'] = $message;
        
        return reponse_json_transform($data);
    }
        
    /**
     * Validation du courriel de l'utilisateur
     *
     * @return Response
     */
    public function renvoiLienEmailConfirmation(Request $request) {
        $user = user_api();
        $data['message'] = _('KO');
        if (!$user->email_verified_at) {
            $this->confirmationCourriel($user);
            $data['message'] = __('Lien renvoyé avec succès. Vérifiez votre boîte courriel.');
        }
        
        return reponse_json_transform($data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function userInfosConfirmees(Request $request) {
        $user = user_api();
        $data = [
            'email_verified_at' => $user->email_verified_at,
            'tel_mobile_verified_at' => $user->tel_mobile_verified_at,
            'tel_mobile' => $user->tel_mobile,
        ];
        return reponse_json_transform($data);
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function envoyerTelMobile(UserTelMobileStoreRequest $request) {
        $user = user_api();
        $tel_mobile_code = random_int(100000, 999999);
        $user->tel_mobile = $request->tel_mobile;
        $user->tel_mobile_code = $tel_mobile_code;
        $user->save();

        //@TODO : Envoyer le SMS plus tard
        $data["tel_mobile_code"] = $tel_mobile_code;
        $view_url = "acl::emails.code_sms";
        $sujet = __("Votre code");
        $attributes = [
            'view_url' => $view_url,
            'data' => $data,
            'destinataires' => [$user->email],
            'sujet' => $sujet,
        ];
        mail_queue(new \Modules\Notifier\Emails\CourrielNotifier($attributes));
        //
        
        $data['message'] = __('SMS envoyé avec succès. Vérifiez votre messagerie.');
        return reponse_json_transform($data);
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function verifierTelMobile(UserTelMobileVerifierRequest $request) {
        $user = user_api();
        if($user->tel_mobile_code){
            $user->tel_mobile_code = null;
            $user->tel_mobile_verified_at = now()->toDateTimeString();
            $user->save();
        }
        
        $data['message'] = __('Numéro de tél validé avec succès!');
        return reponse_json_transform($data);
    }    
}
