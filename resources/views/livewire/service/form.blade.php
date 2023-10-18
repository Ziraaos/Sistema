@include('common.modalHead')

<div class="row">
    <div class="col-sm-12">
        <div class="form-group">
            <label >Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Plan basico">
            @error('name') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Precio</label>
            <input type="text" wire:model.lazy="price" class="form-control" placeholder="ej: 250"> Bs.
            @error('price') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Velocidad de bajada</label>
            <input type="text" wire:model.lazy="dwn_spd" class="form-control" placeholder="ej: 10000"> Kbps
            @error('dwn_spd') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Velocidad de subida</label>
            <input type="text" wire:model.lazy="up_spd" class="form-control" placeholder="ej: 5000"> Kbps
            @error('up_spd') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
