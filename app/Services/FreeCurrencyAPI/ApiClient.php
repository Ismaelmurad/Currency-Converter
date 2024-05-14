<?php

declare(strict_types=1);

namespace App\Services\FreeCurrencyAPI;

use App\Models\Currency;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\GuzzleException;

class ApiClient
{
    private GuzzleClient $client;
    private string $apiKey;

    public function __construct()
    {
        $this->apiKey = $_ENV['FREE_CURRENCY_API_KEY'];
        $this->client = new GuzzleClient([
            'base_uri' => 'https://api.freecurrencyapi.com/v1/',
            'timeout' => 5.0,
            'headers' => [
                'apikey' => $this->apiKey,
            ],
        ]);
    }

    /**
     * Returns the list of available currencies.
     *
     * @return array
     */
    public function getCurrencies(): array
    {
        try {
            $response = $this->client->get('currencies');
        } catch (GuzzleException ) {
            return [];
        }

        $content = $response->getBody()->getContents();

        if (!empty($content)) {
            return json_decode($content, true);
        } else {
            return [];
        }
    }

    /**
     * Returns the latest exchange rate for a currency.
     *
     * @param Currency $baseCurrency
     * @param Currency $targetCurrency
     * @return float|null
     */
    public function getLatestExchangeRate(Currency $baseCurrency, Currency $targetCurrency): ?float
    {
        try {
            $response = $this->client->get(
                'latest',
                [
                    'query' => [
                        'base_currency' => $baseCurrency->getIso4217(),
                        'currencies' => $targetCurrency->getIso4217(),
                    ],
                ]
            );
        } catch (GuzzleException) {
            return null;
        }

        $content = $response->getBody()->getContents();

        if (empty($content))
        {
            return null;
        }

        $content = json_decode($content, true);

        return $content['data'][$targetCurrency->getIso4217()];
    }
}