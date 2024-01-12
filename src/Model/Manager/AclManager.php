<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

/**
 * AclManager.
 *
 * @package   Rdurica\Core\Model\Manager
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-13
 */
final class AclManager extends Manager
{
    /** @var string Table name. */
    private const TABLE = 'core_acl';

    /** @inheritDoc */
    protected function getTableName(): string
    {
        return self::TABLE;
    }

    /**
     * Find Resources & privileges for role
     *
     * @param array<int, string> $roles
     *
     * @return array<int, string|int>
     */
    public function findByRoles(array $roles): array
    {
        return $this->find()
            ->select('resource_code, privilege_code')
            ->where('role_code', array_values($roles))
            ->fetchAll();
    }
}
