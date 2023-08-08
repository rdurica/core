<?php

declare(strict_types=1);

namespace Rdurica\Core\Presenter;

/**
 * SetMaterializeTemplateLayout.
 * @method setLayout(string $string)
 *
 * @property array $onStartup
 * @package   Rdurica\Core\Presenter
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
trait SetMaterializeTemplateLayout
{
    /**
     * Sets default layout for presenter to materialize {@link https://materializecss.com}
     *
     * @return void
     */
    public function injectSetMaterializeTemplateLayout(): void
    {
        $this->onStartup[] = function () {
            $this->setLayout(__DIR__ . "/../Templates/@layoutMaterialize.latte");
        };
    }
}