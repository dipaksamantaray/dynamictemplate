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
        // dd(SpatiePermission::all());
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
            'Sl. No.',
            'Permission Name',
            'Guard Name',
            'Group Name',
        ];
    }

    /**
     * Map the data to be exported.
     *
     * @param  Spatie\Permission\Models\Permission as SpatiePermission $permission
     * @return array
     */
    public function map( $permission): array
    {
        // Get the user's roles as a comma-separated string
       

        return [
            $permission->id,                       // Sl. No.
            $permission->name,                     // Name
            $permission->guard_name,                    // Email
            $permission->group_name,                    // Email
        ];
    }
}
