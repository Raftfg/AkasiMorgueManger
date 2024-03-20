<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler {

    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        \Illuminate\Auth\AuthenticationException::class,
        \Illuminate\Auth\Access\AuthorizationException::class,
        \Symfony\Component\HttpKernel\Exception\HttpException::class,
        \Illuminate\Database\Eloquent\ModelNotFoundException::class,
        \Illuminate\Validation\ValidationException::class,
        \Illuminate\Session\TokenMismatchException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register() {
        $this->reportable(function (Throwable $e) {

            $request = request();
            if ($e instanceof ModelNotFoundException) {
                return parent::render($request, $e);
            }
            if ($e instanceof \Illuminate\Validation\ValidationException) {
                return parent::render($request, $e);
            }
            if ($e instanceof \Illuminate\Auth\AuthenticationException) {
                return parent::render($request, $e);
            }
            if ($e instanceof \Illuminate\Session\TokenMismatchException) {
                return parent::render($request, $e);
            }
            if ($e instanceof \Illuminate\Routing\Exceptions\UrlGenerationException) {
                return parent::render($request, $e);
            }
            if ($e instanceof \Illuminate\Validation\UnauthorizedException) {
                return parent::render($request, $e);
            }
            if ($e instanceof \Laravel\Passport\Exceptions\OAuthServerException) {
                //vendor\league\oauth2-server\src\Exception\OAuthServerException.php/invalidCredentials
                if ($e->getCode() == 6 && \Str::contains($e->getMessage(), 'The user credentials were incorrect')) {
                    //$this->ignore(\Laravel\Passport\Exceptions\OAuthServerException::class);
                    //Pour une raison ou pour une autre, tout return json fait dance bloc ne semble pas fonctionner.
                }
            }

            if ($this->isHttpException($e)) {
                return parent::render($request, $e);
            } else {
                // Custom error 500 view on production
                if (app()->environment() == 'production') {
                    \Log::error($e->getTraceAsString());
                    //Si l'erreur contient ce message, n'envoyer pas de courriel
                    if (strpos($e->getMessage(), 'Route [] not defined') !== false) {
                        return parent::render($request, $e);
                    } else {
                        $attributes = [
                            'view_url' => 'emails.exception',
                            'data' => [
                                "contenu" => $e->getMessage(),
                                "fullUrl" => $request->fullUrl(),
                                "ip" => $request->ip()
                            ],
                            'destinataires' => [env('MAIL_ERREUR', 'ekpotin@gmail.com')],
                            'sujet' => __('Erreur ' . config('app.name'))
                        ];
                        //Notification système mail_queue(new \Modules\Notifier\Emails\CourrielNotifier($attributes));
                    }

                    return parent::render($request, $e);
                }
                return parent::render($request, $e);
            }
        });
    }

    /**
     * Redéfinition de cette fonction à cause de l'API, pour personnalisr le message
     * @param type $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return mixed
     */
    // public function unauthenticated($request, \Illuminate\Auth\AuthenticationException $exception) {
    //     return reponse_json_transform([
    //         'code' => 'TOKEN_EXPIRE',
    //         'message' => __('Veuillez-vous connecter'),
    //             ], 401);
    // }

    /**
     * 
     * @param type $request
     * @param \Illuminate\Auth\Access\AuthorizationException $exception
     * @return mixed
     */
    public function unauthorized($request, \Illuminate\Auth\Access\AuthorizationException $exception) {
        return reponse_json_transform([
            'message' => __('Opération non permise')
                ], 401);
    }

}
