<?php

namespace App\Exports;

use App\Models\TagView;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StatisticTagExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, ShouldQueue
{
    use Queueable;

    protected $type;

    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        return $this->getTagsByDay($this->type);
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
            __('custom.number_of_views'),
            __('custom.Created at'),
            __('custom.Update at'),
        ];
    }

    /**
     * Mapping data.
     *
     * @param $tag_view
     * @return array
     */
    public function map($tag_view): array
    {
        return [
           '#' . $tag_view->tags()->first()->en_name,
           '#' . $tag_view->tags()->first()->vi_name,
            $tag_view->count_views,
            checkLanguageWithDay($tag_view->created_at),
            checkLanguageWithDay($tag_view->updated_at)
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

    private function getTagsByDay($type) {
        if ($type == 'year') return TagView::countTagViews()->getThisMonth()->get();
        if ($type == 'month') return TagView::countTagViews()->getThisYear()->get();
        return TagView::countTagViews()->get();
    }
}
