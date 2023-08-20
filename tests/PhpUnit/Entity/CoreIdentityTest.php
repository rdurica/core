<?php

declare(strict_types=1);

namespace PhpUnit\Entity;

use PHPUnit\Framework\TestCase;
use Rdurica\Core\Model\Entity\CoreIdentity;

/**
 * CoreIdentityTest
 *
 * @package   PhpUnit\Entity
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 * @covers    \Rdurica\Core\Model\Entity\CoreIdentity
 */
final class CoreIdentityTest extends TestCase
{

    /**
     * Test case of class - happy path.
     *
     * @return void
     */
    public function testHappyPath(): void
    {
        $identity = new CoreIdentity(1, 'jdoe', 'jd@example.net', [
            1 => 'role1',
            2 => 'role2',
            8 => 'role8'
        ]);

        self::assertEquals(1, $identity->getId());
        self::assertEquals('jdoe', $identity->getUsername());
        self::assertEquals('jd@example.net', $identity->getEmail());
        self::assertEquals([1, 2, 8], $identity->getRoles());
    }
}