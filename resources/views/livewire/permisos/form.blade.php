<div wire:ignore.self class="modal fade" id="theModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card">
            <div class="modal-header bg-primary bg-gradient">
                <h5 class="modal-title">
                    <b>{{ $componentName }}</b> | {{ $selected_id > 0 ? 'EDITAR' : 'CREAR' }}
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body bg-gradient" style="background-color:#6f42c1">

                <div class="row">
                    <div class="col-sm-12">
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">
                                    <span class="fas fa-edit">

                                    </span>
                                </span>
                            </div>
                            <input type="text" wire:model.lazy="permissionName" class="form-control"
                                placeholder="ej: Category_Index" maxlength="255">
                        </div>
                        @error('permissionName')
                            <span class="text-danger er">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

            </div>
            <div class="modal-footer bg-primary bg-gradient">
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
                    data-dismiss="modal">CERRAR</button>
                @if ($selected_id < 1)
                    <button type="button" wire:click.prevent="CreatePermission()"
                        class="btn btn-dark close-modal">GUARDAR</button>
                @else
                    <button type="button" wire:click.prevent="UpdatePermission()"
                        class="btn btn-dark close-modal">ACTUALIZAR</button>
                @endif
            </div>
        </div>
    </div>
</div>
