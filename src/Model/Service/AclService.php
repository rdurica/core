<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Service;

use Rdurica\Core\Model\Manager\AclManager;

/**
 * AclService
 *
 * @package   Rdurica\Core\Model\Service
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AclService
{
    /**
     * Constructor.
     *
     * @param AclManager $aclManager
     */
    public function __construct(private readonly AclManager $aclManager)
    {
    }

    /**
     * Finds Resources & Privileges for roles.
     *
     * @param int[] $roles
     * @return array<string, array<string, int>> Returns [resource => [privilage => id]]
     */
    public function findResourcesAndPrivilegesByRoles(array $roles): array
    {
        $result = [];
        if (count($roles) === 0) {
            return $result;
        }

        $aclData = $this->aclManager->findByRoles($roles);
        foreach ($aclData as $row) {
            if (!array_key_exists($row->resource, $result)) {
                $result[$row['resource']] = [];
            }

            $result[$row['resource']] += [$row['privilege'] => $row['privilege_id']];
        }

        return $result;
    }
}