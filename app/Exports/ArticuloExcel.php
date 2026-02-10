<?php

namespace App\Exports;

use App\Models\Articulo;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ArticuloExcel implements FromCollection, WithHeadings, WithTitle, WithColumnFormatting, WithStrictNullComparison, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return Articulo::join('tipo_unidads', 'articulos.tipo_unidads_id', '=', 'tipo_unidads.id')
            ->select('articulos.codigo', 'articulos.articulo', 'tipo_unidads.nombre')->get();
    }

    public function headings(): array
    {
        return [

            [
                'Código',
                'Articulo',
                'Tipo Unidad',
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_GENERAL,
            'B' => NumberFormat::FORMAT_GENERAL,
            'C' => NumberFormat::FORMAT_GENERAL,
        ];
    }


    public function title(): string
    {
        return 'Reporte de artículos';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->getSheet()->autoSize();
                $event->getSheet()->getDelegate()->getStyle('A1:C11')
                    ->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
            }
        ];
    }
}
