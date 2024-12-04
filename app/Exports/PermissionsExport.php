<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Spatie\Permission\Models\Permission as SpatiePermission;

class PermissionsExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // Fetch all permissions
        return SpatiePermission::all();
    }

    /**
    * Define the headings for the CSV file.
    *
    * @return array
    */
    public function headings(): array
    {
        return [
            'id',
            'Permission Name',
            'Guard Name',
            'Group Name',
        ];
    }
}
