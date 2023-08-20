<?php

declare(strict_types=1);

namespace PhpUnit\AuthorizationService;

use Mockery;
use PHPUnit\Framework\TestCase;
use Rdurica\Core\Constant\Privileges;
use Rdurica\Core\Constant\Role;
use Rdurica\Core\Model\Service\AuthenticationService;

/**
 * IsAllowedTest.
 *
 * @package   PhpUnit\AuthorizationService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 * @covers    \Rdurica\Core\Model\Service\AuthorizationService
 */
final class IsAllowedTest extends TestCase
{

    /**
     * Test global admin role - have all rights.
     *
     * @return void
     */
    public function testGlobalAdmin(): void
    {
        $service = AuthorizationServiceBuilder::create()
            ->build();

        $result = $service->isAllowed(Role::GLOBAL_ADMIN, 'xxx', 'yyy');

        $this->assertTrue($result);
    }

    /**
     * Test if no resource available.
     *
     * @return void
     */
    public function testNoResources(): void
    {
        // Services
        $userServiceMock = Mockery::mock(AuthenticationService::class);
        $userServiceMock
            ->shouldReceive('getUserResourcesAndPrivilegesFromSession')
            ->once()
            ->andReturn([]);

        $service = AuthorizationServiceBuilder::create()
            ->setAuthenticationService($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    /**
     * Test if no section in cache.
     *
     * @return void
     */
    public function testNullResources(): void
    {
        // Services
        $userServiceMock = Mockery::mock(AuthenticationService::class);
        $userServiceMock
            ->shouldReceive('getUserResourcesAndPrivilegesFromSession')
            ->once()
            ->andReturn(null);

        $service = AuthorizationServiceBuilder::create()
            ->setAuthenticationService($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    /**
     * Test if user has resource but no privilege.
     *
     * @return void
     */
    public function testHasResourceAndNoPrivilege(): void
    {
        // Services
        $userServiceMock = Mockery::mock(AuthenticationService::class);
        $userServiceMock
            ->shouldReceive('getUserResourcesAndPrivilegesFromSession')
            ->once()
            ->andReturn(['xxx' => ['zzz' => 111]]);

        $service = AuthorizationServiceBuilder::create()
            ->setAuthenticationService($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    /**
     * Test if user has resource and privilege.
     *
     * @return void
     */
    public function testHasResourceAndPrivilege(): void
    {
        // Services
        $userServiceMock = Mockery::mock(AuthenticationService::class);
        $userServiceMock
            ->shouldReceive('getUserResourcesAndPrivilegesFromSession')
            ->once()
            ->andReturn(['xxx' => ['yyy' => 111]]);

        $service = AuthorizationServiceBuilder::create()
            ->setAuthenticationService($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertTrue($result);
    }

    /**
     * Test if user has resource but privilege ALL.
     *
     * @return void
     */
    public function testHasResourceAndPrivilegeAll(): void
    {
        // Services
        $userServiceMock = Mockery::mock(AuthenticationService::class);
        $userServiceMock
            ->shouldReceive('getUserResourcesAndPrivilegesFromSession')
            ->once()
            ->andReturn(['xxx' => [Privileges::ALL => 111]]);

        $service = AuthorizationServiceBuilder::create()
            ->setAuthenticationService($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertTrue($result);
    }

    /**
     * Test if user has different resource but privilege ALL.
     *
     * @return void
     */
    public function testHasDifferentResourceAndPrivilegeAll(): void
    {
        // Services
        $userServiceMock = Mockery::mock(AuthenticationService::class);
        $userServiceMock
            ->shouldReceive('getUserResourcesAndPrivilegesFromSession')
            ->once()
            ->andReturn(['zzz' => [Privileges::ALL => 111]]);

        $service = AuthorizationServiceBuilder::create()
            ->setAuthenticationService($userServiceMock)
            ->build();

        $result = $service->isAllowed('xyz', 'xxx', 'yyy');

        $this->assertFalse($result);
    }

    public function tearDown(): void
    {
        Mockery::close();
    }
}
