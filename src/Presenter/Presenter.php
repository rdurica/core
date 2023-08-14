<?php

declare(strict_types=1);

namespace Rdurica\Core\Presenter;

use Nette\Application\AbortException;
use Nette\Application\UI\Presenter as NettePresenter;

/**
 * Presenter.
 *
 * @package   Rdurica\Core\Presenter
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
abstract class Presenter extends NettePresenter
{
    /**
     * Log-out user and clear identity.
     *
     * @return void
     * @throws AbortException
     */
    public function handleSignOut(): void
    {
        if (!$this->getUser()->isLoggedIn()) {
            return;
        }

        $this->getUser()->logout(true);
        $this->getPresenter()->redirect('Sign:in');
    }
}
