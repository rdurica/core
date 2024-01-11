<?php declare(strict_types=1);

namespace Rdurica\Core\Exception\Authentication;

/**
 * Occur when user was but password does not match.
 *
 * @package   Rdurica\Core\Exception\Authentication
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-19
 */
final class InvalidPasswordException extends AuthenticationException
{
    /**
     * Constructor.
     *
     * @param string $username
     */
    public function __construct(string $username)
    {
        $message = sprintf('Invalid password for user %s', $username);

        parent::__construct($message);
    }
}
