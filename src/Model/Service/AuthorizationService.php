<?php

declare(strict_types=1);

namespace Rdurica\Core\Model\Service;

use Nette\Security\Authorizator;
use Rdurica\Core\Constant\Privileges;
use Rdurica\Core\Constant\Role;

/**
 * AuthorizationService (ACL)
 *
 * @package   Rdurica\Core\Model\Service
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AuthorizationService implements Authorizator
{
    /**
     * Constructor.
     *
     * @param AuthenticationService $authenticationService
     */
    public function __construct(private AuthenticationService $authenticationService)
    {
    }

    /** @inheritDoc */
    public function isAllowed($role, $resource, $privilege): bool
    {

        if ($role === Role::GLOBAL_ADMIN) {
            return true;
        }

        $resources = $this->authenticationService->getUserResourcesAndPrivilegesFromSession();

        // User does not have resource
        if (empty($resources[$resource])) {
            return false;
        }

        // User have exact privilege or can do all
        $hasPrivilege = array_key_exists($privilege, $resources[$resource]);
        $hasAllPrivileges = array_key_exists(Privileges::ALL, $resources[$resource]);
        if ($hasPrivilege || $hasAllPrivileges) {
            return true;
        }

        return false;
    }
}
