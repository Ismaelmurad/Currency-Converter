<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Enums\Role;
use App\Models\User;
use App\Services\Http\RedirectResponse;
use App\Services\Http\Request;
use App\Services\Http\Response;
use App\Services\Http\ResponseInterface;
use Exception;

class UserController extends Controller
{
    /**
     * Fetches all users from database and returns them to the users view.
     *
     * @return Response
     */
    public function index(): Response
    {
        $this->guard(Role::USER);

        $users = User::query()
            ->select(['*'])
            ->get();

        return $this->view(
            'Admin/Users/index',
            [
                'users' => $users,
            ]
        );
    }

    /**
     * Shows the detail page for a single user.
     *
     * @return Response
     * @throws Exception
     */
    public function details(): Response
    {
        $this->guard(Role::USER);
        $id = Request::input('id');
        $user = User::find((int)$id);

        return $this->view(
            'Admin/Users/details',
            [
                'user' => $user,
            ]
        );
    }

    /**
     * Shows the edit form for a user.
     *
     * @return Response
     * @throws Exception
     */
    public function edit(): Response
    {
        $this->guard(Role::USER);
        $userId = (int)Request::input('id');
        $user = User::find($userId);

        return $this->view(
            'Admin/Users/edit',
            [
                'id' => (int)Request::input('id'),
                'user' => $user,
            ]
        );
    }

    /**
     * Removes a user and redirects to the list of users.
     *
     * @return ResponseInterface
     * @throws Exception
     */
    public function delete(): ResponseInterface
    {
        $user = User::find((int)Request::input('id'));
        $user->delete();
        return $this->redirect('/users');
    }

    /**
     * Updates user details and redirects to the list of users.
     *
     * @throws Exception
     */
    public function update(): RedirectResponse
    {
        $this->guard(Role::USER);
        $isActive = false;

        if (
            !empty(
                Request::input('is_active')
                && 'on' === Request::input('is_active')
            )
        ) {
            $isActive = true;
        }

        $user = User::find((int)Request::input('id'));
        $user?->update(
            [
                ...Request::input(),
                'is_active' => $isActive,
            ]
        );

        return $this->redirect('/users');
    }

    /**
     * Stores the new signed-up users
     * @return RedirectResponse
     * @throws
     */
    public function store(): ResponseInterface
    {
        $password = password_hash(Request::input('password'), PASSWORD_DEFAULT);

        $errors = [];

        $errors += $this->validateEmail();

        if (0 !== count($errors)) {
            return $this->view(
                'Registration/form',
                [
                    'errors' => $errors,
                ]
            );
        }

        (new User())
            ->setFirstName(Request::input('first_name'))
            ->setLastName(Request::input('last_name'))
            ->setEmail(Request::input('email'))
            ->setPassword($password)
            ->save();
        return $this->redirect('/');
    }

    /**
     * Validates the E-Mail when a new user is trying to sign up.
     *
     * @return array
     */
    private function validateEmail(): array
    {
        $email = Request::input('email');
        $results = User::query()
            ->where('email', '=', $email)
            ->count();

        if ($results === 0) {
            return [];
        } else {
            return ['email' => 'Diese E-Mail Addresse existiert bereits'];
        }
    }
}