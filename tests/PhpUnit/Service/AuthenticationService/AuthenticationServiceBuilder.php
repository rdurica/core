<?php

declare(strict_types=1);

namespace PhpUnit\Service\AuthenticationService;

use Mockery;
use Mockery\MockInterface;
use Nette\Http\Session;
use Nette\Security\Passwords;
use Rdurica\Core\Model\Manager\UserManager;
use Rdurica\Core\Model\Manager\UserRoleManager;
use Rdurica\Core\Model\Service\AclService;
use Rdurica\Core\Model\Service\AuthenticationService;

/**
 * AuthenticationServiceBuilder.
 *
 * @package   PhpUnit\AuthenticationService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AuthenticationServiceBuilder
{
    /** @var AclService|null Mock. */
    private ?AclService $aclServiceMock = null;

    /** @var UserManager|null Mock. */
    private ?UserManager $userManagerMock = null;

    /** @var UserRoleManager|null Mock. */
    private ?UserRoleManager $userRoleManagerMock = null;

    /** @var Passwords|null Mock. */
    private ?Passwords $passwordsMock = null;

    /** @var Session|null Mock. */
    private ?Session $sessionMock = null;

    /**
     * Create builder.
     *
     * @return AuthenticationServiceBuilder
     */
    public static function create(): AuthenticationServiceBuilder
    {
        return new self();
    }

    /**
     * Set parameter {@see $aclServiceMock}.
     *
     * @param AclService|null $aclServiceMock
     * @return AuthenticationServiceBuilder
     */
    public function setAclServiceMock(?AclService $aclServiceMock): AuthenticationServiceBuilder
    {
        $this->aclServiceMock = $aclServiceMock;
        return $this;
    }

    /**
     * Set parameter {@see $userManagerMock}.
     *
     * @param UserManager|null $userManagerMock
     * @return AuthenticationServiceBuilder
     */
    public function setUserManagerMock(?UserManager $userManagerMock): AuthenticationServiceBuilder
    {
        $this->userManagerMock = $userManagerMock;
        return $this;
    }

    /**
     * Set parameter {@see $userRoleManagerMock}.
     *
     * @param UserRoleManager|null $userRoleManagerMock
     * @return AuthenticationServiceBuilder
     */
    public function setUserRoleManagerMock(?UserRoleManager $userRoleManagerMock): AuthenticationServiceBuilder
    {
        $this->userRoleManagerMock = $userRoleManagerMock;
        return $this;
    }

    /**
     * Set parameter {@see $passwordsMock}.
     *
     * @param Passwords|null $passwordsMock
     * @return AuthenticationServiceBuilder
     */
    public function setPasswordsMock(?Passwords $passwordsMock): AuthenticationServiceBuilder
    {
        $this->passwordsMock = $passwordsMock;
        return $this;
    }

    /**
     * Set parameter {@see $sessionMock}.
     *
     * @param Session|null $sessionMock
     * @return AuthenticationServiceBuilder
     */
    public function setSessionMock(?Session $sessionMock): AuthenticationServiceBuilder
    {
        $this->sessionMock = $sessionMock;
        return $this;
    }

    /**
     * Build service mock.
     *
     * @return MockInterface|AuthenticationService
     */
    public function build(): MockInterface|AuthenticationService
    {
        $this->aclServiceMock ??= Mockery::mock(AclService::class);
        $this->userManagerMock ??= Mockery::mock(UserManager::class);
        $this->userRoleManagerMock ??= Mockery::mock(UserRoleManager::class);
        $this->passwordsMock ??= Mockery::mock(Passwords::class);
        $this->sessionMock ??= Mockery::mock(Session::class);

        return Mockery::mock(AuthenticationService::class, [
            $this->aclServiceMock,
            $this->userManagerMock,
            $this->userRoleManagerMock,
            $this->passwordsMock,
            $this->sessionMock
        ])->makePartial();
    }
}