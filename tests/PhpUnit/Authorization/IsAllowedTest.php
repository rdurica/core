<?php

declare(strict_types=1);

namespace PhpUnit\Authorization;

use Mockery;
use PHPUnit\Framework\TestCase;
use Rdurica\Core\Constant\Privileges;
use Rdurica\Core\Constant\Role;
use Rdurica\Core\Model\Service\UserService;

/**
 * IsAllowedTest.
 *
 * @covers    \Rdurica\Core\Model\Service\Authorization
 * @package   PhpUnit\Authorization
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class IsAllowedTest extends TestCase
{

    /**
     * Test global admin role - have all rights.
     *
     * @return void
     */
    public function testGlobalAdmin()
    {
        $service = AuthorizationBuilder::create()
            ->build();

        $result = $service->isAllowed(Role::GLOBAL_ADMIN, 'xxx', 'yyy');

        $this->assertTrue($result);
    }

    /**
     * Test if no resource available.
     *
     * @return void
     */
    public function testNoResources()
    {
        // Services
        $userServiceMock = Mockery::mock(UserService::class);
        $userServiceMock
            ->shouldReceive('getLoggedUserResourcesAndPrivileges')
            ->once()
            ->andReturn([]);

        $service = AuthorizationBuilder::create()
            ->setUserServiceMock($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    /**
     * Test if no section in cache.
     *
     * @return void
     */
    public function testNullResources()
    {
        // Services
        $userServiceMock = Mockery::mock(UserService::class);
        $userServiceMock
            ->shouldReceive('getLoggedUserResourcesAndPrivileges')
            ->once()
            ->andReturn(null);

        $service = AuthorizationBuilder::create()
            ->setUserServiceMock($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    /**
     * Test if user has resource but no privilege.
     *
     * @return void
     */
    public function testHasResourceAndNoPrivilege()
    {
        // Services
        $userServiceMock = Mockery::mock(UserService::class);
        $userServiceMock
            ->shouldReceive('getLoggedUserResourcesAndPrivileges')
            ->once()
            ->andReturn(['xxx' => ['zzz' => 111]]);

        $service = AuthorizationBuilder::create()
            ->setUserServiceMock($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    /**
     * Test if user has resource and privilege.
     *
     * @return void
     */
    public function testHasResourceAndPrivilege()
    {
        // Services
        $userServiceMock = Mockery::mock(UserService::class);
        $userServiceMock
            ->shouldReceive('getLoggedUserResourcesAndPrivileges')
            ->once()
            ->andReturn(['xxx' => ['yyy' => 111]]);

        $service = AuthorizationBuilder::create()
            ->setUserServiceMock($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertTrue($result);
    }

    /**
     * Test if user has resource but privilege ALL.
     *
     * @return void
     */
    public function testHasResourceAndPrivilegeAll()
    {
        // Services
        $userServiceMock = Mockery::mock(UserService::class);
        $userServiceMock
            ->shouldReceive('getLoggedUserResourcesAndPrivileges')
            ->once()
            ->andReturn(['xxx' => [Privileges::ALL => 111]]);

        $service = AuthorizationBuilder::create()
            ->setUserServiceMock($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertTrue($result);
    }

    /**
     * Test if user has different resource but privilege ALL.
     *
     * @return void
     */
    public function testHasDifferentResourceAndPrivilegeAll()
    {
        // Services
        $userServiceMock = Mockery::mock(UserService::class);
        $userServiceMock
            ->shouldReceive('getLoggedUserResourcesAndPrivileges')
            ->once()
            ->andReturn(['zzz' => [Privileges::ALL => 111]]);

        $service = AuthorizationBuilder::create()
            ->setUserServiceMock($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
