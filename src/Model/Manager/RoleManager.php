<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

final class RoleManager extends Manager
{
    /** @var string Table name. */
    private const TABLE = 'core_acl_role';

    /** @inheritDoc */
    protected function getTableName(): string
    {
        return self::TABLE;
    }
}
