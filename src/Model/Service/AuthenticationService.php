<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Service;

use Nette\Http\Session;
use Nette\Http\SessionSection;
use Nette\Security\Authenticator;
use Nette\Security\Passwords;
use Rdurica\Core\Exception\Authentication\InvalidPasswordException;
use Rdurica\Core\Exception\Authentication\UserIsDisabledException;
use Rdurica\Core\Exception\Authentication\UserNotFoundException;
use Rdurica\Core\Model\Entity\CoreIdentity;
use Rdurica\Core\Model\Manager\UserManager;
use Rdurica\Core\Model\Manager\UserRoleManager;

/**
 * AuthenticationService for user management and authentication.
 *
 * @package   Rdurica\Core\Service
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AuthenticationService implements Authenticator
{
    /** @var string Session section. */
    private const SESSION_SECTION_ACL = 'core_acl';

    /** @var string Session subsection. */
    private const SECTION_RESOURCES = 'resources';

    /**
     * Constructor.
     *
     * @param AclService      $aclService
     * @param UserManager     $userManager
     * @param UserRoleManager $roleManager
     * @param Passwords       $passwords
     * @param Session         $session
     */
    public function __construct(
        private readonly AclService $aclService,
        private readonly UserManager $userManager,
        private readonly UserRoleManager $roleManager,
        private readonly Passwords $passwords,
        private readonly Session $session
    ) {
    }

    /**
     * Perform authentication.
     *
     * @param string $user
     * @param string $password
     * @return CoreIdentity
     * @throws InvalidPasswordException
     * @throws UserIsDisabledException
     * @throws UserNotFoundException
     */
    public function authenticate(string $user, string $password): CoreIdentity
    {
        $userRow = $this->userManager->findByUsername($user);
        if (!$userRow) {
            throw new UserNotFoundException($user);
        }

        if (!$this->passwords->verify($password, $userRow->password)) {
            throw new InvalidPasswordException($user);
        }

        if ($userRow->is_enabled === 0) {
            throw new UserIsDisabledException($user);
        }

        $roles = $this->roleManager->findByUserId($userRow->id);
        $resources = $this->aclService->findResourcesAndPrivilegesByRoles(array_values($roles));
        $this->saveUserResourcesAndPrivilegesToSession($resources);

        return new CoreIdentity(
            $userRow->id,
            $userRow->username,
            $userRow->email,
            $roles,
        );
    }

    /**
     * Get resources & privileges from cache.
     *
     * @return array|null
     */
    public function getUserResourcesAndPrivilegesFromSession(): ?array
    {
        return $this->getSessionSection()[self::SECTION_RESOURCES];
    }

    /**
     * Save resources & privileges to cache.
     *
     * @param array $resources
     * @return void
     */
    private function saveUserResourcesAndPrivilegesToSession(array $resources): void
    {
        $this->getSessionSection()[self::SECTION_RESOURCES] = $resources;
    }

    /**
     * Get session section for acl.
     *
     * @return SessionSection
     */
    private function getSessionSection(): SessionSection
    {
        return $this->session->getSection(self::SESSION_SECTION_ACL);
    }
}