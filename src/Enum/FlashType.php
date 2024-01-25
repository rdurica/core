<?php declare(strict_types=1);

namespace Rdurica\Core\Enum;

/**
 * FlashType.
 *
 * @package   Rdurica\Core\Constant
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-10
 */
enum FlashType: string
{
    /** Red with (x). */
    case ERROR = 'error';

    /** Orange with (!) . */
    case WARNING = 'warning';

    /** Green with (✓). */
    case SUCCESS = 'success';

    /** Blue with (i). */
    case INFO = 'info';

    /** Grey with (?). */
    case QUESTION = 'question';
}
