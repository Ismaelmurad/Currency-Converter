<?php

namespace App\Controllers;

use App\Enums\Role;
use App\Models\User;
use App\Services\Container\App;
use App\Services\Http\RedirectResponse;
use App\Services\Http\Response;

class Controller
{
    /**
     * Loads a partial and passes optional payload.
     *
     * @param string $path
     * @param array $data
     * @return void
     */
    public static function partial(string $path, array $data = []): void
    {
        ob_start();
        extract($data);
        require VIEW_DIR . "/{$path}.view.php";
        echo ob_get_clean();
    }

    public function guard(Role $role): void
    {
        $user = $this->getUser();

        if (null === $user) {
            $this->redirect('/login')->send();
        }

        if ($user->getRole() === Role::ADMIN) {
            return;
        }

        if ($user->getRole() !== $role) {
            $this->redirect('/login')->send();
        }
    }

    public function getUser(): ?User
    {
        return App::get('session')->getUser();
    }

    /**
     * Redirects the browser to a different location.
     *
     * @param string $path
     * @return RedirectResponse
     */
    protected function redirect(string $path): RedirectResponse
    {
        return new RedirectResponse($path);
    }

    /**
     * Loads a view file and returns the rendered string.
     *
     * @param string $name
     * @param array $data
     * @return Response
     */
    protected function view(string $name, array $data = []): Response
    {
        ob_start();
        extract($data);
        require VIEW_DIR . "/{$name}.view.php";
        $content = ob_get_clean();

        return (new Response())
            ->setContentType('text/html')
            ->setContent($content);
    }

    /**
     * Returns an array of object values of the specified property.
     *
     * @param array $objects The objects to take values from.
     * @param string $property Which property to create an array of.
     * @return array|null
     */
    public function pluck(array $objects, string $property): ?array
    {
        $filteredResults = array_map(function ($object) use ($property) {
            return $object->$property;
        }, $objects);

        return array_values($filteredResults);
    }
}
