<?php

declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Controllers\Controller;
use App\Models\Conversion;
use App\Models\Currency;
use App\Services\Container\App;
use App\Services\Http\Request;
use App\Services\Http\Response;
use App\Services\Session\Session;

class ConversionController extends Controller
{
    public function index(): Response
    {
        /**
         * @var Session $session
         */
        $session = App::get('session');
        $user = $session->getUser();

        $conversions = Conversion::query()
            ->where('user_id', '=', $user->getId())
            ->keyBy('id')
            ->order('created_at', 'desc')
            ->paginate(
                (int)Request::input('page', 1),
                (int)Request::input('perPage', 15)
            );

        $currencyIds = array_merge(
            $this->pluck($conversions['items'], 'base_currency_id'),
            $this->pluck($conversions['items'], 'target_currency_id')
        );

        $currencyIds = array_unique($currencyIds);
        $currencies = Currency::query()
            ->whereIn('id', $currencyIds)
            ->keyBy('id')
            ->get();

        return $this->view(
            'Admin/Conversions/conversions',
            [
                'conversions' => $conversions['items'],
                'total' => $conversions['total'],
                'items' => $conversions['items'],
                'totalPages' => $conversions['totalPages'],
                'offset' => $conversions['offset'],
                'limit' => $conversions['limit'],
                'page' => $conversions['page'],
                'perPage' => $conversions['perPage'],
                'currencies' => $currencies,
                'old' => [
                    ...Request::input(),
                    'perPage' => Request::input('perPage', 15),
                ],
            ]
        );
    }

}