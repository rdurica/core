<?php declare(strict_types=1);

namespace Rdurica\Core\Exception\Authentication;

/**
 * Occur when user was not found.
 *
 * @package   Rdurica\Core\Exception\Authentication
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-01-12
 */
final class UserNotFoundException extends AuthenticationException
{
    /**
     * Constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $message = sprintf('User %s not found', $username);

        parent::__construct($message);
    }
}
