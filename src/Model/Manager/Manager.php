<?php

declare(strict_types=1);

namespace Rdurica\Core\Model;

use Nette\Database\Explorer;
use Nette\Database\Table\ActiveRow;
use Nette\Database\Table\Selection;
use Traversable;

/**
 * Manager.
 *
 * @package   Rdurica\Core\Model
 * @author    Robert Durica <r.durica@gmail.com>
 * @copyright Copyright (c) 2023, Robert Durica
 */
abstract class Manager
{
    /**
     * Constructor.
     *
     * @param Explorer $db
     */
    public function __construct(protected Explorer $db)
    {
    }

    /**
     * Get table name for manager selections.
     *
     * @return string
     */
    abstract protected function getTableName(): string;

    /**
     * Insert data into database.
     *
     * @param array|Traversable|Selection $data [$column => $value]|\Traversable|Selection for INSERT ... SELECT
     * @return ActiveRow|int|bool Returns ActiveRow or number of affected rows for Selection or table without primary key
     */
    final public function insert(iterable $data): ActiveRow|bool|int
    {
        return $this->find()->insert($data);
    }

    /**
     * Get table for manager.
     *
     * @return Selection
     */
    final public function find(): Selection
    {
        return $this->db->table($this->getTableName());
    }

    /**
     * Get table row with id.
     *
     * @param int $id
     * @return ActiveRow|null
     */
    final public function findById(int $id): ?ActiveRow
    {
        return $this->db->table($this->getTableName())->get($id);
    }
}
