<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Service;

use Nette\Security\Authorizator;
use Rdurica\Core\Constant\Role;
use Rdurica\Core\Enum\Privileges;

use function array_key_exists;

/**
 * AuthorizationService.
 *
 * @package   Rdurica\Core\Model\Service
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-08-13
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
        $hasAllPrivileges = array_key_exists(Privileges::ALL->value, $resources[$resource]);
        if ($hasPrivilege || $hasAllPrivileges) {
            return true;
        }

        return false;
    }
}
