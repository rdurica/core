<?php

declare(strict_types=1);

namespace PhpUnit\Service\AclService;

use Mockery;
use Mockery\MockInterface;
use Rdurica\Core\Model\Manager\AclManager;
use Rdurica\Core\Model\Service\AclService;

/**
 * AclServiceBuilder.
 *
 * @package   PhpUnit\AclService
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
final class AclServiceBuilder
{
    /** @var AclManager|null Mock. */
    private ?AclManager $aclManagerMock = null;

    /**
     * Create builder.
     *
     * @return AclServiceBuilder
     */
    public static function create(): AclServiceBuilder
    {
        return new self();
    }

    /**
     * Set AclManager.
     *
     * @param AclManager|null $aclManagerMock
     * @return $this
     */
    public function setAclManagerMock(?AclManager $aclManagerMock): AclServiceBuilder
    {
        $this->aclManagerMock = $aclManagerMock;
        return $this;
    }

    /**
     * Build service mock.
     *
     * @return MockInterface|AclService
     */
    public function build(): MockInterface|AclService
    {
        $this->aclManagerMock ??= Mockery::mock(AclManager::class);

        return Mockery::mock(AclService::class, [
            $this->aclManagerMock
        ])->makePartial();
    }
}