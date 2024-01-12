<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

use Nette\Database\Table\ActiveRow;

/**
 * UserRoleManager.
 *
 * @package   Rdurica\Core\Model\Manager
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-13
 */
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
     *
     * @return array All user roles & ids [role => role_id]
     */
    public function findByUserId(int $userId): array
    {
        return $this->find()
            ->where(['user_id' => $userId])
            ->fetchPairs('user_id', 'role_code');
    }
}
