@extends('backend.layouts.master')
@section('title')
Permisos
@endsection
@section('css')

@endsection
<!-- page content -->
@section('content')

<div class="col-span-12 mt-8">
    <!-- END: Top Bar -->
    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Lista Premisos
        </h2>
        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
           {{--  <button class="button text-white bg-theme-1 shadow-md mr-2">Nuevo Premiso</button>
            <div class="dropdown relative ml-auto sm:ml-0">
                <button class="dropdown-toggle button px-2 box text-gray-700">
                    <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-feather="plus"></i> </span>
                </button>
                <div class="dropdown-box mt-10 absolute w-40 top-0 right-0 z-20">
                    <div class="dropdown-box__content box p-2">
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="file-plus" class="w-4 h-4 mr-2"></i> New Category </a>
                        <a href="" class="flex items-center block p-2 transition duration-300 ease-in-out bg-white hover:bg-gray-200 rounded-md"> <i data-feather="users" class="w-4 h-4 mr-2"></i> New Group </a>
                    </div>
                </div>
            </div> --}}
        </div>
    </div>
    <!-- BEGIN: Datatable -->
    <div class="intro-y datatable-wrapper box p-5 mt-5">
        <table class="table table-report table-report--bordered display datatable w-full">
            <thead>
                <tr>
                    <th class="border-b-2 whitespace-no-wrap">S.N.</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">MODULO</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">URL MODULO</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">FECHA CREADO</th>
                    <th class="border-b-2 text-center whitespace-no-wrap">FECHA ACTUALIZADO</th>

                    <th class="border-b-2 text-center whitespace-no-wrap">ACCION</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 1 ?>
                @foreach($permission as $m)
                <tr>
                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{$i++}}</div>
                    </td>
                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{$m->name}}</div>
                    </td>
                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{$m->permission_key}}</div>
                    </td>
                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{$m->created_at}}</div>
                    </td>
                    <td class="border-b">
                        <div class="text-gray-600 text-xs whitespace-no-wrap">{{$m->updated_at}}</div>
                    </td>
                    <td class="border-b w-5" >
                        <div class="flex sm:justify-center items-center">
                            <a class="flex items-center mr-3" href="{{route('module.edit',$m->id)}}"> <i data-feather="check-square" class="w-4 h-4 mr-1"></i> Editar </a>

                            <a class="flex items-center text-theme-6 btn-delete" title="Eliminar" data-url="#" rel="tooltip" href=""> <i data-feather="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>

                          
                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
    <!-- END: Datatable -->
</div>

<!-- /page content -->
@endsection

@section('script')

@endsection