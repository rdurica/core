<?php declare(strict_types=1);

namespace Rdurica\Core\Constant;

/**
 * Role.
 *
 * @package   Rdurica\Core\Constant
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-13
 */
class Role
{
    /** Default role. */
    public const USER = 'user';

    /** Site admin. */
    public const  ADMIN = 'site_admin';

    /** Global admin (has all rights). */
    public const  GLOBAL_ADMIN = 'global_admin';
}
