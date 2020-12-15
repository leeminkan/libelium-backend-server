<?php

namespace App\Imports;

use App\Models\DataCollection;
use Maatwebsite\Excel\Concerns\ToModel;
use Carbon\Carbon;

class DataCollectionsImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return DataCollection|null
     */
    public function model(array $row)
    {
        return new DataCollection([
           'waspmote_id'    => $row[1],
           'sensor_key' => $row[2],
           'value' => $row[3],
           'created_at' => $this->transformDateTime($row[4]),
           'updated_at' => $this->transformDateTime($row[5]),
           'for_algorithm' => isset($row[6]) ? true : false,
        ]);
    }

    private function transformDateTime(string $value, string $format = 'Y-m-d H:i:s')
    {
        try {
                return Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($value))->format($format);
            } catch (\ErrorException $e) {
                return Carbon::parse($value)->format($format);
            }
    }
}