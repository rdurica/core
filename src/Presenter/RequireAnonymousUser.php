<?php

declare(strict_types=1);

namespace Rdurica\Core\Presenter;

/**
 * RequireAnonymousUser.
 * @method getUser()
 * @method redirect(string $string)
 *
 * @codeCoverageIgnore
 * @property array $onStartup
 * @package   Rdurica\Core\Presenter
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-01-25
 */
trait RequireAnonymousUser
{
    /**
     * Check if user is logged in. If yes redirect to home.
     *
     * @return void
     */
    public function injectRequireAnonymousUser(): void
    {
        $this->onStartup[] = function () {
            if ($this->getUser()->isLoggedIn()) {
                $this->redirect('Home:');
            }
        };
    }
}
