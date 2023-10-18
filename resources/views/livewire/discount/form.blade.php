@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label >Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: 2 días">
            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Días sin servicio</label>
            <input type="text" wire:model.lazy="days_dwntm" class="form-control" placeholder="ej: 2"> días
            @error('days_dwntm') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
