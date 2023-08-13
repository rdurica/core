<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

final class UserRoleManager extends Manager
{

    /** @var string Table name. */
    private const TABLE = 'core_acl_user_roles';

    /** @inheritDoc */
    protected function getTableName(): string
    {
        return self::TABLE;
    }

    /**
     * Find all user roles by user id.
     *
     * @param int $userId
     * @return array<string|int> All user roles & ids [role => role_id]
     */
    public function findByUserId(int $userId): array
    {
        return $this->find()
            ->select('role.role, role_id')
            ->where(['user_id' => $userId])
            ->fetchPairs('role', 'role_id');
    }
}
