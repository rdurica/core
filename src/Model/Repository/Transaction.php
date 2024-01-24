<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Repository;

use Nette\Database\Explorer;

/**
 * Transaction.
 *
 * @package   src\Model\Repository
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-01-24
 */
final class Transaction
{
    /**
     * Constructor.
     *
     * @param Explorer $explorer
     */
    public function __construct(private Explorer $explorer)
    {
    }

    public function begin(): void
    {
        $this->explorer->beginTransaction();
    }

    public function commit(): void
    {
        $this->explorer->commit();
    }

    public function rollBack(): void
    {
        $this->explorer->rollBack();
    }
}
