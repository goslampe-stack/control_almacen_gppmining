<x-app-layout>


    <div class="content-wrapper">
        <section class="content mt-3">
            <div class="container-fluid">

                <div class="col-span-12 mt-8">
                    <!-- END: Top Bar -->


                    <div class="row">
                        <div class="col-md-12">
                            <p><b>Asignaci&oacute;n de modulos</b><br><span>Seleccione todos los modulos para el rol seleccionado .</span></p>
                        </div>
                    </div>

                    <!-- BEGIN: Datatable -->


                    <div class="card apl-border">
                     

                        <!-- ===== FILTRAR ===== -->
                        <div class="card-body">
                            <div class="col-sm-12">
                                <form action="{{ route('role-module-asign-actualizar', $roledetails->id) }}" method="post">
                                    {{ csrf_field() }}
                                    @foreach($current as $p)

                                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-1">
                                        <div class="mr-3">{{ $p->name }}</div>
                                        <input type="checkbox" data-target="#basic-accordion" style="width: 30px; height: 30px;" id="{{ $p->name }}" name="asignpermission[]" value="{{ $p->id }}" class="show-code input input--switch border" {{ $p->checked }}>
                                    </div>

                                    @endforeach

                                    <div class="w-full sm:w-auto flex mt-4 sm:mt-5">

                                        <a href="{{ route('role') }}" title="Cancelar" class="btn btn-secondary btn-sm apl-btn-border mr-2" wire:click="cerrarFormulario" wire:loading.attr="disabled">
					<i class="fas fa-times"></i>
                    Cancelar
                                        </a>
                                        <button type="submit" title="Agregar otra unidad" class="btn btn-primary btn-sm apl-btn-border mr-2 float-right" id="btn_save">
					<i class="fas fa-save"></i>
                    Guardar
                                        </button>
                                        < </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- END: Datatable -->
                </div>
            </div>

        </section>

    </div>

</x-app-layout>