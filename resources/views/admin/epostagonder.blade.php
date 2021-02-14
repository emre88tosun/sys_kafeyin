@extends('admin.layouts.admin_layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/libs/select2/select2.min.css') }}" rel="stylesheet" type="text/css"/>
@endsection

@section('breadcrumb')
<div class="row page-title">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="float-right mt-1">
            <ol class="breadcrumb">
                <li class="breadcrumb-item active" aria-current="page">E-posta Gönder</li>
            </ol>
        </nav>
        <h4 class="mb-1 mt-0">E-posta Gönder</h4>
    </div>
</div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Tekil kullanıcıya gönder</h5>
                    <form method="post" action="/adminpanel/tekilkullaniciyagonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="userID" class="col-md-2 col-form-label">Kullanıcı</label>
                                <div class="col-md-10">
                                    <select data-plugin="customselects1" required class="form-control"  name="userID" >
                                        <option></option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}"  >#{{$user->id}} - {{$user->name}} {{$user->surname}} - {{$user->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Konu</label>
                                <div class="col-md-10">
                                    <input type="text" name="subject" class="form-control" required id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para1" class="col-md-2 col-form-label">1. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para1" rows="6" class="form-control" id="para1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para2" class="col-md-2 col-form-label">2. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para2" rows="6" class="form-control" id="para2" required></textarea>
                                </div>
                            </div>

                            <div class="offset-md-2">
                                <input type="submit" class="btn btn-primary ml-1" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Çoklu kullanıcıya gönder</h5>
                    <form method="post" action="/adminpanel/coklukullaniciyagonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="userID[]" class="col-md-2 col-form-label">Kullanıcı</label>
                                <div class="col-md-10">
                                    <select data-plugin="customselects2" required class="form-control" multiple="multiple"  name="userID[]" >
                                        <option></option>
                                        @foreach($users as $user)
                                            <option value="{{$user->id}}"  >#{{$user->id}} - {{$user->name}} {{$user->surname}} - {{$user->email}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Konu</label>
                                <div class="col-md-10">
                                    <input type="text" name="subject" class="form-control" required id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para1" class="col-md-2 col-form-label">1. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para1" rows="6" class="form-control" id="para1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para2" class="col-md-2 col-form-label">2. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para2" rows="6" class="form-control" id="para2" required></textarea>
                                </div>
                            </div>

                            <div class="offset-md-2">
                                <input type="submit" class="btn btn-primary ml-1" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Tekil mağaza kullanıcıya gönder</h5>
                    <form method="post" action="/adminpanel/tekilkullaniciyagonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="userID" class="col-md-2 col-form-label">Kullanıcı</label>
                                <div class="col-md-10">
                                    <select data-plugin="customselects3" required class="form-control"  name="userID" >
                                        <option></option>
                                        @foreach($stores as $store)
                                            @if($store->yonetici)
                                                <option value="{{$store->yonetici->id}}"  >#{{$store->yonetici->id}} - {{$store->yonetici->name}} {{$store->yonetici->surname}} - {{$store->yonetici->email}} / #{{$store->id}} - {{$store->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Konu</label>
                                <div class="col-md-10">
                                    <input type="text" name="subject" class="form-control" required id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para1" class="col-md-2 col-form-label">1. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para1" rows="6" class="form-control" id="para1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para2" class="col-md-2 col-form-label">2. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para2" rows="6" class="form-control" id="para2" required></textarea>
                                </div>
                            </div>

                            <div class="offset-md-2">
                                <input type="submit" class="btn btn-primary ml-1" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Çoklu mağaza kullanıcıya gönder</h5>
                    <form method="post" action="/adminpanel/coklukullaniciyagonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="userID[]" class="col-md-2 col-form-label">Kullanıcı</label>
                                <div class="col-md-10">
                                    <select data-plugin="customselects2" required class="form-control" multiple="multiple"  name="userID[]" >
                                        <option></option>
                                        @foreach($stores as $store)
                                            @if($store->yonetici)
                                                <option value="{{$store->yonetici->id}}"  >#{{$store->yonetici->id}} - {{$store->yonetici->name}} {{$store->yonetici->surname}} - {{$store->yonetici->email}} / #{{$store->id}} - {{$store->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Konu</label>
                                <div class="col-md-10">
                                    <input type="text" name="subject" class="form-control" required id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para1" class="col-md-2 col-form-label">1. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para1" rows="6" class="form-control" id="para1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para2" class="col-md-2 col-form-label">2. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para2" rows="6" class="form-control" id="para2" required></textarea>
                                </div>
                            </div>

                            <div class="offset-md-2">
                                <input type="submit" class="btn btn-primary ml-1" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Şehre göre kullanıcıya gönder</h5>
                    <form method="post" action="/adminpanel/sehregorekullaniciyagonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="cityID" class="col-md-2 col-form-label">Şehir</label>
                                <div class="col-md-10">
                                    <select data-plugin="customselects5" required class="form-control"  name="cityID" >
                                        <option></option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}"  >#{{$city->id}} - {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Konu</label>
                                <div class="col-md-10">
                                    <input type="text" name="subject" class="form-control" required id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para1" class="col-md-2 col-form-label">1. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para1" rows="6" class="form-control" id="para1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para2" class="col-md-2 col-form-label">2. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para2" rows="6" class="form-control" id="para2" required></textarea>
                                </div>
                            </div>

                            <div class="offset-md-2">
                                <input type="submit" class="btn btn-primary ml-1" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-xl-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Şehre göre mağaza kullanıcıya gönder</h5>
                    <form method="post" action="/adminpanel/sehregoremagazakullaniciyagonder">
                        @csrf
                        <fieldset>
                            <div class="form-group row">
                                <label for="cityID" class="col-md-2 col-form-label">Şehir</label>
                                <div class="col-md-10">
                                    <select data-plugin="customselects6" required class="form-control"  name="cityID" >
                                        <option></option>
                                        @foreach($cities as $city)
                                            <option value="{{$city->id}}"  >#{{$city->id}} - {{$city->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="subject" class="col-md-2 col-form-label">Konu</label>
                                <div class="col-md-10">
                                    <input type="text" name="subject" class="form-control" required id="subject">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para1" class="col-md-2 col-form-label">1. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para1" rows="6" class="form-control" id="para1" required></textarea>
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="para2" class="col-md-2 col-form-label">2. Paragraf</label>
                                <div class="col-md-10">
                                    <textarea type="text" name="para2" rows="6" class="form-control" id="para2" required></textarea>
                                </div>
                            </div>

                            <div class="offset-md-2">
                                <input type="submit" class="btn btn-primary ml-1" value="Gönder">
                            </div>
                        </fieldset>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script src="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.js')}}"></script>
    <script src="{{URL::asset('assets/js/pages/lightbox.init.js')}}"></script>
    <script src="{{ URL::asset('assets/js/pages/sweet-alerts.init.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.js')}}"></script>
    <script src="{{ URL::asset('assets/libs/select2/select2.min.js') }}"></script>
    <script>
        $('[data-plugin="customselects1"]').select2();
        $('[data-plugin="customselects2"]').select2();
        $('[data-plugin="customselects3"]').select2();
        $('[data-plugin="customselects4"]').select2();
        $('[data-plugin="customselects5"]').select2();
        $('[data-plugin="customselects6"]').select2();
        @if (session('emailSent'))
            swal.fire({
                title: 'Başarılı!',
                text: 'E-posta gönderilmiştir.',
                type: "success",
            });
        @endif
    </script>
@endsection

@section('script-bottom')
@endsection
