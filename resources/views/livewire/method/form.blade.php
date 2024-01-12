@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombre</label>
            <input type="text" wire:model.lazy="name" class="form-control" placeholder="ej: Nombre">
            @error('name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Entidad financiera</label>
            <input type="text" wire:model.lazy="financial_entity" class="form-control" placeholder="ej: Banco ...">
            @error('financial_entity')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Numero de cuenta</label>
            <input type="text" wire:model.lazy="account_number" class="form-control" placeholder="ej: 100000000000001">
            @error('account_number')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Beneficiario</label>
            <input type="text" wire:model.lazy="beneficiary" class="form-control" placeholder="ej: Nombres Apellidos">
            @error('beneficiary')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>C.I.</label>
            <input type="text" wire:model.lazy="ci" class="form-control" placeholder="ej: 654321">
            @error('ci')
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
