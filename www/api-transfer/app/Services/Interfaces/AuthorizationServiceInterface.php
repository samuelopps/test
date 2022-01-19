<?php

namespace App\Services\Interfaces;

/**
 * Interface AuthorizationServiceInterface
 * @package App\Service\Interfaces
 */
interface AuthorizationServiceInterface
{

    /**
     * External authorizing service query
     * @return bool
     */
    public function getAuthorizationTransfer(): bool;
}
