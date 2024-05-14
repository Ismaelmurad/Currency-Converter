<?php

use App\Controllers\Controller;

Controller::partial(
    'Partials/header',
    [
        'title' => 'Login',
    ]
); ?>

<main>
    <div class="w-100 d-flex justify-content-center align-items-center">

        <div class="card border-0 p-5 mt-5">
            <div class="mt-3">
                <form method="post" action="/authentication">
                    <input type="hidden" name="submit" value="1">
                    <div class="form-group mb-3 <?= $error ? 'was-validated' : '' ?>">
                        <label for="email">E-Mail Adresse</label>
                        <input
                                type="text"
                                name="email"
                                class="form-control"
                                id="email"
                                placeholder="E-Mail"
                                value="<?= $old['email'] ?? ''; ?>"
                                required
                        >
                    </div>
                    <div class="form-group <?= $error ? 'was-validated' : '' ?>">
                        <label for="password">Passwort</label>
                        <input type="password"
                               name="password"
                               class="form-control"
                               id="password"
                               placeholder="Passwort"
                               required>
                    </div>

                    <?php
                    if (!empty($error)): ?>
                        <div class="invalid-feedback d-block"><?= $error ?></div>
                    <?php
                    endif; ?>

                    <button type="submit" class="btn btn-success mt-2 d-block w-100 mt-4">Einloggen</button>
                </form>
            </div>
        </div>
    </div>
</main>

<?php
Controller::partial('Partials/footer'); ?>
