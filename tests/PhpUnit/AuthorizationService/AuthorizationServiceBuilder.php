<?php

declare(strict_types=1);

namespace PhpUnit\AuthorizationService;

use Mockery;
use Mockery\MockInterface;
use Rdurica\Core\Model\Service\AuthorizationService;
use Rdurica\Core\Model\Service\UserService;

/**
 * Service builder.
 *
 * @package   PhpUnit\AuthorizationService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AuthorizationServiceBuilder
{
    /** @var UserService|null Mock. */
    private ?UserService $userServiceMock = null;

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
     * @param UserService|null $userServiceMock
     * @return $this
     */
    public function setUserServiceMock(?UserService $userServiceMock): AuthorizationServiceBuilder
    {
        $this->userServiceMock = $userServiceMock;
        return $this;
    }

    /**
     * Build service mock.
     *
     * @return MockInterface|AuthorizationService
     */
    public function build(): MockInterface|AuthorizationService
    {
        $this->userServiceMock ??= Mockery::mock(UserService::class);

        return Mockery::mock(AuthorizationService::class, [
            $this->userServiceMock
        ])->makePartial();
    }
}
