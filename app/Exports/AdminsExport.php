<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AdminsExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::with('roles')->get();
    }

    /**
     * Define the headings for the export.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Sl. No.',
            'Name',
            'Email',
            'Role'
        ];
    }

    /**
     * Map the data to be exported.
     *
     * @param  \App\Models\User  $user
     * @return array
     */
    public function map($user): array
    {
        // Get the user's roles as a comma-separated string
        $roles = $user->roles->pluck('name')->implode(', ');

        return [
            $user->id,                       // Sl. No.
            $user->name,                     // Name
            $user->email,                    // Email
            $roles                           // Role(s)
        ];
    }
}
