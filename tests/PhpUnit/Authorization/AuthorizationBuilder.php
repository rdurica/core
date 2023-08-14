<?php

declare(strict_types=1);

namespace PhpUnit\Authorization;

use Mockery;
use Mockery\MockInterface;
use Rdurica\Core\Model\Service\Authorization;
use Rdurica\Core\Model\Service\UserService;

/**
 * Service builder.
 *
 * @package   PhpUnit\Authorization
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AuthorizationBuilder
{
    /** @var UserService|null Mock. */
    protected ?UserService $userServiceMock = null;

    /**
     * Create builder.
     *
     * @return AuthorizationBuilder
     */
    public static function create(): AuthorizationBuilder
    {
        return new self();
    }

    /**
     * Setter.
     *
     * @param UserService|null $userServiceMock
     * @return $this
     */
    public function setUserServiceMock(?UserService $userServiceMock): AuthorizationBuilder
    {
        $this->userServiceMock = $userServiceMock;
        return $this;
    }

    /**
     * Build service mock.
     *
     * @return MockInterface|Authorization
     */
    public function build(): MockInterface|Authorization
    {
        $this->userServiceMock ??= Mockery::mock(UserService::class);

        return Mockery::mock(Authorization::class, [
            $this->userServiceMock
        ])->makePartial();
    }
}
