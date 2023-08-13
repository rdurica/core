<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

final class AclManager extends Manager
{
    /** @var string Table name. */
    public const TABLE = 'core_acl';

    /** @inheritDoc */
    protected function getTableName(): string
    {
        return self::TABLE;
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
        $aclData = $this->find()
            ->select('resource.resource, privilege.privilege, privilege_id')
            ->where('role_id', $roles)
            ->fetchAll();

        foreach ($aclData as $row) {
            if (!array_key_exists($row->resource, $result)) {
                $result[$row['resource']] = [];
            }

            $result[$row['resource']] += [$row['privilege'] => $row['privilege_id']];
        }

        return $result;
    }
}
