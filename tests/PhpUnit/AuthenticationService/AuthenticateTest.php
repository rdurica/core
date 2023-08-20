<?php

declare(strict_types=1);

namespace PhpUnit\AuthenticationService;

use Mockery;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\Security\Passwords;
use PHPUnit\Framework\TestCase;
use Rdurica\Core\Exception\Authentication\InvalidPasswordException;
use Rdurica\Core\Exception\Authentication\UserIsDisabledException;
use Rdurica\Core\Exception\Authentication\UserNotFoundException;
use Rdurica\Core\Model\Entity\CoreIdentity;
use Rdurica\Core\Model\Manager\UserManager;
use Rdurica\Core\Model\Manager\UserRoleManager;
use Rdurica\Core\Model\Service\AclService;

/**
 * AuthenticateTest.
 *
 * @package   PhpUnit\AuthenticationService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 * @covers    \Rdurica\Core\Model\Service\AuthenticationService
 * @covers    \Rdurica\Core\Exception\Authentication\UserNotFoundException
 * @covers    \Rdurica\Core\Exception\Authentication\InvalidPasswordException
 * @covers    \Rdurica\Core\Exception\Authentication\UserIsDisabledException
 * @covers    \Rdurica\Core\Model\Entity\CoreIdentity
 */
final class AuthenticateTest extends TestCase
{
    /**
     * Test case when user not found.
     *
     * @return void
     * @throws InvalidPasswordException
     * @throws UserIsDisabledException
     * @throws UserNotFoundException
     */
    public function testUserNotFound(): void
    {
        $userManager = Mockery::mock(UserManager::class);
        $userManager
            ->shouldReceive('findByUsername')
            ->once()
            ->with('user123')
            ->andReturn(null);

        $this->expectException(UserNotFoundException::class);
        $this->expectExceptionMessage('User user123 not found');

        $service = AuthenticationServiceBuilder::create()
            ->setUserManagerMock($userManager)
            ->build();

        $service->authenticate('user123', 'password123');
    }

    /**
     * Test case when user enters invalid password.
     *
     * @return void
     * @throws InvalidPasswordException
     * @throws UserIsDisabledException
     * @throws UserNotFoundException
     */
    public function testInvalidPassword(): void
    {
        $selection = Mockery::mock(Selection::class)->makePartial();

        $activeRow = new ActiveRow(['password' => 'xxx'], $selection);

        // Services
        $userManager = Mockery::mock(UserManager::class);
        $userManager
            ->shouldReceive('findByUsername')
            ->once()
            ->with('user123')
            ->andReturn($activeRow);
        $passwords = Mockery::mock(Passwords::class);
        $passwords->shouldReceive('verify')
            ->once()
            ->with('password123', 'xxx')
            ->andReturn(false);

        $this->expectException(InvalidPasswordException::class);
        $this->expectExceptionMessage('Invalid password for user user123');

        $service = AuthenticationServiceBuilder::create()
            ->setUserManagerMock($userManager)
            ->setPasswordsMock($passwords)
            ->build();

        $service->authenticate('user123', 'password123');
    }

    /**
     * Test case when user is disabled.
     *
     * @return void
     * @throws InvalidPasswordException
     * @throws UserIsDisabledException
     * @throws UserNotFoundException
     */
    public function testDisabledUser(): void
    {
        $selection = Mockery::mock(Selection::class)->makePartial();

        $activeRow = new ActiveRow(['password' => 'xxx', 'is_enabled' => 0], $selection);

        // Services
        $userManager = Mockery::mock(UserManager::class);
        $userManager
            ->shouldReceive('findByUsername')
            ->once()
            ->with('user123')
            ->andReturn($activeRow);
        $passwords = Mockery::mock(Passwords::class);
        $passwords->shouldReceive('verify')
            ->once()
            ->with('password123', 'xxx')
            ->andReturn(true);

        $this->expectException(UserIsDisabledException::class);
        $this->expectExceptionMessage('User user123 is disabled');

        $service = AuthenticationServiceBuilder::create()
            ->setUserManagerMock($userManager)
            ->setPasswordsMock($passwords)
            ->build();

        $service->authenticate('user123', 'password123');
    }

    /**
     * Test happy path when CoreIdentity is created,
     *
     * @return void
     * @throws InvalidPasswordException
     * @throws UserIsDisabledException
     * @throws UserNotFoundException
     */
    public function testCoreIdentity(): void
    {
        $selection = Mockery::mock(Selection::class)->makePartial();
        $activeRow = new ActiveRow([
            'id' => 1,
            'username' => 'user123',
            'email' => 'user123@example.net',
            'password' => 'xxx',
            'is_enabled' => 1
        ],
            $selection);

        // Services
        $userManager = Mockery::mock(UserManager::class);
        $userManager
            ->shouldReceive('findByUsername')
            ->once()
            ->with('user123')
            ->andReturn($activeRow);

        $roleManager = Mockery::mock(UserRoleManager::class);
        $roleManager
            ->shouldReceive('findByUserId')
            ->once()
            ->with(1)
            ->andReturn([]);

        $aclService = Mockery::mock(AclService::class);
        $aclService
            ->shouldReceive('findResourcesAndPrivilegesByRoles')
            ->with([])
            ->andReturn([]);

        $sessionSection = Mockery::mock(SessionSection::class);
        $sessionSection->shouldReceive('offsetSet');

        $session = Mockery::mock(Session::class);
        $session->shouldReceive('getSection')
            ->once()
            ->andReturn($sessionSection);

        $passwords = Mockery::mock(Passwords::class);
        $passwords->shouldReceive('verify')
            ->once()
            ->with('password123', 'xxx')
            ->andReturn(true);

        $service = AuthenticationServiceBuilder::create()
            ->setUserManagerMock($userManager)
            ->setPasswordsMock($passwords)
            ->setUserRoleManagerMock($roleManager)
            ->setAclServiceMock($aclService)
            ->setSessionMock($session)
            ->build();

        $result = $service->authenticate('user123', 'password123');
        $expectation = new CoreIdentity(1, 'user123', 'user123@example.net', []);

        self::assertEquals($expectation, $result);
    }
}