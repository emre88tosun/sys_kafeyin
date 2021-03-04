@extends('layouts.non-auth')

@section('css')
    <link rel="stylesheet" href="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.css') }}" type="text/css"/>
@endsection

@section('content')

    <div class="account-pages my-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="card">
                        <div class="card-body p-0">
                            <div class="col-md-12 p-5">
                                <div class="mb-4">
                                    <a href="#">
                                        <img src="/assets/images/logo.png" alt="logo" height="36"/>
                                    </a>
                                </div>

                                <div class="row">
                                    <div class="col-xl-3">
                                        <ul class="nav nav-pills flex-column pr-2 pl-2 pt-2 pb-2 nav-justified">
                                            <li class="nav-item">
                                                <a href="#merhaba" data-toggle="tab" aria-expanded="true"
                                                   class="nav-link active">
                                                    <span class="d-block d-sm-none">Merhaba!</span>
                                                    <span class="d-none d-sm-block">Merhaba!</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#bilgiler" data-toggle="tab" aria-expanded="false"
                                                   class="nav-link ">
                                                    <span class="d-block d-sm-none">Bilgiler</span>
                                                    <span class="d-none d-sm-block">Bilgiler</span>
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a href="#basvuru" data-toggle="tab" aria-expanded="false"
                                                   class="nav-link">
                                                    <span class="d-block d-sm-none">Başvuru</span>
                                                    <span class="d-none d-sm-block">Başvuru</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="col-xl-9">
                                        <div class="tab-content text-muted p-0">
                                            <div class="tab-pane show active " id="merhaba">
                                                <p>Vakal text here dolor sit amet, consectetuer adipiscing elit. Aenean
                                                    commodo ligula eget dolor. Aenean massa. Cum sociis natoque
                                                    penatibus et magnis dis parturient montes, nascetur ridiculus mus.
                                                    Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.
                                                    Nulla consequat massa quis enim.</p>
                                                <p class="mb-0">Donec pede justo, fringilla vel, aliquet nec, vulputate
                                                    eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae,
                                                    justo. Nullam dictum felis eu pede mollis pretium. Integer
                                                    tincidunt.Cras dapibus. Vivamus elementum semper nisi. Aenean
                                                    vulputate eleifend tellus. Aenean leo ligula, porttitor eu,
                                                    consequat vitae, eleifend ac, enim.</p>
                                            </div>
                                            <div class="tab-pane " id="bilgiler">
                                                <p>Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu.
                                                    In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo.
                                                    Nullam dictum felis eu pede mollis pretium. Integer tincidunt.Cras
                                                    dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend
                                                    tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend
                                                    ac, enim.</p>
                                                <p class="mb-0">Vakal text here dolor sit amet, consectetuer adipiscing
                                                    elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis
                                                    natoque penatibus et magnis dis parturient montes, nascetur
                                                    ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu,
                                                    pretium quis, sem. Nulla consequat massa quis enim.</p>
                                            </div>
                                            <div class="tab-pane" id="basvuru">
                                                <div class="row">
                                                    <div class="col-xl-12">
                                                        <h4 class="mb-1 mt-sm-2 ml-0">Başvuru</h4>
                                                        @if(count($ref->brand->stores) > 1)
                                                            <p>Aşağıda bulunan başvuru formunu doldurup göndermenizin
                                                                ardından Kafeyin ekibi size ulaşacak ve marka &
                                                                mağazalarınızın
                                                                yönetim panelleri aktif hale gelecektir. Başvuru
                                                                sürecinin
                                                                sağlıklı ilerlemesi adına gireceğiniz e-posta adresi ve
                                                                telefon numarası gibi iletişim bilgilerinin eksiksiz, doğru ve aktif olarak kullanıldığından
                                                                emin olunuz.</p>
                                                        @else
                                                            <p>Aşağıda bulunan başvuru formunu doldurup göndermenizin
                                                                ardından Kafeyin ekibi size ulaşacak ve marka &
                                                                mağazanızın
                                                                yönetim panelleri aktif hale gelecektir. Başvuru
                                                                sürecinin
                                                                sağlıklı ilerlemesi adına gireceğiniz e-posta adresi ve
                                                                telefon numarası gibi iletişim bilgilerinin eksiksiz, doğru ve aktif olarak kullanıldığından emin olunuz.</p>
                                                        @endif
                                                        <hr>
                                                        <h5 class="mb-1 mt-0 ml-0 font-weight-bold">Başvuru Formu</h5>
                                                        <form id="basvuruForm" class="mt-3" method="post"
                                                              action="/ilkbasvurugonder">
                                                            @csrf
                                                            <fieldset>
                                                                <input type="hidden" name="referral"
                                                                       value="{{$ref->referralCode}}">
                                                                <div id="basvuruWizard">
                                                                    <ul>
                                                                        <li>
                                                                            <a href="#stepMarka">MRK88{{$ref->brand->id}}
                                                                                <small class="d-block">Marka
                                                                                    Bilgileri</small></a></li>
                                                                        @for($i = 0; $i<count($stos); $i++)
                                                                            <li>
                                                                                <a href="#stepMagaza{{$i}}">KFYN{{$stos[$i]->id}}
                                                                                    <small class="d-block">Mağaza
                                                                                        Bilgileri</small></a></li>
                                                                        @endfor
                                                                        <li><a href="#stepTamamla">Son<small
                                                                                    class="d-block">Başvuruyu
                                                                                    tamamla</small></a></li>
                                                                    </ul>

                                                                    <div class="p-0">
                                                                        <div id="stepMarka">
                                                                            <div class="row">
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="brandName"
                                                                                               class="col-md-12 col-form-label">Marka
                                                                                            Adı</label>
                                                                                        <div class="col-md-12">
                                                                                            <input id="brandName"
                                                                                                   class="form-control"
                                                                                                   readonly disabled
                                                                                                   required
                                                                                                   name="brandName"
                                                                                                   type="text"
                                                                                                   value="{{$ref->brand->name}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="brandID"
                                                                                               class="col-md-12 col-form-label"
                                                                                               data-toggle="tooltip"
                                                                                               data-placement="left"
                                                                                               title="Markanın Kafeyin sistemlerinde kayıtlı ID'si. Markanıza ait bütün işlemleri bu ID ile yapabileceksiniz.">Marka
                                                                                            ID</label>
                                                                                        <div class="col-md-12">
                                                                                            <input id="brandID"
                                                                                                   class="form-control"
                                                                                                   readonly disabled
                                                                                                   required
                                                                                                   name="brandID"
                                                                                                   type="text"
                                                                                                   value="MRK88{{$ref->brand->id}}">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="brandManagerName"
                                                                                               class="col-md-12 col-form-label">Marka
                                                                                            Yöneticisi Adı</label>
                                                                                        <div class="col-md-12">
                                                                                            <input id="brandManagerName"
                                                                                                   class="form-control"
                                                                                                   style="text-transform: capitalize;"
                                                                                                   required
                                                                                                   name="brandManagerName"
                                                                                                   type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="brandManagerSurname"
                                                                                               class="col-md-12 col-form-label">Marka
                                                                                            Yöneticisi Soyadı</label>
                                                                                        <div class="col-md-12">
                                                                                            <input
                                                                                                id="brandManagerSurname"
                                                                                                class="form-control"
                                                                                                style="text-transform: capitalize;"
                                                                                                required
                                                                                                name="brandManagerSurname"
                                                                                                type="text">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="brandManagerEmail"
                                                                                               class="col-md-12 col-form-label"
                                                                                               data-toggle="tooltip"
                                                                                               data-placement="left"
                                                                                               title="Girdiğiniz e-posta adresi bilgisinin eksiksiz, doğru ve aktif olarak kullanıldığından emin olunuz. Kafeyin Yönetici Panelini kullanırken birçok işlemi kayıt olurken kullandığınız e-posta adresi üzerinden gerçekleştireceksiniz.">Marka
                                                                                            Yöneticisi E-posta
                                                                                            Adresi</label>
                                                                                        <div class="col-md-12">
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <div
                                                                                                        class="input-group-text">
                                                                                                        @
                                                                                                    </div>
                                                                                                </div>
                                                                                                <input type="email"
                                                                                                       name="brandManagerEmail"
                                                                                                       required
                                                                                                       class="form-control"
                                                                                                       id="brandManagerEmail">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="col-md-6">
                                                                                    <div class="form-group">
                                                                                        <label for="brandManagerGSM"
                                                                                               class="col-md-12 col-form-label">Marka
                                                                                            Yöneticisi GSM
                                                                                            Numarası</label>
                                                                                        <div class="col-md-12">
                                                                                            <div class="input-group">
                                                                                                <div
                                                                                                    class="input-group-prepend">
                                                                                                    <div
                                                                                                        class="input-group-text">
                                                                                                        +90
                                                                                                    </div>
                                                                                                </div>
                                                                                                <input
                                                                                                    id="brandManagerGSM"
                                                                                                    class="form-control"
                                                                                                    required
                                                                                                    name="brandManagerGSM"
                                                                                                    type="text"
                                                                                                    data-inputmask-alias="(599) 999 9999">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        @for($i = 0; $i<count($stos); $i++)
                                                                            <div id="stepMagaza{{$i}}">
                                                                                <div class="row">
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeName{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Adı</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeName{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    readonly disabled
                                                                                                    required
                                                                                                    name="storeName{{$stos[$i]->id}}"
                                                                                                    type="text"
                                                                                                    value="{{$stos[$i]->name}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeID{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label"
                                                                                                data-toggle="tooltip"
                                                                                                data-placement="left"
                                                                                                title="Mağazanın Kafeyin sistemlerinde kayıtlı ID'si. Mağazaya ait bütün işlemleri bu ID ile yapabileceksiniz.">Mağaza
                                                                                                ID</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeID{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    readonly disabled
                                                                                                    required
                                                                                                    name="storeID{{$stos[$i]->id}}"
                                                                                                    type="text"
                                                                                                    value="KFYN{{$stos[$i]->id}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeAddress{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Adresi</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeAddress{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    readonly disabled
                                                                                                    required
                                                                                                    name="storeAddress{{$stos[$i]->id}}"
                                                                                                    type="text"
                                                                                                    value="{{$stos[$i]->address}}">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeOwnerName{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Sahibi Adı</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeOwnerName{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    style="text-transform: capitalize;"
                                                                                                    required
                                                                                                    name="storeOwnerName{{$stos[$i]->id}}"
                                                                                                    type="text">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeOwnerSurname{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Sahibi Soyadı</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeOwnerSurname{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    style="text-transform: capitalize;"
                                                                                                    required
                                                                                                    name="storeOwnerSurname{{$stos[$i]->id}}"
                                                                                                    type="text">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeOwnerEmail{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Sahibi E-posta
                                                                                                Adresi</label>
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="input-group">
                                                                                                    <div
                                                                                                        class="input-group-prepend">
                                                                                                        <div
                                                                                                            class="input-group-text">
                                                                                                            @
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input type="email"
                                                                                                           name="storeOwnerEmail{{$stos[$i]->id}}"
                                                                                                           required
                                                                                                           class="form-control"
                                                                                                           id="storeOwnerEmail{{$stos[$i]->id}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeOwnerGSM{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Sahibi GSM
                                                                                                Numarası</label>
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="input-group">
                                                                                                    <div
                                                                                                        class="input-group-prepend">
                                                                                                        <div
                                                                                                            class="input-group-text">
                                                                                                            +90
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input
                                                                                                        id="storeOwnerGSM{{$stos[$i]->id}}"
                                                                                                        class="form-control"
                                                                                                        required
                                                                                                        name="storeOwnerGSM{{$stos[$i]->id}}"
                                                                                                        type="text"
                                                                                                        data-inputmask-alias="(599) 999 9999">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-12">
                                                                                        <div class="form-group">
                                                                                            <div
                                                                                                class="custom-control custom-checkbox mt-2 mb-2 ml-3">
                                                                                                <input type="checkbox"
                                                                                                       class="custom-control-input"
                                                                                                       id="ownerIsManager{{$stos[$i]->id}}"
                                                                                                       name="ownerIsManager{{$stos[$i]->id}}">
                                                                                                <label
                                                                                                    class="custom-control-label"
                                                                                                    for="ownerIsManager{{$stos[$i]->id}}">Mağaza
                                                                                                    sahibi ve mağaza
                                                                                                    yöneticisi bilgileri
                                                                                                    aynı</label>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeManagerName{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Yöneticisi Adı</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeManagerName{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    style="text-transform: capitalize;"
                                                                                                    name="storeManagerName{{$stos[$i]->id}}"
                                                                                                    type="text">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeManagerSurname{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Yöneticisi
                                                                                                Soyadı</label>
                                                                                            <div class="col-md-12">
                                                                                                <input
                                                                                                    id="storeManagerSurname{{$stos[$i]->id}}"
                                                                                                    class="form-control"
                                                                                                    style="text-transform: capitalize;"
                                                                                                    name="storeManagerSurname{{$stos[$i]->id}}"
                                                                                                    type="text">
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeManagerEmail{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label"
                                                                                                data-toggle="tooltip"
                                                                                                data-placement="left"
                                                                                                title="Girdiğiniz e-posta adresi bilgisinin eksiksiz, doğru ve aktif olarak kullanıldığından emin olunuz. Kafeyin Yönetici Panelini kullanırken birçok işlemi kayıt olurken kullandığınız e-posta adresi üzerinden gerçekleştireceksiniz.">Mağaza
                                                                                                Yöneticisi E-posta
                                                                                                Adresi</label>
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="input-group">
                                                                                                    <div
                                                                                                        class="input-group-prepend">
                                                                                                        <div
                                                                                                            class="input-group-text">
                                                                                                            @
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input type="email"
                                                                                                           name="storeManagerEmail{{$stos[$i]->id}}"
                                                                                                           class="form-control"
                                                                                                           id="storeManagerEmail{{$stos[$i]->id}}">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="col-md-6">
                                                                                        <div class="form-group">
                                                                                            <label
                                                                                                for="storeManagerGSM{{$stos[$i]->id}}"
                                                                                                class="col-md-12 col-form-label">Mağaza
                                                                                                Yöneticisi GSM
                                                                                                Numarası</label>
                                                                                            <div class="col-md-12">
                                                                                                <div
                                                                                                    class="input-group">
                                                                                                    <div
                                                                                                        class="input-group-prepend">
                                                                                                        <div
                                                                                                            class="input-group-text">
                                                                                                            +90
                                                                                                        </div>
                                                                                                    </div>
                                                                                                    <input
                                                                                                        id="storeManagerGSM{{$stos[$i]->id}}"
                                                                                                        class="form-control"
                                                                                                        name="storeManagerGSM{{$stos[$i]->id}}"
                                                                                                        type="text"
                                                                                                        data-inputmask-alias="(599) 999 9999">
                                                                                                </div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        @endfor
                                                                        <div id="stepTamamla">
                                                                            <div class="row">
                                                                                <div id="loadingFinal" class="col-12"
                                                                                     style="display: block">
                                                                                    <div class="text-center">
                                                                                        <div class="spinner-border text-primary mt-4" role="status"> <span class="sr-only"></span> </div>

                                                                                    </div>
                                                                                </div>
                                                                                <div id="allStepsDone" class="col-12"
                                                                                     style="display: none">
                                                                                    <div class="text-center">
                                                                                        <div class="mb-3 mt-3">
                                                                                            <i class="uil uil-thumbs-up text-primary h2"></i>
                                                                                        </div>
                                                                                        <h3>Nerdeyse bitti !</h3>

                                                                                        <p class="w-75 mb-2 mx-auto text-muted">
                                                                                            Başvurunuzu göndermenizin
                                                                                            ardından Kafeyin ekibi
                                                                                            tarafından incelenecek ve
                                                                                            Marka & Mağaza Yönetimi
                                                                                            hesaplarınız
                                                                                            tanımlanacaktır.
                                                                                            Başvurunuz esnasında
                                                                                            girdiğiniz e-posta
                                                                                            adreslerinin gelen kutusunu
                                                                                            ve spam klasörünü ilerleyen
                                                                                            günlerde kontrol etmeyi
                                                                                            unutmayınız.</p>

                                                                                    </div>
                                                                                </div>
                                                                                <div id="allStepsNotDone" class="col-12"
                                                                                     style="display: none">
                                                                                    <div class="text-center">
                                                                                        <div class="mb-3 mt-3">
                                                                                            <i class="uil  uil-exclamation-triangle text-danger h2"></i>
                                                                                        </div>
                                                                                        <h3>Oops !</h3>

                                                                                        <p class="w-75 mb-2 mx-auto text-muted">
                                                                                            Başvuru formunda eksik
                                                                                            bilgiler olduğu için
                                                                                            başvurunuzu
                                                                                            gönderemezsiniz.</p>

                                                                                    </div>
                                                                                </div>
                                                                                <div id="duplicateEmail" class="col-12"
                                                                                     style="display: none">
                                                                                    <div class="text-center">
                                                                                        <div class="mb-3 mt-3">
                                                                                            <i class="uil  uil-exclamation-triangle text-danger h2"></i>
                                                                                        </div>
                                                                                        <h3>Oops !</h3>

                                                                                        <p class="w-75 mb-2 mx-auto text-muted">
                                                                                            Mağaza yöneticilerinin e-posta adresleri aynı olmamalıdır.</p>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </form>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{ URL::asset('assets/plugins/inputmask/jquery.inputmask.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/smartwizard/smartwizard.min.js') }}"></script>
    <script type="text/javascript">
        $('#basvuruForm').submit(function(e){
            swal.fire({
                html:"<div class='spinner-border text-primary' role='status'> <span class='sr-only'>Lütfen bekleyin</span> </div>",
                showConfirmButton: false,
                allowOutsideClick: false,
                customClass:"swal2-toast"
            });
        });
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode === 13) {
                    event.preventDefault();
                    return false;
                }
            });
        });
        var stos = @json($stos);

        $(document).ready(function () {
            $('#basvuruWizard').smartWizard({
                useURLhash: false,
                showStepURLhash: false,
                keyNavigation: false,
                toolbarSettings: {
                    toolbarPosition: 'bottom',
                    toolbarButtonPosition: 'right',
                    showNextButton: true,
                    showPreviousButton: true,
                    toolbarExtraButtons: [
                        $('<button></button>').text('Gönder')
                            .attr('id', 'btnBasvuruGonder')
                            .addClass('btn btn-sm btn-primary')
                            .addClass('disabled')
                            .hide()
                            .on('click', function () {
                                if (document.getElementsByClassName("nav-item danger").length === 0) {
                                    $('#basvuruForm').submit();
                                }
                            }),
                    ]
                },
                anchorSettings: {
                    anchorClickable: false,
                    enableAllAnchors: false,
                    markDoneStep: false,
                    markAllPreviousStepsAsDone: false,
                    removeDoneStepOnNavigateBack: false,
                    enableAnchorOnDoneStep: false,
                },

            });

            $("#basvuruWizard").on("showStep", async function (e, anchorObject, stepNumber, stepDirection, stepPosition) {
                $('#basvuruWizard').smartWizard("stepState", [stepNumber], "error-off");
                if (stepPosition === 'final') {
                    if(document.getElementById("loadingFinal").style.display === "none"){
                        document.getElementById("loadingFinal").style.display = "block";
                        document.getElementById("allStepsDone").style.display = "none";
                        document.getElementById("allStepsNotDone").style.display = "none";
                        document.getElementById("duplicateEmail").style.display = "none";
                    }
                    await new Promise(resolve => setTimeout(resolve, 2300));
                    $("#btnBasvuruGonder").removeClass('disabled');
                    $("#btnBasvuruGonder").show();
                    if (document.getElementsByClassName("nav-item danger").length > 0) {
                        document.getElementById("loadingFinal").style.display = "none";
                        document.getElementById("allStepsDone").style.display = "none";
                        document.getElementById("allStepsNotDone").style.display = "block";
                        document.getElementById("duplicateEmail").style.display = "none";
                        $("#btnBasvuruGonder").addClass('disabled');
                    } else {
                        if(stos.length > 1){
                            var emails = [];
                            @foreach($stos as $sto)
                            if($('#storeManagerEmail{{$sto->id}}').val()){
                                emails.push($('#storeManagerEmail{{$sto->id}}').val());
                            }else{
                                emails.push($('#storeOwnerEmail{{$sto->id}}').val())
                            }
                            @endforeach
                            var duplicateEmails = [];
                            var fakeEmails = [];
                            emails.forEach(function (email){
                                if(!fakeEmails.includes(email)){
                                    fakeEmails.push(email);
                                }else{
                                    duplicateEmails.push(email);
                                }
                            });
                            if(emails.length > fakeEmails.length){
                                document.getElementById("loadingFinal").style.display = "none";
                                document.getElementById("allStepsDone").style.display = "none";
                                document.getElementById("allStepsNotDone").style.display = "none";
                                document.getElementById("duplicateEmail").style.display = "block";
                                $("#btnBasvuruGonder").addClass('disabled');
                            }else{
                                document.getElementById("loadingFinal").style.display = "none";
                                document.getElementById("allStepsDone").style.display = "block";
                                document.getElementById("allStepsNotDone").style.display = "none";
                                document.getElementById("duplicateEmail").style.display = "none";
                                $("#btnBasvuruGonder").removeClass('disabled');
                            }
                        }else{
                            document.getElementById("loadingFinal").style.display = "none";
                            document.getElementById("allStepsDone").style.display = "block";
                            document.getElementById("allStepsNotDone").style.display = "none";
                            document.getElementById("duplicateEmail").style.display = "none";
                            $("#btnBasvuruGonder").removeClass('disabled');
                        }

                    }
                } else {
                    $("#btnBasvuruGonder").addClass('disabled');
                    $("#btnBasvuruGonder").hide();
                }
            });

            var node = document.createElement("SPAN");
            var textnode = document.createTextNode("Lütfen bu alanı doldurun.");
            node.appendChild(textnode);
            node.className = "invalid-feedback";
            node.role = "alert";
            node.id = "if-bmnameErr";

            var node2 = document.createElement("SPAN");
            var textnode2 = document.createTextNode("Lütfen bu alanı doldurun.");
            node2.appendChild(textnode2);
            node2.className = "invalid-feedback";
            node2.role = "alert";
            node2.id = "if-bmsurnameErr";

            var node3 = document.createElement("SPAN");
            var textnode3 = document.createTextNode("Lütfen bu alanı doldurun.");
            node3.appendChild(textnode3);
            node3.className = "invalid-feedback";
            node3.role = "alert";
            node3.id = "if-bmemailErr";

            var node31 = document.createElement("SPAN");
            var textnode31 = document.createTextNode("Bu e-posta adresi ile kayıtlı kullanıcı bulunuyor.");
            node31.appendChild(textnode31);
            node31.className = "invalid-feedback";
            node31.role = "alert";
            node31.id = "if-bmemailErr2";

            var node4 = document.createElement("SPAN");
            var textnode4 = document.createTextNode("Lütfen bu alanı doldurun.");
            node4.appendChild(textnode4);
            node4.className = "invalid-feedback";
            node4.role = "alert";
            node4.id = "if-bmgsmErr";

            $("#basvuruWizard").on("leaveStep", function (e, anchorObject, currentStepIndex, nextStepIndex, stepDirection, stepPosition) {
                var length = anchorObject.prevObject.length;
                if (currentStepIndex === 0) {
                    var bmname = $('#brandManagerName').val();
                    var bmsurname = $('#brandManagerSurname').val();
                    var bmemail = $('#brandManagerEmail').val();
                    var bmgsm = $('#brandManagerGSM').val();

                    if (!bmname || !bmsurname || !bmemail || !bmgsm || !validateEmail(bmemail) || bmgsm.includes('_')) {
                        $('#basvuruWizard').smartWizard("stepState", [0], "error-on");
                    } else {
                        $.ajax({
                            url: "/checkemail",
                            type:"GET",
                            data:{
                                email:bmemail,
                            },
                            success:function(response){
                                if(response){
                                    $('#basvuruWizard').smartWizard("stepState", [0], "error-on");
                                }else{

                                    $('#basvuruWizard').smartWizard("stepState", [0], "done-on");
                                }
                            },
                            error:function(response){
                                $('#basvuruWizard').smartWizard("stepState", [0], "error-on");
                            }
                        });
                    }
                    if (!bmname) {
                        var elem1 = document.getElementById("if-bmnameErr");
                        if (!elem1) {
                            document.getElementById("brandManagerName").parentElement.appendChild(node);
                            $('#brandManagerName').addClass("is-invalid");
                        }
                    } else {
                        var elem12 = document.getElementById("if-bmnameErr");
                        if (elem12) {
                            elem12.remove();
                            $('#brandManagerName').removeClass("is-invalid");
                        }
                    }
                    if (!bmsurname) {
                        var elem2 = document.getElementById("if-bmsurnameErr");
                        if (!elem2) {
                            document.getElementById("brandManagerSurname").parentElement.appendChild(node2);
                            $('#brandManagerSurname').addClass("is-invalid");
                        }
                    } else {
                        var elem22 = document.getElementById("if-bmsurnameErr");
                        if (elem22) {
                            elem22.remove();
                            $('#brandManagerSurname').removeClass("is-invalid");
                        }
                    }
                    if (!bmemail || !validateEmail(bmemail)) {
                        var elem3 = document.getElementById("if-bmemailErr");
                        if (!elem3) {
                            document.getElementById("brandManagerEmail").parentElement.appendChild(node3);
                            $('#brandManagerEmail').addClass("is-invalid");
                        }
                    } else {
                        $.ajax({
                            url: "/checkemail",
                            type:"GET",
                            data:{
                                email:bmemail,
                            },
                            success:function(response){
                                if(response){
                                    if (document.getElementById("if-bmemailErr")) {
                                        document.getElementById("if-bmemailErr").remove();
                                        $('#brandManagerEmail').removeClass("is-invalid");
                                    }
                                    if (!document.getElementById("if-bmemailErr2")) {
                                        document.getElementById("brandManagerEmail").parentElement.appendChild(node31);
                                        $('#brandManagerEmail').addClass("is-invalid");
                                    }
                                }else{
                                    if (document.getElementById("if-bmemailErr2")) {
                                        document.getElementById("if-bmemailErr2").remove();
                                        $('#brandManagerEmail').removeClass("is-invalid");
                                    }
                                    if (document.getElementById("if-bmemailErr")) {
                                        document.getElementById("if-bmemailErr").remove();
                                        $('#brandManagerEmail').removeClass("is-invalid");
                                    }
                                }
                            },
                        });

                    }
                    if (!bmgsm || bmgsm.includes('_')) {
                        var elem4 = document.getElementById("if-bmgsmErr");
                        if (!elem4) {
                            document.getElementById("brandManagerGSM").parentElement.appendChild(node4);
                            $('#brandManagerGSM').addClass("is-invalid");
                        }
                    } else {
                        var elem42 = document.getElementById("if-bmgsmErr");
                        if (elem42) {
                            elem42.remove();
                            $('#brandManagerGSM').removeClass("is-invalid");
                        }
                    }

                } else if (currentStepIndex === length - 1) {
                } else {
                    var i = currentStepIndex - 1;
                    var soname = $('#storeOwnerName' + stos[i]['id']).val();
                    var sosurname = $('#storeOwnerSurname' + stos[i]['id']).val();
                    var soemail = $('#storeOwnerEmail' + stos[i]['id']).val();
                    var sogsm = $('#storeOwnerGSM' + stos[i]['id']).val();

                    var node5 = document.createElement("SPAN");
                    var textnode5 = document.createTextNode("Lütfen bu alanı doldurun.");
                    node5.appendChild(textnode5);
                    node5.className = "invalid-feedback";
                    node5.role = "alert";
                    node5.id = "if-sonameErr" + i + stos[i]['id'];

                    var node6 = document.createElement("SPAN");
                    var textnode6 = document.createTextNode("Lütfen bu alanı doldurun.");
                    node6.appendChild(textnode6);
                    node6.className = "invalid-feedback";
                    node6.role = "alert";
                    node6.id = "if-sosurnameErr" + i + stos[i]['id'];

                    var node7 = document.createElement("SPAN");
                    var textnode7 = document.createTextNode("Lütfen bu alanı doldurun.");
                    node7.appendChild(textnode7);
                    node7.className = "invalid-feedback";
                    node7.role = "alert";
                    node7.id = "if-soemailErr" + i + stos[i]['id'];

                    var node8 = document.createElement("SPAN");
                    var textnode8 = document.createTextNode("Lütfen bu alanı doldurun.");
                    node8.appendChild(textnode8);
                    node8.className = "invalid-feedback";
                    node8.role = "alert";
                    node8.id = "if-sogsmErr" + i + stos[i]['id'];

                    if (!soname) {
                        if (!document.getElementById("if-sonameErr" + i + stos[i]['id'])) {
                            document.getElementById("storeOwnerName" + stos[i]['id']).parentElement.appendChild(node5);
                            $('#storeOwnerName' + stos[i]['id']).addClass("is-invalid");
                        }
                    } else {
                        if (document.getElementById("if-sonameErr" + i + stos[i]['id'])) {
                            document.getElementById("if-sonameErr" + i + stos[i]['id']).remove();
                            $('#storeOwnerName' + stos[i]['id']).removeClass("is-invalid");
                        }
                    }
                    if (!sosurname) {
                        if (!document.getElementById("if-sosurnameErr" + i + stos[i]['id'])) {
                            document.getElementById("storeOwnerSurname" + stos[i]['id']).parentElement.appendChild(node6);
                            $('#storeOwnerSurname' + stos[i]['id']).addClass("is-invalid");
                        }
                    } else {
                        if (document.getElementById("if-sosurnameErr" + i + stos[i]['id'])) {
                            document.getElementById("if-sosurnameErr" + i + stos[i]['id']).remove();
                            $('#storeOwnerSurname' + stos[i]['id']).removeClass("is-invalid");
                        }
                    }
                    if (!soemail || !validateEmail(soemail)) {
                        if (!document.getElementById("if-soemailErr" + i + stos[i]['id'])) {
                            document.getElementById("storeOwnerEmail" + stos[i]['id']).parentElement.appendChild(node7);
                            $('#storeOwnerEmail' + stos[i]['id']).addClass("is-invalid");
                        }
                    } else {
                        if (document.getElementById("if-soemailErr" + i + stos[i]['id'])) {
                            document.getElementById("if-soemailErr" + i + stos[i]['id']).remove();
                            $('#storeOwnerEmail' + stos[i]['id']).removeClass("is-invalid");
                        }
                    }
                    if (!sogsm || sogsm.includes('_')) {
                        if (!document.getElementById("if-sogsmErr" + i + stos[i]['id'])) {
                            document.getElementById("storeOwnerGSM" + stos[i]['id']).parentElement.appendChild(node8);
                            $('#storeOwnerGSM' + stos[i]['id']).addClass("is-invalid");
                        }
                    } else {
                        if (document.getElementById("if-sogsmErr" + i + stos[i]['id'])) {
                            document.getElementById("if-sogsmErr" + i + stos[i]['id']).remove();
                            $('#storeOwnerGSM' + stos[i]['id']).removeClass("is-invalid");
                        }
                    }

                    if (!$('#ownerIsManager' + stos[i]['id']).prop('checked')) {
                        var smname = $('#storeManagerName' + stos[i]['id']).val();
                        var smsurname = $('#storeManagerSurname' + stos[i]['id']).val();
                        var smemail = $('#storeManagerEmail' + stos[i]['id']).val();
                        var smgsm = $('#storeManagerGSM' + stos[i]['id']).val();

                        var node9 = document.createElement("SPAN");
                        var textnode9 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node9.appendChild(textnode9);
                        node9.className = "invalid-feedback";
                        node9.role = "alert";
                        node9.id = "if-smnameErr" + i + stos[i]['id'];

                        var node10 = document.createElement("SPAN");
                        var textnode10 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node10.appendChild(textnode10);
                        node10.className = "invalid-feedback";
                        node10.role = "alert";
                        node10.id = "if-smsurnameErr" + i + stos[i]['id'];

                        var node11 = document.createElement("SPAN");
                        var textnode11 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node11.appendChild(textnode11);
                        node11.className = "invalid-feedback";
                        node11.role = "alert";
                        node11.id = "if-smemailErr" + i + stos[i]['id'];

                        var node12 = document.createElement("SPAN");
                        var textnode12 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node12.appendChild(textnode12);
                        node12.className = "invalid-feedback";
                        node12.role = "alert";
                        node12.id = "if-smgsmErr" + i + stos[i]['id'];

                        if (!smname) {
                            if (!document.getElementById("if-smnameErr" + i + stos[i]['id'])) {
                                document.getElementById("storeManagerName" + stos[i]['id']).parentElement.appendChild(node9);
                                $('#storeManagerName' + stos[i]['id']).addClass("is-invalid");
                            }
                        } else {
                            if (document.getElementById("if-smnameErr" + i + stos[i]['id'])) {
                                document.getElementById("if-smnameErr" + i + stos[i]['id']).remove();
                                $('#storeManagerName' + stos[i]['id']).removeClass("is-invalid");
                            }
                        }
                        if (!smsurname) {
                            if (!document.getElementById("if-smsurnameErr" + i + stos[i]['id'])) {
                                document.getElementById("storeManagerSurname" + stos[i]['id']).parentElement.appendChild(node10);
                                $('#storeManagerSurname' + stos[i]['id']).addClass("is-invalid");
                            }
                        } else {
                            if (document.getElementById("if-smsurnameErr" + i + stos[i]['id'])) {
                                document.getElementById("if-smsurnameErr" + i + stos[i]['id']).remove();
                                $('#storeManagerSurname' + stos[i]['id']).removeClass("is-invalid");
                            }
                        }
                        if (!smemail || !validateEmail(smemail)) {
                            if (!document.getElementById("if-smemailErr" + i + stos[i]['id'])) {
                                document.getElementById("storeManagerEmail" + stos[i]['id']).parentElement.appendChild(node11);
                                $('#storeManagerEmail' + stos[i]['id']).addClass("is-invalid");
                            }
                        } else {
                            if (document.getElementById("if-smemailErr" + i + stos[i]['id'])) {
                                document.getElementById("if-smemailErr" + i + stos[i]['id']).remove();
                                $('#storeManagerEmail' + stos[i]['id']).removeClass("is-invalid");
                            }
                        }
                        if (!smgsm || smgsm.includes('_')) {
                            if (!document.getElementById("if-smgsmErr" + i + stos[i]['id'])) {
                                document.getElementById("storeManagerGSM" + stos[i]['id']).parentElement.appendChild(node12);
                                $('#storeManagerGSM' + stos[i]['id']).addClass("is-invalid");
                            }
                        } else {
                            if (document.getElementById("if-smgsmErr" + i + stos[i]['id'])) {
                                document.getElementById("if-smgsmErr" + i + stos[i]['id']).remove();
                                $('#storeManagerGSM' + stos[i]['id']).removeClass("is-invalid");
                            }
                        }

                    }

                    if ($('#ownerIsManager' + stos[i]['id']).prop('checked')) {
                        if (!soname || !sosurname || !soemail || !sogsm || !validateEmail(soemail) || sogsm.includes('_')) {
                            $('#basvuruWizard').smartWizard("stepState", [i + 1], "error-on");
                        } else {
                            $.ajax({
                                url: "/checkemail",
                                type:"GET",
                                data:{
                                    email:soemail,
                                },
                                success:function(response){
                                    if(response){
                                        $('#basvuruWizard').smartWizard("stepState", [i + 1], "error-on");
                                    }else{

                                        $('#basvuruWizard').smartWizard("stepState", [i + 1], "done-on");
                                    }
                                },
                                error:function(response){
                                    $('#basvuruWizard').smartWizard("stepState", [i + 1], "error-on");
                                }
                            });
                        }
                    } else {
                        var smname1 = $('#storeManagerName' + stos[i]['id']).val();
                        var smsurname1 = $('#storeManagerSurname' + stos[i]['id']).val();
                        var smemail1 = $('#storeManagerEmail' + stos[i]['id']).val();
                        var smgsm1 = $('#storeManagerGSM' + stos[i]['id']).val();

                        if (!soname || !sosurname || !soemail || !sogsm || !validateEmail(soemail) || sogsm.includes('_') ||
                            !smname1 || !smsurname1 || !smemail1 || !smgsm1 || !validateEmail(smemail1) || smgsm1.includes('_')) {
                            $('#basvuruWizard').smartWizard("stepState", [i + 1], "error-on");
                        } else {
                            $.ajax({
                                url: "/checkemail",
                                type:"GET",
                                data:{
                                    email:smemail1,
                                },
                                success:function(response){
                                    if(response){
                                        $('#basvuruWizard').smartWizard("stepState", [i + 1], "error-on");
                                    }else{

                                        $('#basvuruWizard').smartWizard("stepState", [i + 1], "done-on");
                                    }
                                },
                                error:function(response){
                                    $('#basvuruWizard').smartWizard("stepState", [i + 1], "error-on");
                                }
                            });
                        }

                    }

                }
            });

            function validateEmail(email) {
                const re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            }

            $('#brandManagerName').change(function () {
                var nname = $('#brandManagerName').val();
                if (nname) {
                    if (document.getElementById("if-bmnameErr")) {
                        document.getElementById("if-bmnameErr").remove();
                        $('#brandManagerName').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-bmnameErr")) {
                        document.getElementById("brandManagerName").parentElement.appendChild(node);
                        $('#brandManagerName').addClass("is-invalid");
                    }
                }
            });
            $('#brandManagerSurname').change(function () {
                var ssurname = $('#brandManagerSurname').val();
                if (ssurname) {
                    if (document.getElementById("if-bmsurnameErr")) {
                        document.getElementById("if-bmsurnameErr").remove();
                        $('#brandManagerSurname').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-bmsurnameErr")) {
                        document.getElementById("brandManagerSurname").parentElement.appendChild(node2);
                        $('#brandManagerSurname').addClass("is-invalid");
                    }
                }
            });
            $('#brandManagerEmail').change(function () {
                var eemail = $('#brandManagerEmail').val();
                if (eemail && validateEmail(eemail)) {
                    $.ajax({
                        url: "/checkemail",
                        type:"GET",
                        data:{
                            email:eemail,
                        },
                        success:function(response){
                            if(response){
                                if (document.getElementById("if-bmemailErr")) {
                                    document.getElementById("if-bmemailErr").remove();
                                    $('#brandManagerEmail').removeClass("is-invalid");
                                }
                                if (!document.getElementById("if-bmemailErr2")) {
                                    document.getElementById("brandManagerEmail").parentElement.appendChild(node31);
                                    $('#brandManagerEmail').addClass("is-invalid");
                                }
                            }else{
                                if (document.getElementById("if-bmemailErr2")) {
                                    document.getElementById("if-bmemailErr2").remove();
                                    $('#brandManagerEmail').removeClass("is-invalid");
                                }
                            }
                        },
                    });
                } else {
                    if (document.getElementById("if-bmemailErr2")) {
                        document.getElementById("if-bmemailErr2").remove();
                        $('#brandManagerEmail').removeClass("is-invalid");
                    }
                    if (!document.getElementById("if-bmemailErr")) {
                        document.getElementById("brandManagerEmail").parentElement.appendChild(node3);
                        $('#brandManagerEmail').addClass("is-invalid");
                    }
                }
            });
            $('#brandManagerGSM').change(function () {
                var ggsm = $('#brandManagerGSM').val();
                if (ggsm && !ggsm.includes('_')) {
                    if (document.getElementById("if-bmgsmErr")) {
                        document.getElementById("if-bmgsmErr").remove();
                        $('#brandManagerGSM').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-bmgsmErr")) {
                        document.getElementById("brandManagerGSM").parentElement.appendChild(node4);
                        $('#brandManagerGSM').addClass("is-invalid");
                    }
                }
            });

            @for($i=0;$i<count($stos);$i++)
            $('#ownerIsManager{{$stos[$i]->id}}').change(function () {
                if ($('#ownerIsManager{{$stos[$i]->id}}').prop('checked')) {
                    $('#storeManagerName{{$stos[$i]->id}}').val("");
                    $('#storeManagerSurname{{$stos[$i]->id}}').val("");
                    $('#storeManagerEmail{{$stos[$i]->id}}').val("");
                    $('#storeManagerGSM{{$stos[$i]->id}}').val("");
                }
                if (document.getElementById("if-smnameErr{{$i}}{{$stos[$i]->id}}")) {
                    document.getElementById("if-smnameErr{{$i}}{{$stos[$i]->id}}").remove();
                    $('#storeManagerName{{$stos[$i]->id}}').removeClass("is-invalid");
                }
                if (document.getElementById("if-smsurnameErr{{$i}}{{$stos[$i]->id}}")) {
                    document.getElementById("if-smsurnameErr{{$i}}{{$stos[$i]->id}}").remove();
                    $('#storeManagerSurname{{$stos[$i]->id}}').removeClass("is-invalid");
                }
                if (document.getElementById("if-smemailErr{{$i}}{{$stos[$i]->id}}")) {
                    document.getElementById("if-smemailErr{{$i}}{{$stos[$i]->id}}").remove();
                    $('#storeManagerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                }
                if (document.getElementById("if-smgsmErr{{$i}}{{$stos[$i]->id}}")) {
                    document.getElementById("if-smgsmErr{{$i}}{{$stos[$i]->id}}").remove();
                    $('#storeManagerGSM{{$stos[$i]->id}}').removeClass("is-invalid");
                }
            });
            $('#storeOwnerName{{$stos[$i]->id}}').change(function () {
                if ($('#storeOwnerName{{$stos[$i]->id}}').val()) {
                    if (document.getElementById("if-sonameErr{{$i}}{{$stos[$i]->id}}")) {
                        document.getElementById("if-sonameErr{{$i}}{{$stos[$i]->id}}").remove();
                        $('#storeOwnerName{{$stos[$i]->id}}').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-sonameErr{{$i}}{{$stos[$i]->id}}")) {
                        var node13 = document.createElement("SPAN");
                        var textnode13 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node13.appendChild(textnode13);
                        node13.className = "invalid-feedback";
                        node13.role = "alert";
                        node13.id = "if-sonameErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeOwnerName{{$stos[$i]->id}}').parentElement.appendChild(node13);
                        $('#storeOwnerName{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeOwnerSurname{{$stos[$i]->id}}').change(function () {
                if ($('#storeOwnerSurname{{$stos[$i]->id}}').val()) {
                    if (document.getElementById("if-sosurnameErr{{$i}}{{$stos[$i]->id}}")) {
                        document.getElementById("if-sosurnameErr{{$i}}{{$stos[$i]->id}}").remove();
                        $('#storeOwnerSurname{{$stos[$i]->id}}').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-sosurnameErr{{$i}}{{$stos[$i]->id}}")) {
                        var node14 = document.createElement("SPAN");
                        var textnode14 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node14.appendChild(textnode14);
                        node14.className = "invalid-feedback";
                        node14.role = "alert";
                        node14.id = "if-sosurnameErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeOwnerSurname{{$stos[$i]->id}}').parentElement.appendChild(node14);
                        $('#storeOwnerSurname{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeOwnerEmail{{$stos[$i]->id}}').change(function () {
                if ($('#storeOwnerEmail{{$stos[$i]->id}}').val() && validateEmail($('#storeOwnerEmail{{$stos[$i]->id}}').val())) {
                    if($('#ownerIsManager{{$stos[$i]->id}}').prop('checked')){
                        var node2323 = document.createElement("SPAN");
                        var textnode2323 = document.createTextNode("Bu e-posta adresi ile kayıtlı kullanıcı bulunuyor.");
                        node2323.appendChild(textnode2323);
                        node2323.className = "invalid-feedback";
                        node2323.role = "alert";
                        node2323.id = "if-soemailErr{{$stos[$i]->id}}2";
                        $.ajax({
                            url: "/checkemail",
                            type:"GET",
                            data:{
                                email:$('#storeOwnerEmail{{$stos[$i]->id}}').val(),
                            },
                            success:function(response){
                                if(response){
                                    if (document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}")) {
                                        document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}").remove();
                                        $('#storeOwnerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                                    }
                                    if (!document.getElementById("if-soemailErr{{$stos[$i]->id}}2")) {
                                        document.getElementById("storeOwnerEmail{{$stos[$i]->id}}").parentElement.appendChild(node2323);
                                        $('#storeOwnerEmail{{$stos[$i]->id}}').addClass("is-invalid");
                                    }
                                }else{
                                    if (document.getElementById("if-soemailErr{{$stos[$i]->id}}2")) {
                                        document.getElementById("if-soemailErr{{$stos[$i]->id}}2").remove();
                                        $('#storeOwnerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                                    }
                                }
                            },
                        });
                    }else{
                        if (document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}")) {
                            document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}").remove();
                            $('#storeOwnerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                        }
                    }
                } else {
                    if (!document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}")) {
                        var node15 = document.createElement("SPAN");
                        var textnode15 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node15.appendChild(textnode15);
                        node15.className = "invalid-feedback";
                        node15.role = "alert";
                        node15.id = "if-soemailErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeOwnerEmail{{$stos[$i]->id}}').parentElement.appendChild(node15);
                        $('#storeOwnerEmail{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeOwnerGSM{{$stos[$i]->id}}').change(function () {
                if ($('#storeOwnerGSM{{$stos[$i]->id}}').val() && !$('#storeOwnerGSM{{$stos[$i]->id}}').val().includes('_')) {
                    if (document.getElementById("if-sogsmErr{{$i}}{{$stos[$i]->id}}")) {
                        document.getElementById("if-sogsmErr{{$i}}{{$stos[$i]->id}}").remove();
                        $('#storeOwnerGSM{{$stos[$i]->id}}').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-sogsmErr{{$i}}{{$stos[$i]->id}}")) {
                        var node16 = document.createElement("SPAN");
                        var textnode16 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node16.appendChild(textnode16);
                        node16.className = "invalid-feedback";
                        node16.role = "alert";
                        node16.id = "if-sogsmErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeOwnerGSM{{$stos[$i]->id}}').parentElement.appendChild(node16);
                        $('#storeOwnerGSM{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeManagerName{{$stos[$i]->id}}').change(function () {
                if ($('#storeManagerName{{$stos[$i]->id}}').val()) {
                    if (document.getElementById("if-smnameErr{{$i}}{{$stos[$i]->id}}")) {
                        document.getElementById("if-smnameErr{{$i}}{{$stos[$i]->id}}").remove();
                        $('#storeManagerName{{$stos[$i]->id}}').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-smnameErr{{$i}}{{$stos[$i]->id}}")) {
                        var node17 = document.createElement("SPAN");
                        var textnode17 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node17.appendChild(textnode17);
                        node17.className = "invalid-feedback";
                        node17.role = "alert";
                        node17.id = "if-smnameErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeManagerName{{$stos[$i]->id}}').parentElement.appendChild(node17);
                        $('#storeManagerName{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeManagerSurname{{$stos[$i]->id}}').change(function () {
                if ($('#storeManagerSurname{{$stos[$i]->id}}').val()) {
                    if (document.getElementById("if-smsurnameErr{{$i}}{{$stos[$i]->id}}")) {
                        document.getElementById("if-smsurnameErr{{$i}}{{$stos[$i]->id}}").remove();
                        $('#storeManagerSurname{{$stos[$i]->id}}').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-smsurnameErr{{$i}}{{$stos[$i]->id}}")) {
                        var node18 = document.createElement("SPAN");
                        var textnode18 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node18.appendChild(textnode18);
                        node18.className = "invalid-feedback";
                        node18.role = "alert";
                        node18.id = "if-smsurnameErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeManagerSurname{{$stos[$i]->id}}').parentElement.appendChild(node18);
                        $('#storeManagerSurname{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeManagerEmail{{$stos[$i]->id}}').change(function () {
                var node1212 = document.createElement("SPAN");
                var textnode1212 = document.createTextNode("Bu e-posta adresi ile kayıtlı kullanıcı bulunuyor.");
                node1212.appendChild(textnode1212);
                node1212.className = "invalid-feedback";
                node1212.role = "alert";
                node1212.id = "if-smemailErr{{$stos[$i]->id}}2";
                if ($('#storeManagerEmail{{$stos[$i]->id}}').val() && validateEmail($('#storeManagerEmail{{$stos[$i]->id}}').val())) {
                    $.ajax({
                        url: "/checkemail",
                        type:"GET",
                        data:{
                            email:$('#storeManagerEmail{{$stos[$i]->id}}').val(),
                        },
                        success:function(response){
                            if(response){
                                if (document.getElementById("if-smemailErr{{$i}}{{$stos[$i]->id}}")) {
                                    document.getElementById("if-smemailErr{{$i}}{{$stos[$i]->id}}").remove();
                                    $('#storeManagerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                                }
                                if (!document.getElementById("if-smemailErr{{$stos[$i]->id}}2")) {
                                    document.getElementById("storeManagerEmail{{$stos[$i]->id}}").parentElement.appendChild(node1212);
                                    $('#storeManagerEmail{{$stos[$i]->id}}').addClass("is-invalid");
                                }
                            }else{
                                if (document.getElementById("if-smemailErr{{$stos[$i]->id}}2")) {
                                    document.getElementById("if-smemailErr{{$stos[$i]->id}}2").remove();
                                    $('#storeManagerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                                }
                            }
                        },
                    });
                } else {
                    if (!document.getElementById("if-smemailErr{{$i}}{{$stos[$i]->id}}")) {
                        var node19 = document.createElement("SPAN");
                        var textnode19 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node19.appendChild(textnode19);
                        node19.className = "invalid-feedback";
                        node19.role = "alert";
                        node19.id = "if-smemailErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeManagerEmail{{$stos[$i]->id}}').parentElement.appendChild(node19);
                        $('#storeManagerEmail{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            $('#storeManagerGSM{{$stos[$i]->id}}').change(function () {
                if ($('#storeManagerGSM{{$stos[$i]->id}}').val() && !$('#storeManagerGSM{{$stos[$i]->id}}').val().includes('_')) {
                    if (document.getElementById("if-smgsmErr{{$i}}{{$stos[$i]->id}}")) {
                        document.getElementById("if-smgsmErr{{$i}}{{$stos[$i]->id}}").remove();
                        $('#storeManagerGSM{{$stos[$i]->id}}').removeClass("is-invalid");
                    }
                } else {
                    if (!document.getElementById("if-smgsmErr{{$i}}{{$stos[$i]->id}}")) {
                        var node20 = document.createElement("SPAN");
                        var textnode20 = document.createTextNode("Lütfen bu alanı doldurun.");
                        node20.appendChild(textnode20);
                        node20.className = "invalid-feedback";
                        node20.role = "alert";
                        node20.id = "if-smgsmErr{{$i}}{{$stos[$i]->id}}";
                        document.getElementById('storeManagerGSM{{$stos[$i]->id}}').parentElement.appendChild(node20);
                        $('#storeManagerGSM{{$stos[$i]->id}}').addClass("is-invalid");
                    }
                }
            });
            @endfor

        });

        @for($i = 0; $i<count($stos); $i++)
        $('#ownerIsManager{{$stos[$i]->id}}').change(function () {
            if ($(this).prop('checked')) {
                document.getElementById('storeManagerName{{$stos[$i]->id}}').disabled = true;
                document.getElementById('storeManagerSurname{{$stos[$i]->id}}').disabled = true;
                document.getElementById('storeManagerEmail{{$stos[$i]->id}}').disabled = true;
                document.getElementById('storeManagerGSM{{$stos[$i]->id}}').disabled = true;
                $('#storeManagerName{{$stos[$i]->id}}').addClass('bg-soft-dark2');
                $('#storeManagerSurname{{$stos[$i]->id}}').addClass('bg-soft-dark2');
                $('#storeManagerEmail{{$stos[$i]->id}}').addClass('bg-soft-dark2');
                $('#storeManagerGSM{{$stos[$i]->id}}').addClass('bg-soft-dark2');
                if (document.getElementById("if-smemailErr{{$stos[$i]->id}}2")) {
                    document.getElementById("if-smemailErr{{$stos[$i]->id}}2").remove();
                    $('#storeManagerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                }
                var node3434 = document.createElement("SPAN");
                var textnode3434 = document.createTextNode("Bu e-posta adresi ile kayıtlı kullanıcı bulunuyor.");
                node3434.appendChild(textnode3434);
                node3434.className = "invalid-feedback";
                node3434.role = "alert";
                node3434.id = "if-soemailErr{{$stos[$i]->id}}2";
                $.ajax({
                    url: "/checkemail",
                    type:"GET",
                    data:{
                        email:$('#storeOwnerEmail{{$stos[$i]->id}}').val(),
                    },
                    success:function(response){
                        if(response){
                            if (document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}")) {
                                document.getElementById("if-soemailErr{{$i}}{{$stos[$i]->id}}").remove();
                                $('#storeOwnerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                            }
                            if (!document.getElementById("if-soemailErr{{$stos[$i]->id}}2")) {
                                document.getElementById("storeOwnerEmail{{$stos[$i]->id}}").parentElement.appendChild(node3434);
                                $('#storeOwnerEmail{{$stos[$i]->id}}').addClass("is-invalid");
                            }
                        }else{
                            if (document.getElementById("if-soemailErr{{$stos[$i]->id}}2")) {
                                document.getElementById("if-soemailErr{{$stos[$i]->id}}2").remove();
                                $('#storeOwnerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                            }
                        }
                    },
                });
            } else {
                document.getElementById('storeManagerName{{$stos[$i]->id}}').disabled = false;
                document.getElementById('storeManagerSurname{{$stos[$i]->id}}').disabled = false;
                document.getElementById('storeManagerEmail{{$stos[$i]->id}}').disabled = false;
                document.getElementById('storeManagerGSM{{$stos[$i]->id}}').disabled = false;
                $('#storeManagerName{{$stos[$i]->id}}').removeClass('bg-soft-dark2');
                $('#storeManagerSurname{{$stos[$i]->id}}').removeClass('bg-soft-dark2');
                $('#storeManagerEmail{{$stos[$i]->id}}').removeClass('bg-soft-dark2');
                $('#storeManagerGSM{{$stos[$i]->id}}').removeClass('bg-soft-dark2');
                if (document.getElementById("if-soemailErr{{$stos[$i]->id}}2")) {
                    document.getElementById("if-soemailErr{{$stos[$i]->id}}2").remove();
                    $('#storeOwnerEmail{{$stos[$i]->id}}').removeClass("is-invalid");
                }
            }
        });
        @endfor

    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/inputmask.js') }}"></script>
@endsection
