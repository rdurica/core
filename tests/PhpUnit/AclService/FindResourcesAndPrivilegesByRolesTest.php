<?php

declare(strict_types=1);

namespace PhpUnit\AclService;

use Mockery;
use Nette\Utils\ArrayHash;
use PHPUnit\Framework\TestCase;
use Rdurica\Core\Model\Manager\AclManager;

/**
 * FindResourcesAndPrivilegesByRolesTest
 *
 * @package   PhpUnit\AclService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 * @covers    \Rdurica\Core\Model\Service\AclService
 */
final class FindResourcesAndPrivilegesByRolesTest extends TestCase
{
    /**
     * Test case when no roles are provided.
     *
     * @return void
     */
    public function testNoRolesAsSource(): void
    {
        $aclManagerMock = Mockery::mock(AclManager::class);
        $aclManagerMock->shouldReceive('findByRoles')
            ->never();

        $service = AclServiceBuilder::create()
            ->setAclManagerMock($aclManagerMock)
            ->build();

        $result = $service->findResourcesAndPrivilegesByRoles([]);
        $expectation = [];

        $this->assertEquals($expectation, $result);
    }

    /**
     * Test case no resource found for role.
     *
     * @return void
     */
    public function testNoResourcesForRole(): void
    {
        $aclManagerMock = Mockery::mock(AclManager::class);
        $aclManagerMock->shouldReceive('findByRoles')
            ->once()
            ->andReturn([]);

        $service = AclServiceBuilder::create()
            ->setAclManagerMock($aclManagerMock)
            ->build();

        $result = $service->findResourcesAndPrivilegesByRoles(['xxx']);
        $expectation = [];

        $this->assertEquals($expectation, $result);
    }

    /**
     * Test case role has resources and privileges privileges.
     *
     * @return void
     */
    public function testRoleHasResourcesAndPrivileges(): void
    {
        $aclManagerMock = Mockery::mock(AclManager::class);
        $aclManagerMock->shouldReceive('findByRoles')
            ->once()
            ->andReturn([
                ArrayHash::from(['resource' => 'resOne', 'privilege' => 'one', 'privilege_id' => 1]),
                ArrayHash::from(['resource' => 'resOne', 'privilege' => 'two', 'privilege_id' => 2]),
                ArrayHash::from(['resource' => 'resOne', 'privilege' => 'three', 'privilege_id' => 3]),
                ArrayHash::from(['resource' => 'resTwo', 'privilege' => 'one', 'privilege_id' => 1]),
                ArrayHash::from(['resource' => 'resTwo', 'privilege' => 'two', 'privilege_id' => 2]),
                ArrayHash::from(['resource' => 'resTwo', 'privilege' => 'two', 'privilege_id' => 2]),
            ]);

        $service = AclServiceBuilder::create()
            ->setAclManagerMock($aclManagerMock)
            ->build();

        $result = $service->findResourcesAndPrivilegesByRoles(['xxx']);
        $expectation = [
            'resOne' => ['one' => 1, 'two' => 2, 'three' => 3],
            'resTwo' => ['one' => 1, 'two' => 2],
        ];

        $this->assertEquals($expectation, $result);
    }
}
