<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Spatie\Permission\Models\Role as SpatieRole;

class RoleExport implements FromCollection, WithHeadings, WithMapping
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        // Return all roles
        return SpatieRole::all();
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
            'Name',
            'Permissions',
        ];
    }

    /**
     * Map the data to be exported.
     *
     * @param  Spatie\Permission\Models\Role $role
     * @return array
     */
    public function map($role): array
    {
        // Get the role's permissions as a comma-separated string
        $permissions = $role->permissions->pluck('name')->implode(', ');

        return [
            $role->id,                // Sl. No.
            $role->name,              // Role Name
            $permissions,             // Permissions (comma-separated)
        ];
    }
}
