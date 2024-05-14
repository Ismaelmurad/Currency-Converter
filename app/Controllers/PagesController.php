<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Services\Http\Response;

class PagesController extends Controller
{
    /** Returns the 404 page */
    public function notFound(): Response
    {
        return $this->view('404');
    }
}
