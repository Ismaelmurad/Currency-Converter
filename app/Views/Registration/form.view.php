<?php

use App\Controllers\Controller;
use App\Services\Container\App;

Controller::partial(
    'Partials/header',
    [
        'title' => 'Registrieren',
    ]
);
?>
<main>
    <div class="w-100 d-flex justify-content-center align-items-center">

        <div class="card border-0 p-5 mt-5">
            <div class="mt-3">
                <form action="/registration/store" method="post">
                    <div class="mb-3">
                        <label for="first_name"
                               class="form-label ms-2 fw-bold">Vorname*</label>
                        <input name="first_name"
                               type="text"
                               class="form-control"
                               id="first_name"
                               placeholder="Vorname"
                               size="40"
                               maxlength="100"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="last_name"
                               class="form-label ms-2 fw-bold">Nachname*</label>
                        <input name="last_name"
                               type="text"
                               class="form-control"
                               id="last_name"
                               placeholder="Nachname"
                               size="40"
                               maxlength="100"
                           >
                    </div>
                    <div class="mb-3">
                        <label for="password"
                               class="form-label ms-2 fw-bold">Passwort*</label>
                        <input name="password"
                               type="password"
                               class="form-control"
                               id="password"
                               placeholder="Passwort"
                               size="40"
                               maxlength="100"
                        >
                    </div>
                    <div class="mb-3">
                        <label for="email"
                               class="form-label ms-2 fw-bold">E-Mail Adresse*</label>
                        <input
                                name="email"
                                type="email"
                                class="form-control <?= isset($errors['email']) ? 'is-invalid' : ''; ?>"
                                id="email"
                                placeholder="maxmustermann@example.com"
                                size="40"
                                maxlength="255"
                        >
                        <div class="invalid-feedback">
                            <?= $errors['email']; ?>
                        </div>
                    </div>
                    <button type="submit"
                            class="btn btn-success">
                        <?php if (App::environment('local')) : ?>
                            Registrieren
                        <?php else : ?>
                            Speichern
                        <?php endif; ?>
                    </button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php Controller::partial('Partials/footer'); ?>