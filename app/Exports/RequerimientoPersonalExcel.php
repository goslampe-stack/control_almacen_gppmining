<?php

namespace App\Exports;

use App\Models\Articulo;
use App\Models\ArticuloRequerimientoPersonal;
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

class RequerimientoPersonalExcel implements FromCollection, WithHeadings, WithTitle, WithColumnFormatting, WithStrictNullComparison, WithEvents
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $requerimiento_p_id;

    public function __construct($requerimiento_p_id)
    {
        $this->requerimiento_p_id = $requerimiento_p_id;
    }


    public function collection()
    {
        return ArticuloRequerimientoPersonal::join('articulos', 'articulo_requerimiento_personals.articulos_id', '=', 'articulos.id')
            ->join('tipo_unidads', 'articulos.tipo_unidads_id', '=', 'tipo_unidads.id')
            ->where('articulo_requerimiento_personals.requerimiento_p_id', '=',  $this->requerimiento_p_id)
            ->orderBy('articulos.codigo','asc')
            ->select('articulos.codigo', 'articulos.articulo', 'tipo_unidads.nombre','articulo_requerimiento_personals.cantidad')->get();
    }

    public function headings(): array
    {
        return [

            [
                'Código',
                'Articulo',
                'Tipo Unidad',
                'Cantidad',
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_GENERAL,
            'B' => NumberFormat::FORMAT_GENERAL,
            'C' => NumberFormat::FORMAT_GENERAL,
            'D' => NumberFormat::FORMAT_GENERAL,
        ];
    }


    public function title(): string
    {
        return 'Reporte de requerimiento personal';
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
