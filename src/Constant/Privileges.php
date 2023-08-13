<?php

declare(strict_types=1);

namespace Rdurica\Core\Constant;

/**
 * Privileges.
 *
 * @package   Rdurica\Core\Constant
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
class Privileges
{
    /** Allow to view. */
    public const  VIEW = 'view';

    /** Allow to create. */
    public const  CREATE = 'create';

    /** Allow to edit. */
    public const  EDIT = 'edit';

    /** Allow to delete. */
    public const  DELETE = 'delete';

    /** Allow all operations. */
    public const  ALL = 'all';
}
