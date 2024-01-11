<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Manager;

/**
 * RoleManager.
 *
 * @package   Rdurica\Core\Model\Manager
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-13
 */
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
