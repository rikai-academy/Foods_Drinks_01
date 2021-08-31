<?php

namespace App\Exports;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize, ShouldQueue
{
    use Queueable;
    
    protected $type;
    
    public function __construct($type)
    {
        $this->type = $type;
    }

    public function collection()
    {
        return $this->getUsersByDay($this->type);
    }

    /**
     * Set header columns.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            __('custom.ID User'),
            __('custom.User Name'),
            __('custom.Gender'),
            __('custom.Date Of Birth'),
            __('custom.number_phone'),
            __('custom.email'),
            __('custom.address'),
            __('custom.Created at'),
            __('custom.Status'),
        ];
    }

    /**
     * Mapping data.
     *
     * @param $user
     * @return array
     */
    public function map($user): array
    {
        return [
            $user->id,
            $user->name,
            checkGenderUserDefault($user->gender),
            $user->date_of_birth,
            "84" . $user->phone,
            $user->email,
            $user->address,
            checkLanguageWithDay($user->created_at),
            checkStatus($user->status),
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

    private function getUsersByDay($type) {
        if ($type == 'year') return User::getThisYear()->get();
        if ($type == 'month') return User::getThisMonth()->get();
        return User::byRole(UserRole::getKey(1))->get();
    }
}
