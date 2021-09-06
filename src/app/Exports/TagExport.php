<?php

namespace App\Exports;

use App\Models\Tag;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class TagExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, ShouldQueue
{
    use Queueable;
    
    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }
    
    public function collection()
    {
        return $this->getTagByDay($this->type);
    }

    /**
     * Set header columns.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            __('custom.tag_en_name'),
            __('custom.tag_vi_name'),
            __('custom.tag_count_tags'),
            __('custom.Created at'),
            __('custom.Update at')
        ];
    }

    /**
     * Mapping data.
     *
     * @param $product
     * @return array
     */
    public function map($tag): array
    {
        return [
            '#' . $tag->en_name,
            '#' . $tag->vi_name,
            $tag->product_tags()->count(),
            checkLanguageWithDay($tag->created_at),
            checkLanguageWithDay($tag->updated_at)
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

    private function getTagByDay($type) {
        if ($type == 'year') return Tag::getThisYear()->get();
        if ($type == 'month') return Tag::getThisMonth()->get();
        return Tag::all();
    }
}
