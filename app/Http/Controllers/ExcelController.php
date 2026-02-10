<?php

namespace App\Http\Controllers;

use App\Exports\ArticuloExcel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class ExcelController extends Controller
{
   public function exportExcel(){ 
     
       /* return Excel::download(new ArticuloExcel,'articulo-excel.xlsx'); */
   }
   public function requerimientoPersonalExcel($medelo_id){ 
    
      /*  return Excel::download(new RequerimientoPersonalExcel($medelo_id),'requerimiento-personal-excel.xlsx'); */
   }
}
