<?php declare(strict_types=1);

namespace Rdurica\Core\Enum;

/**
 * Privileges.
 *
 * @package   Rdurica\Core\Constant
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-13
 */
enum Privileges: string
{
    /** Allow to view. */
    case VIEW = 'view';

    /** Allow to create. */
    case CREATE = 'create';

    /** Allow to edit. */
    case EDIT = 'edit';

    /** Allow to delete. */
    case DELETE = 'delete';

    /** Allow all operations. */
    case ALL = 'all';
}
