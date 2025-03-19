<?php

namespace App\DataTables;

use App\Models\KategoriModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class KategoriDataTable extends DataTable
{
    // -- ------------------------------------- *jobsheet 05* ------------------------------------- --

    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            // ->addColumn('action', 'kategori.action')

            // -- TUGAS(3) --
            ->addColumn('action', function($row) {
                $edit = route('kategori.edit', $row->kategori_id);
                // -- TUGAS(4) --
                $delete = route('kategori.destroy', $row->kategori_id);

                return 
                    '
                    <div style="display: flex; gap: 5px;">
                        <form action="' . $edit . '" method="GET" class="w-100">
                            <button type="submit" class="btn btn-warning btn-sm text-white d-flex align-items-center justify-content-center gap-1 w-100" style="min-width: 80px;">
                                <i class="fas fa-edit"></i> <b>Edit</b>
                            </button>
                        </form>
                        <form action="' . $delete . '" method="POST" onsubmit="return confirm(\'Yakin ingin hapus?\');" class="w-100">
                            ' . csrf_field() . method_field('DELETE') . '
                            <button type="submit" class="btn btn-danger btn-sm text-white d-flex align-items-center justify-content-center gap-1 w-100" style="min-width: 80px;">
                                <i class="fas fa-trash"></i> <b>Hapus</b>
                            </button>
                        </form>
                    </div>
                    ';
            })
            ->rawColumns(['action'])
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KategoriModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('kategori-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('excel'),
                        Button::make('csv'),
                        Button::make('pdf'),
                        Button::make('print'),
                        Button::make('reset'),
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            // Column::computed('action')
            //       ->exportable(false)
            //       ->printable(false)
            //       ->width(60)
            //       ->addClass('text-center'),
            Column::make('kategori_id'),
            Column::make('kode_kategori'),
            Column::make('nama_kategori'),
            Column::make('created_at'),
            Column::make('updated_at'),

            // -- TUGAS(3) --
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(150)
                ->addClass('text-center')
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Kategori_' . date('YmdHis');
    }
}