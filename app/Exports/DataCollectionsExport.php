<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;


class DataCollectionsExport implements FromCollection,WithHeadings,WithMapping
{
 
    public function __construct($collection)
    {
        $this->collection = $collection;
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return $this->collection;
    }

    /**
     * Returns headers for report
     * @return array
     */
    public function headings(): array {
        return [
            'ID',
            'Waspmote ID',
            'Device Name',
            'Sensor Key',
            'Value',
            'Created At',
            'Updated At',
        ];
    }
 
    public function map($data): array {
        return [
            $data->id,
            $data->waspmote_id,
            $data->device ? $data->device->name : null,
            $data->sensor ? $data->sensor->key : null,
            $data->value,
            $data->created_at,
            $data->updated_at,
        ];
    }

}
