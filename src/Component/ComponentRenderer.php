<?php declare(strict_types=1);

namespace Rdurica\Core\Component;

use ReflectionClass;

use function dirname;
use function get_class;

/**
 * ComponentRenderer.
 *
 * @package   Rdurica\Core\Component
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-08
 * @method getTemplate()
 * @codeCoverageIgnore
 */
trait ComponentRenderer
{
    /**
     * Render default template at same directory.
     *
     * @return void
     */
    public function render(): void
    {
        $reflector = new ReflectionClass(get_class($this));
        $this->getTemplate()->setFile(dirname($reflector->getFileName()) . '/default.latte');
        $this->getTemplate()->render();
    }
}
