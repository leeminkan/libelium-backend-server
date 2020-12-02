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
        error_log(Carbon::parse($row[4]));
        return new DataCollection([
           'waspmote_id'    => $row[1],
           'sensor_key' => $row[2],
           'value' => $row[3],
           'created_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[4]),
           'updated_at' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row[5]),
        ]);
    }
}