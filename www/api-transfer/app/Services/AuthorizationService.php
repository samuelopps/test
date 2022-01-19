<?php

namespace App\Services;

use App\Services\Interfaces\AuthorizationServiceInterface;
use Illuminate\Support\Facades\Http;

/**
 * Class AuthorizationService
 * @package App\Service
 */
class AuthorizationService implements AuthorizationServiceInterface
{
    /**
     * @var string
     */
    private $urlAuthorization;

    /**
     * AuthorizationService constructor.
     */
    public function __construct()
    {
        $this->urlAuthorization = env('URL_AUTHORIZATION_SERVICE');
    }

    /**
     * External authorizing service query
     * @return bool
     */
    public function getAuthorizationTransfer(): bool
    {
        $response = Http::get($this->urlAuthorization);

        return $response->successful();
    }
}
