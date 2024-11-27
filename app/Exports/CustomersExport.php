<?php

namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    /**
     * Return a collection of customers to be exported.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Customer::all();  // You can modify this to include specific fields or conditions
    }

    /**
     * Return the headings for the exported file.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID', 'Name', 'Email', 'Mobile', 'Created At', 'Updated At',
        ];
    }
}
