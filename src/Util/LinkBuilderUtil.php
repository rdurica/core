<?php

declare(strict_types=1);

namespace Rdurica\Core\Util;

/**
 * String links.
 *
 * @package   Rdurica\Core\Util
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class LinkBuilderUtil
{
    /**
     * Create link to presenter:action.
     *
     * @param string $presenter
     * @param string $action
     * @return string
     */
    public static function simpleLink(string $presenter, string $action): string
    {
        return sprintf('%s:%s', $presenter, $action);
    }

    /**
     * Create link to module:presenter:action.
     *
     * @param string $module
     * @param string $presenter
     * @param string $action
     * @return string
     */
    public static function link(string $module, string $presenter, string $action): string
    {
        return sprintf(':%s:%s:%s', $module, $presenter, $action);
    }

}