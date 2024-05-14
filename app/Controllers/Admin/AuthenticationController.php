<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Enums\Role;
use App\Models\User;
use App\Services\Container\App;
use App\Services\Http\RedirectResponse;
use App\Services\Http\Request;
use App\Services\Http\Response;
use App\Services\Http\ResponseInterface;
use App\Services\Session\Session;
use DateTime;
use DateTimeZone;
use Exception;

class AuthenticationController extends Controller
{
    /**
     * Shows the login form
     *
     * @return Response
     */
    public function login(): Response
    {
        return $this->view(
            'login',
            [
                'old' => Request::input(),
            ]
        );
    }

    /**
     * Validates the user credentials and redirects to the main page, if the login is successful.
     *
     * @throws Exception
     */
    public function verifyCredentials(): ResponseInterface
    {
        $user = User::findBy(
            'email',
            Request::input('email')
        );

        if (
            null === $user
            || false === password_verify(Request::input('password'), $user->getPassword())
        ) {
            return $this->view(
                'login',
                [
                    'old' => Request::input(),
                    'error' => 'Die E-Mail-Adresse oder das Passwort ist falsch.',
                ]
            );
        }

        /** @var Session $session */
        $session = App::get('session');
        $session->set('user_id', $user->getId());

        if (null === $user->getFirstVisitedAt()) {
            $now = new DateTime('now', new DateTimeZone('UTC'));

            $user
                ->setFirstVisitedAt($now->format('Y-m-d H:i:s'))
                ->save();
        }

        return $this->redirect('/');
    }

    /**
     * Shows the form to register as a new user.
     *
     * @return Response
     */
    public function registrationForm(): Response
    {
        if (!App::environment('local')) {
            $this->guard(Role::ADMIN);
        }

        return $this->view('Registration/form');
    }

    /**
     * Validates the user input and redirects to the main page, if the new user was created successfully.
     *
     * @throws Exception
     */
    public function registrationStore(): RedirectResponse
    {
        if (!App::environment('local')) {
            $this->guard(Role::ADMIN);
        }

        (new User())
            ->setFirstName(Request::input('first_name'))
            ->setLastName(Request::input('last_name'))
            ->setPassword(Request::input('password'))
            ->setEmail(Request::input('email'))
            ->setRole(Role::USER)
            ->save();

        return $this->redirect('/');
    }

    /**
     * Destroys the session and redirects the user to the login form.
     *
     * @return RedirectResponse
     */
    public function logout(): RedirectResponse
    {
        App::get('session')->destroy();

        return $this->redirect('/');
    }
}