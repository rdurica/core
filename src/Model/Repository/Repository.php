<?php declare(strict_types=1);

namespace Rdurica\Core\Model\Repository;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Nette\Database\UniqueConstraintViolationException;
use Traversable;

/**
 * Repository.
 *
 * @package   Rdurica\Core\Model\Repository
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-01-24
 */
abstract class Repository
{
    /**
     * Constructor.
     *
     * @param Explorer    $explorer
     * @param Transaction $transaction
     */
    public function __construct(private Explorer $explorer, protected Transaction $transaction)
    {
    }

    /**
     * Get table of active repository. Table is used for all queries.
     *
     * @return string
     */
    abstract protected function getTable(): string;

    /**
     * Select from table. When no columns provided select all.
     *
     * @param string|null ...$columns
     *
     * @return Selection
     */
    final protected function select(?string ...$columns): Selection
    {
        $selection = $this->explorer->table($this->getTable());

        if (!$columns) {
            return $selection;
        }

        return $selection->select(self::selectColumns($columns));
    }

    /**
     * Insert data into database.
     *
     * @param array<mixed>|Traversable<mixed>|Selection $data
     *
     * @return ActiveRow|int|bool|array<mixed>
     * @throws UniqueConstraintViolationException
     */
    final public function insert(iterable $data): ActiveRow|bool|int|array
    {
        return $this->select()->insert($data);
    }

    /**
     * Find record based on id.
     *
     * @param int $id
     *
     * @return ActiveRow|null
     */
    final public function findById(int $id): ?ActiveRow
    {
        return $this->explorer->table($this->getTable())->get($id);
    }

    /**
     * Convert columns to select string.
     *
     * @param array<int|string, string|null> $columns
     *
     * @return string
     */
    private static function selectColumns(array $columns): string
    {
        return implode(', ', $columns);
    }
}
