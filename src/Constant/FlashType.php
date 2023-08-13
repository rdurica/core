<?php

declare(strict_types=1);

namespace Rdurica\Core\Constant;

/**
 * Types of flash messages.
 *
 * @package   Rdurica\Core\Util
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class FlashType
{
    /** @var string Red with (x). */
    public const ERROR = "error";

    /** @var string Orange with (!) . */
    public const WARNING = "warning";

    /** @var string Green with (✓). */
    public const SUCCESS = "success";

    /** @var string Blue with (i). */
    public const INFO = "info";

    /** @var string Grey with (?). */
    public const QUESTION = "question";
}
