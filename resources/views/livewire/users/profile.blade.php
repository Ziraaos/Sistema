<div class="row mt-3">
    <div class="col-lg-4">
        <div class="card profile-card-2">
            <div class="card-img-block">
                @if ($data->image != null)
                    <img src="{{ asset('storage/users/' . $data->image) }}" alt="Card image cap">
                @else
                    <img class="img-fluid" src="https://via.placeholder.com/800x500" alt="Card image cap">
                @endif
            </div>
            <div class="card-body pt-5">
                @if ($data->image != null)
                    <img src="{{ asset('storage/users/' . $data->image) }}" alt="profile-image" class="profile">
                @else
                    <img src="https://via.placeholder.com/110x110" alt="profile-image" class="profile">
                @endif
                <h5 class="card-title">{{ $data->name }}</h5>
            </div>
            <div class="card-body border-top border-light">
                <div class="media align-items-center">

                    <div class="media-body text-left">
                        <p class="mb-0">Gaussion Texture</p>
                        <hr>

                        <ul class="switcher">
                            <li id="theme1"></li>
                            <li id="theme2"></li>
                            <li id="theme3"></li>
                            <li id="theme4"></li>
                            <li id="theme5"></li>
                            <li id="theme6"></li>
                        </ul>

                        <p class="mb-0">Gradient Background</p>
                        <hr>

                        <ul class="switcher">
                            <li id="theme7"></li>
                            <li id="theme8"></li>
                            <li id="theme9"></li>
                            <li id="theme10"></li>
                            <li id="theme11"></li>
                            <li id="theme12"></li>
                            <li id="theme13"></li>
                            <li id="theme14"></li>
                            <li id="theme15"></li>
                        </ul>
                    </div>
                </div>
                <hr>

            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs nav-tabs-primary top-icon nav-justified">
                    <li class="nav-item">
                        <a href="javascript:void();" data-target="#profile" data-toggle="pill"
                            class="nav-link active"><i class="icon-user"></i> <span class="hidden-xs">Profile</span></a>
                    </li>
                    {{-- <li class="nav-item">
                        <a href="javascript:void();" data-target="#messages" data-toggle="pill" class="nav-link"><i
                                class="icon-envelope-open"></i> <span class="hidden-xs">Messages</span></a>
                    </li> --}}
                    <li class="nav-item">
                        <a href="javascript:void();" wire:click="edit('{{ $data->id }}')" data-target="#edit" data-toggle="pill" class="nav-link"><i
                                class="icon-note"></i> <span class="hidden-xs">Edit</span></a>
                    </li>
                </ul>
                <div class="tab-content p-3">
                    <div class="tab-pane active" id="profile">
                        <h5 class="mb-3">User Profile</h5>
                        <div class="row">
                            <div class="col-md-12">
                                <h6>Nombre</h6>
                                <p>
                                    {{ $data->name }}
                                </p>
                                <h6>Telf/Cel</h6>
                                <p>
                                    {{ $data->phone }}
                                </p>
                                <h6>Correo Electronico</h6>
                                <p>
                                    {{ $data->email }}
                                </p>
                                <h6>Tipo de Cuenta</h6>
                                <p>
                                    {{ $data->profile }}
                                </p>
                                <h6>Estado de la Cuenta</h6>
                                <p>
                                    {{ $data->status }}
                                </p>
                            </div>


                        </div>
                        <!--/row-->
                    </div>
                    {{-- <div class="tab-pane" id="messages">
                        <div class="alert alert-info alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert">&times;</button>
                            <div class="alert-icon">
                                <i class="icon-info"></i>
                            </div>
                            <div class="alert-message">
                                <span><strong>Info!</strong> Lorem Ipsum is simply dummy text.</span>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <tbody>
                                    <tr>
                                        <td>
                                            <span class="float-right font-weight-bold">3 hrs ago</span> Here is your a
                                            link to the latest summary report from the..
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="float-right font-weight-bold">Yesterday</span> There has been
                                            a request on your account since that was..
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="float-right font-weight-bold">9/10</span> Porttitor vitae
                                            ultrices quis, dapibus id dolor. Morbi venenatis lacinia rhoncus.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="float-right font-weight-bold">9/4</span> Vestibulum tincidunt
                                            ullamcorper eros eget luctus.
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <span class="float-right font-weight-bold">9/4</span> Maxamillion ais the
                                            fix for tibulum tincidunt ullamcorper eros.
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div> --}}
                    <div class="tab-pane" id="edit">
                        <form>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Nombre</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" wire:model.lazy="name"
                                        placeholder="ej: Nombre Apellido">
                                    @error('name')
                                        <span class="text-danger er">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Last name</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="Jhonsan">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Email</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="email" value="mark@example.com">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Change profile</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="file">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Website</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="url" value="">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Address</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="" placeholder="Street">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-6">
                                    <input class="form-control" type="text" value="" placeholder="City">
                                </div>
                                <div class="col-lg-3">
                                    <input class="form-control" type="text" value="" placeholder="State">
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Username</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="text" value="jhonsanmark">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label">Confirm password</label>
                                <div class="col-lg-9">
                                    <input class="form-control" type="password" value="11111122333">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-lg-3 col-form-label form-control-label"></label>
                                <div class="col-lg-9">
                                    <input type="reset" class="btn btn-secondary" value="Cancel">
                                    <input type="button" class="btn btn-primary" value="Save Changes">
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
