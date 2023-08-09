<?php

declare(strict_types=1);

namespace Rdurica\Core\Service;

use Nette\Database\UniqueConstraintViolationException;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\Passwords;
use Nette\Security\SimpleIdentity;
use Rdurica\Core\Model\UserManager;
use SensitiveParameter;

/**
 * UserService for user management and authentication.
 *
 * @package   Rdurica\Core\Service
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final readonly class UserService implements Authenticator
{
    /**
     * Constructor.
     *
     * @param UserManager $userManager
     * @param Passwords   $passwords
     */
    public function __construct(private UserManager $userManager, private Passwords $passwords)
    {
    }

    /**
     * Perform authentication.
     *
     * @param string $user
     * @param string $password
     * @return SimpleIdentity
     * @throws AuthenticationException
     */
    public function authenticate(string $user, string $password): SimpleIdentity
    {
        $user = $this->userManager->findByUsername($user);
        if (!$user) {
            throw new AuthenticationException("User not found.");
        }

        if (!$this->passwords->verify($password, $user->password)) {
            throw new AuthenticationException("Incorrect password.");
        }

        if ($user->is_active === 0) {
            throw new AuthenticationException("Account is blocked.");
        }

        return new SimpleIdentity($user->id, roles: [], data: [
            "username" => $user->username,
            "email" => $user->email,
        ]);
    }

    /**
     * Create new user.
     *
     * @param string      $username
     * @param string      $email
     * @param string      $plainPassword
     * @param string|null $firstName
     * @param string|null $lastName
     * @return void
     * @throws UniqueConstraintViolationException
     */
    public function createUser(
        string $username,
        string $email,
        #[SensitiveParameter] string $plainPassword,
        ?string $firstName,
        ?string $lastName
    ): void {
        $user = [
            "username" => $username,
            "password" => $this->passwords->hash($plainPassword),
            "email" => $email,
            "first_name" => $firstName,
            "last_name" => $lastName,
        ];

        $this->userManager->insert($user);
    }
}