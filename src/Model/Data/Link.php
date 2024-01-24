<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Data;

/**
 * Link.
 *
 * @package   Rdurica\Core\Model\Data
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-01-24
 */
final class Link
{
    /**
     * Create link to Module:Presenter:action.
     *
     * @param string $module
     * @param string $presenter
     * @param string $action
     */
    public function __construct(private string $module, private string $presenter, private string $action = 'default')
    {
    }

    /**
     * Get link to module:presenter:action.
     *
     * @return string
     */
    public function getLink(): string
    {
        return sprintf(':%s:%s:%s', $this->module, $this->presenter, $this->action);
    }
}
