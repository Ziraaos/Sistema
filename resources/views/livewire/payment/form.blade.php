@include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label>Lugar</label>
            <select wire:model='locationId' class="form-control">
                <option value="Elegir">Elegir</option>
                @foreach ($locations as $location)
                    <option value="{{ $location->id }}">{{ $location->name }}</option>
                @endforeach
            </select>
            @error('locationId') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Mes</label>
            <input type="month" wire:model.lazy="date_serv" class="form-control">
            @error('date_serv') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
    <div class="col-sm-12 col-md-4">
        <div class="form-group">
            <label >Días de descuento</label>
            <input type="number" wire:model.lazy="days_g" class="form-control" placeholder="ej: 0">
            @error('days_g') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
    </div>
</div>

@include('common.modalFooter')
