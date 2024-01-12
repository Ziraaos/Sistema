@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Nombres">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Departamento</label>
            <input type="text" wire:model.lazy="state" class="form-control" placeholder="ej: La Paz">
            @error('state')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Ciudad/Comunidad</label>
            <input type="text" wire:model.lazy="city" class="form-control" placeholder="ej: El Alto">
            @error('city')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Notas</label>
            <input type="text" wire:model.lazy="note" class="form-control" placeholder="ej: Notas">
            @error('note')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
