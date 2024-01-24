<?php declare(strict_types=1);

namespace Rdurica\Core\Extension;

use Nette\DI\CompilerExtension;

/**
 * CoreExtension.
 *
 * @package   Rdurica\Core\Extension
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-08-08
 * @codeCoverageIgnore
 */
final class Extension extends CompilerExtension
{
    /** @inheritDoc */
    public function loadConfiguration(): void
    {
        $this->compiler->loadDefinitionsFromConfig(
            $this->loadFromFile(__DIR__ . '/services.neon')['services'],
        );
    }
}