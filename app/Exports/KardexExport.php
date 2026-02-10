<?php

namespace App\Exports;

use App\Models\ArticuloRequerimientoPersonal;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class KardexExport implements FromQuery
{
    use Exportable;
  

    public function query()
    {
        return ArticuloRequerimientoPersonal::query();
    }
}
