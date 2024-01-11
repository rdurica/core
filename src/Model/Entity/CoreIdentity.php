<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Entity;

use Nette\Security\IIdentity;

/**
 * CoreIdentity.
 *
 * @package   Rdurica\Core\Model\Entity
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2023-08-13
 */
final readonly class CoreIdentity implements IIdentity
{
    /**
     * Constructor.
     *
     * @param int                $id       User id.
     * @param string             $username Username.
     * @param string             $email    Email.
     * @param array<string, int> $roles    User roles.
     */
    public function __construct(
        private int $id,
        private string $username,
        private string $email,
        private array $roles,
    ) {
    }

    /** @inheritDoc */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /** @inheritDoc */
    public function getRoles(): array
    {
        return array_keys($this->roles);
    }
}
