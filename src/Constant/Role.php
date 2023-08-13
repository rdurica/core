<?php

declare(strict_types=1);

namespace Rdurica\Core\Constant;

/**
 * Roles.
 *
 * @package   Rdurica\Core\Constant
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
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
