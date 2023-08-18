<?php

declare(strict_types=1);

namespace PhpUnit\AuthorizationService;

use Mockery;
use Mockery\MockInterface;
use Rdurica\Core\Model\Service\AuthorizationService;
use Rdurica\Core\Model\Service\AuthenticationService;

/**
 * Service builder.
 *
 * @package   PhpUnit\AuthorizationService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AuthorizationServiceBuilder
{
    /** @var AuthenticationService|null Mock. */
    private ?AuthenticationService $authenticationService = null;

    /**
     * Create builder.
     *
     * @return AuthorizationServiceBuilder
     */
    public static function create(): AuthorizationServiceBuilder
    {
        return new self();
    }

    /**
     * Setter.
     *
     * @param AuthenticationService|null $authenticationService
     * @return $this
     */
    public function setAuthenticationService(?AuthenticationService $authenticationService): AuthorizationServiceBuilder
    {
        $this->authenticationService = $authenticationService;
        return $this;
    }

    /**
     * Build service mock.
     *
     * @return MockInterface|AuthorizationService
     */
    public function build(): MockInterface|AuthorizationService
    {
        $this->authenticationService ??= Mockery::mock(AuthenticationService::class);

        return Mockery::mock(AuthorizationService::class, [
            $this->authenticationService
        ])->makePartial();
    }
}
