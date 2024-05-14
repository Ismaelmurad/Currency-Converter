<?php

use App\Models\User;
use App\Services\Container\App;

$user = App::get('session')->getUser();
?>
<?php
if (!in_array($_SERVER['REQUEST_URI'], ['/login', '/authentication', '/registration', '/registration/store']) && (!($user instanceof User))): ?>
    <div class="container-fluid">
        <div class="row">
            <div class="col-10 col-md-11 col-lg-9 col-xl-10 col-xxl-6 m-auto" style="max-width: 1200px">

                <div class="mt-4 bg-white p-4 shadow rounded text-center">
                    <?php if (App::environment('local')) : ?>
                        <a
                            href="/registration"
                            class="link-secondary fw-bold text-decoration-none"
                        >Register</a> /
                    <?php endif; ?>
                    <a
                        href="/login"
                        class="link-secondary fw-bold text-decoration-none"
                    >Login</a>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>

</body>
</html>
