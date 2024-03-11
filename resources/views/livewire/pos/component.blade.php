<div>
    <style></style>
    <div class="row layout-top-spacing">
        {{-- Columna de la Izquierda --}}
        <div class="col-sm-12 col-md-8">
            {{-- DETALLES --}}
            @can('Products_Shop')
                @include('livewire.pos.partials.detail')
            @endcan
        </div>
        {{-- Columna de la Derecha --}}
        <div class="col-sm-12 col-md-4">
            {{-- TOTAL --}}
            @can('Products_Shop')
                @include('livewire.pos.partials.total')
            @endcan
            {{-- DENOMINACIONES --}}
            @can('Products_Shop')
                @include('livewire.pos.partials.coins')
            @endcan
        </div>
    </div>
    <livewire:modal-search />
</div>

<script src="{{ asset('js/keypress.js') }}"></script>
<script src="{{ asset('js/onscan.js') }}"></script>
<script>
try {
    onScan.attachTo(document, {
        suffixKeyCodes: [13], // enter-key expected at the end of a scan
        onScan: function(barcode) {
            console.log(barcode)
            window.livewire.emit('scan-code', barcode)
        },
        onScanError: function(e){
            console.log(e);
        }
    });
    console.log('Scanner ready!');
} catch (e) {
    console.log('Error de lectura', e);
}
</script>
@include('livewire.pos.scripts.shortcuts')
@include('livewire.pos.scripts.events')
@include('livewire.pos.scripts.general')

