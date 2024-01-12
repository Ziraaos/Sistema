@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nombres</label>
            <input type="text" wire:model.lazy="first_name" class="form-control" placeholder="ej: Nombres">
            @error('first_name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Apellidos</label>
            <input type="text" wire:model.lazy="last_name" class="form-control" placeholder="ej: Apellidos">
            @error('last_name')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Email</label>
            <input type="text" wire:model.lazy="email" class="form-control" placeholder="ej: example@gmail.com">
            @error('email')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Teléfono</label>
            <input type="text" wire:model.lazy="phone" class="form-control" placeholder="ej: 77777777"
                maxlength="10">
            @error('phone')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Ubicación del servicio</label>
            <select wire:model='locationid' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
            @error('locationid') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Servicio / Plan</label>
            <select wire:model='serviceid' class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                @foreach ($services as $service)
                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                @endforeach
            </select>
            @error('serviceid') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descuento</label>
            <select wire:model.lazy="disc" class="form-control">
                <option value="Elegir" selected>Elegir</option>
                <option value="NO">No</option>
                <option value="YES">Si</option>
            </select>
            @error('disc')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Imágen de domicilio</label>
            <input type="file" wire:model="image" accept="image/x-png, image/jpeg, image/gif" class="form-control">
            @error('image')
                <span class="text-danger er">{{ $message }}</span>
            @enderror

        </div>
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado</label>
            <select wire:model="status" class="form-control">
                <option value="Active" selected>Activo</option>
                <option value="Inactive">Inactivo</option>
            </select>
            @error('status')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-12">
        <div class="form-group">
            <label>Dirección</label>
            <input type="text" id="address" wire:model.lazy="address" class="form-control" placeholder="Seleccione del mapa"
                maxlength="10">
            @error('address')
                <span class="text-danger er">{{ $message }}</span>
            @enderror
        </div>
    </div>
    <div class="col-md-12">
        <div wire:ignore id="mapa" style="width: 100%; height: 500px;"></div>
    </div>

</div>

@include('common.modalFooter')
