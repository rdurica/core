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
    /** @var string Red with (x). */
    case ERROR = 'error';

    /** @var string Orange with (!) . */
    case WARNING = 'warning';

    /** @var string Green with (✓). */
    case SUCCESS = 'success';

    /** @var string Blue with (i). */
    case INFO = 'info';

    /** @var string Grey with (?). */
    case QUESTION = 'question';
}
