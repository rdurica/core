<?php declare(strict_types=1);

namespace Rdurica\Core\Component;

use Ublaboo\DataGrid\DataGrid as UblabooDataGrid;

/**
 * DataGrid.
 *
 * @package   src\Component
 * @copyright Copyright (c) 2024, Robert Durica
 * @since     2024-02-26
 */
final class DataGrid extends UblabooDataGrid
{
    public function getOriginalTemplateFile(): string
    {
        return __DIR__ . '/../Templates/Datagrid/datagrid.latte';
    }
}
