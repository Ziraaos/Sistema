<div wire:ignore.self class="modal fade" id="modalPaids" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content card">
            <div class="modal-header bg-primary bg-gradient">
                <h5 class="modal-title text-white">
                    <b>Pagos pendientes cliente: {{ $namec }}</b>
                </h5>
                <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            </div>
            <div class="modal-body bg-gradient" style="background-color:#6f42c1">
                <label>Detalles de pagos pendientes</label>
                <ul>
                    @foreach ($debtData as $debt)
                        <li>
                            Mes: {{ \Carbon\Carbon::parse($debt['mes'])->format('m-Y') }}
                            Monto: {{ $debt['monto'] }} bs.
                        </li>
                    @endforeach
                </ul>
                <div class="row">
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="amountPaid">Monto Pagado:</label>
                            <input type="number" id="amountPaid" wire:model="amountPaid"
                                wire:change="calculateRemainingDebt" class="form-control">
                        </div>
                    </div>
                    <!-- Mostrar el restante de la deuda -->
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label for="remainingDebt">Restante de la Deuda:</label>
                            <input type="number" id="remainingDebt" wire:model="remainingDebt" class="form-control"
                                readonly>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Metodo de pago</label>
                            <select wire:model='method' class="form-control">
                                <option value="Elegir">Elegir</option>
                                @foreach ($methods as $method)
                                    <option value="{{ $method->id }}">{{ $method->name }}</option>
                                @endforeach
                            </select>
                            @error('method')
                                <span class="text-danger er">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    <div class="col-sm-12 col-md-6">
                        <div class="form-group">
                            <label>Comprobante de pago</label>
                            <div class="form-group custom-file">
                                <input type="file" class="custom-file-input form-control" wire:model="image"
                                    accept="image/x-png, image/gif, image/jpeg">
                                <label class="custom-file-label">Imágen {{ $image }}</label>
                                @error('image')
                                    <span class="text-danger er">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer bg-primary bg-gradient">
                <button type="submit" wire:click.prevent="makePayment()" class="btn btn-dark">Realizar Pago</button>
                {{-- <button type="button" wire:click.prevent="Paid()" class="btn btn-dark close-modal">GUARDAR</button> --}}
                <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info" data-dismiss="modal">CERRAR</button>
            </div>
        </div>
    </div>
</div>
<script>
    document.addEventListener('livewire:load', function() {
        $('#totalPago').on('input', function() {
            calcularDeudas();
        });

        function calcularDeudas() {
            var totalPago = parseFloat($('#totalPago').val()) || 0;
            var deudas = @json($deudas);
            console.log($te);
            // Asegúrate de que 'deudas' sea un arreglo

            if (Array.isArray(deudas) && deudas.length > 0) {
                var saldoRestante = totalPago;

                for (var i = 0; i < deudas.length; i++) {
                    var deudaActual = parseFloat($('#mes' + (i + 1) + 'Deuda').val()) || 0;

                    if (saldoRestante > 0) {
                        var pagoMes = Math.min(deudaActual, saldoRestante);
                        $('#mes' + (i + 1) + 'Deuda').val(pagoMes.toFixed(2));
                        saldoRestante -= pagoMes;
                    }
                }
            }
        }
    });
</script>
