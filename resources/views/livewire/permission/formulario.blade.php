<div class="content-wrapper">
    <section class="content mt-3">
        <div class="container-fluid">


            <div class="row">

                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="txt_correoElectronico" style="margin-bottom: 0px;">Obtener hasta</label><br>
                            <span class="small">Seleccione obtener hasta </span>
                            <select class="form-control apl-input-border" wire:model="perPage">
                                <option value="">Seleccione estado </option>
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                                <option value="30">30</option>
                                <option value="50">50</option>
                                <option value="100">100</option>

                            </select>
                            @error('estado')<span class="text-danger">{{$message}}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="col-md-12">

                    <div class="card apl-border">

                        <div class="row p-2">

                            <div class="col-md-3">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text apl-input-search-icon"><i class="fas fa-search"></i></div>
                                    </div>
                                    <input type="text" class="form-control apl-input-border apl-input-search" id="apl-table-buscar" placeholder="Buscar permiso" wire:model.debounce.800ms="search">
                                </div>


                            </div>

                            <div class="col-md-9">
                                <button type="button" class="btn btn-primary mr-2 float-right " wire:click="actualizar" wire:loading.attr="disabled" title="Actualizar">
                                    <div wire:loading.delay>
                                        <i class="fas fa-spinner fa-spin mr-2"></i>
                                    </div> Actualizar
                                </button>
                            </div>
                        </div>

                        <form>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="apl-table" class="table table-hover">
                                        <thead>
                                            <tr class="apl-table-header-tr">
                                                <!--<td class="d-none"></td>-->
                                                <td width="3%"></td>
                                                <td>Articulos</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($permission->isNotEmpty())
                                            @foreach ($permission as $item)
                                            <tr class="apl-table-body-tr pointer">
                                                <!--<td class="d-none"></td>-->
                                                <td>
                                                    <input type="checkbox" class="apl-border-checkbox" style="padding: .7rem;" wire:click="actualizar" value="{{ $item->id }}" id="{{ $item->id }}" name="{{ $item->id }}" wire:model="selectedPermisosRole">
                                                </td>
                                                <td wire:click="editar_ARP({{ $item->id}})">{{ $item->name }}</td>
                                            </tr>
                                            @endforeach
                                            @else
                                            <tr>
                                                <td colspan="6" class="text-center">
                                                    <center><img src="{{ asset('dist/img/empty.png') }}" alt="Imagen" width="350"></center>
                                                    <p class="text-muted">No hay resultados</p>
                                                </td>
                                            </tr>
                                            @endif
                                        </tbody>
                                    </table>
                                    {{ $permission->links()}}
                                </div>
                            </div>
                        </form>


                    </div>

                </div>
            </div>





            <div>
                <p>{{count($selectedPermisosRole)}}</p>
            </div>
        </div>
    </section>
</div>