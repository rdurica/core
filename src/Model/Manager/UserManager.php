<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

use Nette\Database\Table\ActiveRow;

class UserManager extends Manager
{
    /** @var string Table name. */
    private const TABLE = 'core_users';

    /** @inheritDoc */
    protected function getTableName(): string
    {
        return self::TABLE;
    }

    /**
     * Find user by username.
     *
     * @param string $username
     * @return ActiveRow|null
     */
    public function findByUsername(string $username): ?ActiveRow
    {
        return $this->find()
            ->where("username = ?", $username)
            ->fetch();
    }

    /**
     * Find user by email.
     *
     * @param string $email
     * @return ActiveRow|null
     */
    public function findByEmail(string $email): ?ActiveRow
    {
        return $this->find()
            ->where("email = ?", $email)
            ->fetch();
    }
}