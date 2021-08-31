<?php

namespace App\Exports;

use App\Models\OrderProduct;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatisticProductExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, ShouldQueue
{
    use Queueable;
    
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
    
    public function collection()
    {
        return $this->getOrderProductsByDay($this->type);
    }

    /**
     * Set header columns.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            __('custom.Product Name'),
            __('custom.Category'),
            __('custom.Price'),
            __('custom.total_quantity'),
            __('custom.Order Date'),
            __('custom.Status'),
        ];
    }

    /**
     * Mapping data.
     *
     * @param $product
     * @return array
     */
    public function map($product): array
    {
        return [
            $product->products()->first()->name,
            $product->products()->first()->categories()->first()->name,
            formatPrice($product->products()->first()->price),
            $product->count_products,
            checkLanguageWithDay($product->created_at),
            checkStatus($product->products()->first()->status)
        ];
    }

    /**
     * Style the first row as bold text.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }

    private function getOrderProductsByDay($type) {
        if ($type == 'year') return OrderProduct::getMostProducts()->getThisMonth()->get();
        if ($type == 'month') return OrderProduct::getMostProducts()->getThisYear()->get();
        return OrderProduct::getMostProducts()->get();
    }
}
