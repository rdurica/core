<?php declare(strict_types=1);

namespace Rdurica\Core\Exception\Authentication;

/**
 * Occur when user was found but is not enabled.
 *
 * @package   Rdurica\Core\Exception\Authentication
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-19
 */
final class UserIsDisabledException extends AuthenticationException
{
    /**
     * Constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $message = sprintf('User %s is disabled', $username);

        parent::__construct($message);
    }
}
