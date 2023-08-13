<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Service;

use Nette\Database\UniqueConstraintViolationException;
use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\Security\AuthenticationException;
use Nette\Security\Authenticator;
use Nette\Security\Passwords;
use Rdurica\Core\Model\Entity\CoreIdentity;
use Rdurica\Core\Model\Manager\AclManager;
use Rdurica\Core\Model\Manager\UserManager;
use Rdurica\Core\Model\Manager\UserRoleManager;
use SensitiveParameter;

/**
 * UserService for user management and authentication.
 *
 * @package   Rdurica\Core\Service
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class UserService implements Authenticator
{
    /** @var string Session section. */
    private const SESSION_SECTION_ACL = 'core_acl';

    /** @var string Session section key. */
    private const SECTION_ROLES = 'roles';

    private const SECTION_RESOURCES = 'resources';

    /** @var SessionSection Section of session. */
    private SessionSection $sessionSection;

    /**
     * Constructor.
     *
     * @param AclManager      $aclManager
     * @param UserManager     $userManager
     * @param UserRoleManager $roleManager
     * @param Passwords       $passwords
     * @param Session         $session
     */
    public function __construct(
        private readonly AclManager $aclManager,
        private readonly UserManager $userManager,
        private readonly UserRoleManager $roleManager,
        private readonly Passwords $passwords,
        private readonly Session $session
    ) {
        $this->sessionSection = $this->session->getSection(self::SESSION_SECTION_ACL);
    }

    /**
     * Perform authentication.
     *
     * @param string $user
     * @param string $password
     * @return CoreIdentity
     * @throws AuthenticationException
     */
    public function authenticate(string $user, string $password): CoreIdentity
    {
        $user = $this->userManager->findByUsername($user);
        if (!$user) {
            throw new AuthenticationException("User not found.");
        }

        if (!$this->passwords->verify($password, $user->password)) {
            throw new AuthenticationException("Incorrect password.");
        }

        if ($user->is_enabled === 0) {
            throw new AuthenticationException("Account is blocked.");
        }

        $roles = $this->roleManager->findByUserId($user->id);
        $resources = $this->aclManager->findResourcesAndPrivilegesByRoles(array_values($roles));

        $this->sessionSection[self::SECTION_RESOURCES] = $resources;

        return new CoreIdentity(
            $user->id,
            $user->username,
            $user->email,
            $roles,
        );
    }

    public function getLoggedUserResourcesAndPrivileges(): array
    {
        return $this->sessionSection[self::SECTION_RESOURCES];
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