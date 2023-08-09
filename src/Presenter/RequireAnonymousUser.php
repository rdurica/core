<?php

declare(strict_types=1);

namespace Rdurica\Core\Presenter;

/**
 * RequireAnonymousUser.
 * @method getUser()
 * @method redirect(string $string)
 *
 * @property array $onStartup
 * @package   Rdurica\Core\Presenter
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
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