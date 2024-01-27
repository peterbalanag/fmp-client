<?php

namespace App\Services\DataProviders;

use App\Interfaces\DataProviderInterface;
use App\Services\DataProviderAbstract;
use Illuminate\Support\Facades\Cache;

class FinancialModelingPrepAPIService extends DataProviderAbstract implements DataProviderInterface
{

    private $baseUrl;
    private $apiKey;

    public function __construct()
    {
        $this->baseUrl = config('client.provider.fmp.url');
        $this->apiKey = config('client.provider.fmp.apiKey');
    }

    public function getCompanyProfile(string $symbol)
    {
        $cacheKey = "fmp//profile//$symbol";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = url($this->baseUrl . "/profile/" . $symbol);

        $response = $this->makeGetRequest($url, $this->apiKey);
        Cache::put($cacheKey, $response, now()->addMinutes(3));

        return $response;
    }

    public function getCompanyQuote(string $symbol)
    {
        $cacheKey = "fmp//quote//$symbol";

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $url = url($this->baseUrl . "/quote/" . $symbol);

        $response = $this->makeGetRequest($url, $this->apiKey);
        Cache::put($cacheKey, $response, now()->addMinutes(3));

        return $response;
    }

}