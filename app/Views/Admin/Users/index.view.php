<?php

use App\Controllers\Controller;
use App\Models\User;

Controller::partial(
    'Partials/header',
    [
        'title' => 'users',
    ]
);
/**
 * @var User[] $users
 */
?>
    <div class="container">
        <div class="bg-white p-4 shadow mt-4 rounded">
            <div class="d-flex flex-row justify-content-between border-bottom pb-3 mb-2">
                <h4>Benutzer (<?= count($users); ?>)</h4>
                <div>
                    <a
                            href="/registration"
                            class="btn btn-success"
                    >Benutzer hinzufügen</a>
                </div>
            </div>

            <table class="table table-striped">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">First name</th>
                    <th scope="col">Last name</th>
                    <th scope="col">E-Mail</th>
                    <th scope="col">Aktiv?</th>
                    <th scope="col">Erstellt am</th>
                    <th scope="col">Aktualisiert</th>
                    <th style="width: 100px"></th>
                </tr>
                </thead>
                <tbody>
                <?php
                foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user->getId(); ?></td>
                        <td><?= $user->getFirstName(); ?></td>
                        <td><?= $user->getLastName(); ?></td>
                        <td><?= $user->getemail(); ?></td>
                        <td>
                            <?php
                            if (true === $user->isActive()): ?>
                                <button class="btn btn-sm btn-success w-100">
                                    Aktiv
                                </button>
                            <?php
                            else: ?>
                                <button class="btn btn-sm btn-warning w-100">
                                    Inaktiv
                                </button>
                            <?php
                            endif; ?>
                        </td>
                        <td><?= $user->getCreatedAt() ?></td>
                        <td><?= $user->getUpdatedAt() ?></td>
                        <td class="text-end">
                            <div class="btn-group">
                                <a
                                        class="btn btn-sm btn-secondary"
                                        href="/users/details?id=<?= $user->getId() ?>"
                                >Details</a>
                                <button
                                        type="button"
                                        class="btn btn-sm btn-secondary <?php if ($user->getId() !== 1) : ?>dropdown-toggle dropdown-toggle-split<?php endif; ?>"
                                        <?php if ($user->getId() !== 1) : ?>
                                        	data-bs-toggle="dropdown"
	                                        aria-expanded="false"
					<?php endif; ?>
                                >
                                    <span class="visually-hidden">Weite Aktionen ausklappen</span>
                                </button>
                                <?php if ($user->getId() !== 1) : ?>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a
                                                class="dropdown-item"
                                                href="/users/edit?id=<?= $user->getId() ?>"
                                        >Bearbeiten</a>
                                    </li>
                                    <li>
                                        <a
                                                class="dropdown-item btn btn-delete"
                                                href="/users/delete?id=<?= $user->getId() ?>"
                                                data-name="<?= $user->getFirstName() . ' ' . $user->getLastName() ?>"
                                        >Löschen</a>
                                    </li>
                                </ul>
                                <?php endif; ?>
                            </div>
                        </td>

                    </tr>
                <?php
                endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

<?php
Controller::partial(
    'Partials/modal.delete',
    [
        'title' => 'User löschen',
        'message' => 'Wollen Sie dem User "{name}" wirklich löschen?',
    ]
); ?>

<?php
Controller::partial('Partials/footer'); ?>
