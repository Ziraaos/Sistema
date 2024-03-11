<div class="card">
    <div class="card-header">{{ $componentName }} | {{ $pageTitle }}
        <div class="card-action">
            <div class="dropdown">
                {{-- <a href="javascript:void();" class="dropdown-toggle dropdown-toggle-nocaret" data-toggle="dropdown">
                    <i class="icon-options"></i>
                </a> --}}
                @can('Customer_Create')
                    <li>
                        <a href="javascript:void(0)" class="tabmenu btn bg-primary" data-toggle="modal"
                            data-target="#theModal">Agregar</a>
                    </li>
                @endcan
            </div>
        </div>
    </div>

    <div class="card-body">
        @can('Customer_Search')
            @include('common.searchbox')
        @endcan
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombres</th>
                        <th scope="col">Apellidos</th>
                        <th scope="col">Email</th>
                        <th scope="col">Celular</th>
                        <th scope="col">Estado</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($customers as $customer)
                        <tr>
                            <th scope="row">{{ $customer->id }}</th>
                            <td>{{ $customer->first_name }}</td>
                            <td>{{ $customer->last_name }}</td>
                            <td>{{ $customer->email }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>
                                <span
                                    class="badge {{ $customer->status == 'Active' ? 'badge-success' : 'badge-danger' }} text-uppercase">{{ $customer->status }}</span>
                            </td>
                            <td>
                                @can('Payment_P')
                                    <button type="button" wire:click.prevent="Paid('{{ $customer->id }}')"
                                        class="btn btn-dark"><i class="fas fa-money"></i>
                                    </button>
                                @endcan
                                @can('Payment_Detail')
                                    <button wire:click.prevent="getDetails({{ $customer->id }})" class="btn btn-dark">
                                        <i class="fas fa-list"></i>
                                    </button>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $customers->links() }}
        </div>
    </div>
    @include('livewire.payment.paid-form')
    @include('livewire.payment.payment-detail')
    @include('livewire.payment.form')
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        window.livewire.on('payment-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-not-added', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-updated', msg => {
            $('#theModal').modal('hide');
            noty(msg)
        });
        window.livewire.on('payment-deleted', msg => {
            noty(msg)
        });
        window.livewire.on('hide-modal', msg => {
            $('#theModal').modal('hide');
        });
        window.livewire.on('show-modal', msg => {
            $('#theModal').modal('show');
        });
        window.livewire.on('hidden.bs.modal', msg => {
            $('.er').css('display', 'none');
        });

        function resetInputFile() {
            $('input[type=file]').val('');
        }

        //eventos
        window.livewire.on('show-modal-detail', Msg => {
            $('#modalDetails').modal('show')
        })

        //paids
        window.livewire.on('show-modal-paid', Msg => {
            $('#modalPaids').modal('show')
        })
        window.livewire.on('hide-modal-paid', msg => {
            $('#modalPaids').modal('hide');
            noty(msg)
        });
    })

    function rePrint(saleId) {
        window.open("print://" + saleId, '_self').close()
    }
</script>
