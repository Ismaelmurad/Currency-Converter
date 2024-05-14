<?php

use App\Enums\Role;
use App\Models\User;
use App\Services\Container\App;

$user = App::get('session')->getUser();
?>
<?php
if ($user instanceof User): ?>

    <div class="container">
        <div class="row">
            <div class="col-10 col-md-11 col-lg-9 col-xl-10 col-xxl-6 m-auto" style="width: 1320px">
                <nav class="navbar navbar-expand-lg bg-white shadow mt-4 rounded p-2 justify-content-end">
                    <button class="navbar-toggler"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent"
                            aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation"
                    >
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div
                            class="collapse navbar-collapse"
                            id="navbarSupportedContent"
                    >
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a
                                        class="nav-link <?= ($_SERVER['REQUEST_URI'] == '/' || str_starts_with(
                                                $_SERVER['REQUEST_URI'],
                                                '/calculate'
                                            )) ? 'active' : ''; ?>"
                                        href="/"
                                >Home</a>
                            </li>
                            <?php
                            if ($user->getRole() === Role::ADMIN): ?>
                                <li class="nav-item">
                                    <a
                                        class="nav-link <?= $_SERVER['REQUEST_URI'] == '/users' ? 'active' : ''; ?>"
                                        href="/users"
                                    >Benutzer</a>
                                </li>
                                <li class="nav-item">
                                    <a
                                        class="nav-link <?= $_SERVER['REQUEST_URI'] == '/currencies' ? 'active' : ''; ?>"
                                        href="/currencies"
                                    >Währungen</a>
                                </li>
                            <?php
                            endif; ?>
                            <li class="nav-item">
                                <a
                                    class="nav-link <?= str_starts_with($_SERVER['REQUEST_URI'], '/conversions') ? 'active' : ''; ?>"
                                    href="/conversions"
                                >Umrechnungen</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link"
                                   href="/logout">Logout</a>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>
    </div>

<?php endif; ?>