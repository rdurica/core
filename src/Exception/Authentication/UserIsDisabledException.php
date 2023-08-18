<?php

declare(strict_types=1);

namespace Rdurica\Core\Exception\Authentication;

/**
 * Occur when user was found but is not enabled.
 *
 * @package   Rdurica\Core\Exception\Authentication
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class UserIsDisabledException extends AuthenticationException
{
    /** @var string Username which triggers exception. */
    public string $username;

    /**
     * Constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $message = sprintf('User %s is disabled', $username);
        parent::__construct($message);

        $this->username = $username;
    }
}
