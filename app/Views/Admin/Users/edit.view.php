<?php
/** @var User $user */

use App\Controllers\Controller;
use App\Models\User;

Controller::partial(
    'Partials/header',
    [
        'title' => !empty($user) ? 'Benutzer bearbeiten: ' . $user->getFirstName() . ' ' . $user->getLastName(
            ) : 'Benutzer hinzufügen',
    ]
);
?>
<div class="w-100 d-flex justify-content-center align-items-center">
    <div class="card border-0 p-5  mt-5">
        <div class="mt-2">
            <form action="/users/update" method="post">
                <div class="mb-3 text-black">
                    <label
                            for="first_name"
                            class="form-label">Vorname</label>
                    <input
                            type="text"
                            class="form-control"
                            name="first_name"
                            id="first_name"
                            size="40"
                            maxlength="100"
                            value="<?= $user->getFirstName() ?? '' ?>">
                </div>

                <div class="mb-3 text-black">
                    <label for="last_name"
                           class="form-label">Nachname</label>
                    <input type="text"
                           class="form-control"
                           name="last_name"
                           id="last_name"
                           size="40"
                           maxlength="100"
                           value="<?= $user->getLastName() ?? '' ?>">
                </div>
                <div class="mb-3 text-black">
                    <label for="email"
                           class="form-label">E-Mail</label>
                    <input type="email"
                           class="form-control"
                           id="email"
                           name="email"
                           size="40"
                           maxlength="100"
                           value="<?= $user->getEmail() ?? '' ?>">
                </div>
                <label class="form-check-label text-black"
                       for="is_active">Ist der Benutzer aktiv?</label>
                <div class="form-check form-switch">
                    <input class="form-check-input"
                           type="checkbox"
                           role="switch"
                           id="is_active"
                           size="40"
                           maxlength="100"
                           name="is_active" <?= true === $user->isActive() ? 'checked' : '' ?>>
                </div>
                <input type="hidden"
                       name="id"
                       value="<?= $user->getId() ?>">
                <button class="submit btn btn-success"
                        type="submit">Änderungen speichern
                </button>
            </form>
        </div>
    </div>
</div>
<?php
Controller::partial('Partials/footer'); ?>
