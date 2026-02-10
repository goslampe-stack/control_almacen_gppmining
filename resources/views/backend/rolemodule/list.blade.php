@extends('backend.layouts.master')
@section('title')
    Rol Por Modulo
@endsection
@section('css')

@endsection
<!-- page content -->
@section('content')


    <div class="col-span-12 mt-8">
        <!-- END: Top Bar -->
        <div class="intro-y flex flex-col sm:flex-row items-center mt-0">
            <h2 class="text-lg font-medium mr-auto">
                Lista de Rol Por Modulo
            </h2>
          {{--   <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                <a class="button button--lg  rounded-full flex text-white bg-theme-1 shadow-md "
                    href="{{ route('role.create') }}"><i data-feather="user-plus" class="mx-auto mr-2"></i> Nuevo rol</a>

            </div> --}}
        </div>
        <!-- BEGIN: Datatable -->
        <div class="intro-y datatable-wrapper box p-5 mt-5">
            <table class="table table-report table-report--bordered display datatable w-full">
                <thead>
                    <tr>
                        <th class="border-b-2 text-center whitespace-no-wrap">ROL</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">FECHA CREADO</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">FECHA ACTUALIZADO</th>
                        <th class="border-b-2 text-center whitespace-no-wrap">ACCIÒN</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($role as $m)
                        <tr>
                            <td class="border-b">
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $m->name }}</div>
                            </td>

                            <td class="border-b">
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $m->created_at }}</div>
                            </td>
                            <td class="border-b">
                                <div class="text-gray-600 text-xs whitespace-no-wrap">{{ $m->updated_at }}</div>
                            </td>
                            <td class="border-b w-5">
                                <div class="flex sm:justify-center items-center">
                                    <a class="button box text-white bg-theme-3 mr-2 flex items-center ml-auto sm:ml-0"
                                        href="{{ route('rolemoduleasign.edit', $m->id) }}">
                                        <i class="w-4 h-4 mr-2" data-feather="eye"></i>
                                        Asignar Modulos </a>
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
    <script>

    </script>
@endsection
