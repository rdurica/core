<?php

declare(strict_types=1);

namespace Rdurica\Core\Presenter;

/**
 * RequireLoggedUser.
 * @method getUser()
 * @method storeRequest()
 * @method redirect(string $string)
 *
 * @property array $onStartup
 * @package   Rdurica\Core\Presenter
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
trait RequireLoggedUser
{
    /**
     * Check if user is logged in. If not redirect to Sign:in
     *
     * @return void
     */
    public function injectRequireLoggedUser(): void
    {
        $this->onStartup[] = function () {
            if (!$this->getUser()->isLoggedIn()) {
                $this->redirect('Sign:in');
            }
        };
    }
}