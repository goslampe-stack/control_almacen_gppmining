<div class="modal fade" id="modalFormInactivar" data-backdrop="static">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        <button type="button" title="Cerrar" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>

                <div class="row text-center">
                    <div class="col-md-12">
                        <i class="fas fa-user-alt-slash text-secondary" style="font-size: 5rem;"></i>
                    </div>

                    <div class="col-md-12">
                        <h3 class="mt-3">¿Estás seguro?</h3>
                        <p class="mt-4 mb-5">¿Realmente desea inactivar estos registros? Este proceso no se puede deshacer.
                        </p>
                    </div>

                    <div class="col-md-12">
                        <button type="button" title="Cancelar" class="btn btn-default apl-btn-border mr-1" data-dismiss="modal">Cancelar</button>
                        <button type="button" title="Inactivar" class="btn btn-primary apl-btn-border ml-1" wire:click="inactivarItems" wire:loading.attr="disabled">Inactivar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>