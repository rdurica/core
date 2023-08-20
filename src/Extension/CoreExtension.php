<?php

declare(strict_types=1);

namespace Rdurica\Core\Extension;

use Nette\DI\CompilerExtension;

/**
 * CoreExtension
 *
 * @package   Rdurica\Core\Extension
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 * @codeCoverageIgnore
 */
final class CoreExtension extends CompilerExtension
{
    /** @inheritDoc */
    public function loadConfiguration(): void
    {
        $this->compiler->loadDefinitionsFromConfig(
            $this->loadFromFile(__DIR__ . '/services.neon')['services'],
        );
    }
}