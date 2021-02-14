@extends('store_user.layouts.layout')

@section('css')
    <link href="{{URL::asset('assets/libs/magnific-popup/magnific-popup.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/sweetalert2/sweetalert2.min.css')}}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/libs/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css"/>
    <link href="{{ URL::asset('assets/plugins/dropify/css/dropify.min.css') }}" rel="stylesheet" />
@endsection

@section('breadcrumb')
    <div class="row page-title">
        <div class="col-md-12">
            <nav aria-label="breadcrumb" class="float-right mt-1">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item disabled" aria-current="page">Sadakat Kartları</li>
                    @switch($type)
                        @case("aktif")
                            <li class="breadcrumb-item active" aria-current="page">Aktif Sadakat Kartları</li>
                        @break
                        @case("kullanilabilir")
                        <li class="breadcrumb-item active" aria-current="page">Kullanılabilir Sadakat Kartları</li>
                        @break
                        @case("kullanilan")
                        <li class="breadcrumb-item active" aria-current="page">Kullanılan Sadakat Kartları</li>
                        @break
                    @endswitch
                </ol>
            </nav>
            <h4 class="mb-1 mt-0">{{$user->brand->name}} (ID: MRK88{{$user->brand->id}})</h4>

        </div>
    </div>
@endsection

@section('content')
    <div class="row">
        <div class="col-xl-10">
            <div class="card">
                <div class="card-body">
                    @switch($type)
                        @case("aktif")
                        <h5 class="header-title mb-3 mt-0">Aktif sadakat kartları</h5>
                        @break
                        @case("kullanilabilir")
                        <h5 class="header-title mb-3 mt-0">Kullanılabilir sadakat kartları</h5>
                        @break
                        @case("kullanilan")
                        <h5 class="header-title mb-3 mt-0">Kullanılan sadakat kartları</h5>
                        @break
                    @endswitch
                        @switch($type)
                            @case("aktif")
                            <table id="tblActCards" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı</th>
                                    <th>Damga Sayısı</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>Son Damga Eklenme Tarihi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cards as $card)
                                    <tr>
                                        <td>{{strtoupper(str_replace([" ","'"], "",$user->brand->name))}}{{$card->id}}</td>
                                        <td>{{maskString($card->owner->name)}} {{maskString($card->owner->surname)}}</td>
                                        <td>{{$card->stampCount}} / {{$user->brand->needStampCount}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($card->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($card->updated_at)->format('d/m/Y H:i')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break
                            @case("kullanilabilir")
                            <table id="tblAvCards" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı</th>
                                    <th>Damga Sayısı</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>Son Damga Eklenme Tarihi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cards as $card)
                                    <tr>
                                        <td>{{strtoupper(str_replace([" ","'"], "",$user->brand->name))}}{{$card->id}}</td>
                                        <td>{{maskString($card->owner->name)}} {{maskString($card->owner->surname)}}</td>
                                        <td>{{$user->brand->needStampCount}} / {{$user->brand->needStampCount}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($card->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($card->updated_at)->format('d/m/Y H:i')}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break
                            @case("kullanilan")
                            <table id="tblUdCards" class="table table-hover dt-responsive" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Kullanıcı</th>
                                    <th>Oluşturulma Tarihi</th>
                                    <th>Onaylanma Tarihi</th>
                                    <th>Onaylayan Mağaza</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($cards as $card)
                                    <tr>
                                        <td>{{strtoupper(str_replace([" ","'"], "",$user->brand->name))}}{{$card->id}}</td>
                                        <td>{{maskString($card->owner->name)}} {{maskString($card->owner->surname)}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($card->created_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{\Carbon\Carbon::createFromTimeString($card->updated_at)->format('d/m/Y H:i')}}</td>
                                        <td>{{$card->approver_store->name}} (ID: KFYN{{$card->approver_store->id}})</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            @break
                        @endswitch
                </div>
            </div>
            @if($type != "kullanilabilir")
                <div class="card">
                <div class="card-body">
                    <h5 class="card-title header-title border-bottom mb-0 pb-3">Günlük istatistikler <span
                            class="text-muted font-size-14 font-weight-normal">(Son 15 gün)</span></h5>
                    @switch($type)
                        @case("aktif")
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                <div id="cc_chart" class="apex-charts m-0" dir="ltr"></div>
                            @else
                                @if($user->brand->isPremium)
                                    <div id="cc_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    <div class="alert alert-primary ml-0 mr-0 mt-3">Markanızı Premium Plan'a taşıyarak detaylı istatistiklere ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            <div id="cc_chart" class="apex-charts m-0" dir="ltr"></div>
                        @endif
                        @break
                        @case("kullanilan")
                        @if($isPremiumPlanEnabled)
                            @if($isStatisticsFree)
                                <div id="uc_chart" class="apex-charts m-0" dir="ltr"></div>
                            @else
                                @if($user->brand->isPremium)
                                    <div id="uc_chart" class="apex-charts m-0" dir="ltr"></div>
                                @else
                                    <div class="alert alert-primary ml-0 mr-0 mt-3">Markanızı Premium Plan'a taşıyarak detaylı istatistiklere ulaşabilirsiniz.</div>
                                @endif
                            @endif
                        @else
                            <div id="uc_chart" class="apex-charts m-0" dir="ltr"></div>
                        @endif
                        @break
                    @endswitch
                </div>
            </div>
            @endif
        </div>
        <div class="col-xl-2">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title font-size-16">Bilgi</h5>
                    <p class="card-text text-muted">Aktif kart sayısı: {{count($user->brand->loyalty_cards->where('status','active')->where('isDeleted',false))}}</p>
                    <p class="card-text text-muted">Kullanılabilir kart sayısı: {{count($user->brand->loyalty_cards->where('status','available')->where('isDeleted',false))}}</p>
                    <p class="card-text text-muted">Kullanılan kart sayısı: {{count($user->brand->loyalty_cards->where('status','used')->where('isDeleted',false))}}</p>
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
    <script src="{{ URL::asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datatables/datatables.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/dropify/js/dropify.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/moment/moment.min.js') }}"></script>
    <script src="{{ URL::asset('assets/libs/datetime-moment/datetime-moment.js') }}"></script>
    <script>
        $(document).ready(function () {
            $.fn.dataTable.moment( 'DD/MM/YYYY' );
        });
    </script>
    <script>


        @if($type=="aktif")
        var daysLabels = [
                @foreach(array_reverse($l15days) as $day)
                new Date({{$day}}).toLocaleDateString(),
                @endforeach
            ];
        var ccSeries = [
                @foreach(array_reverse($l15dccs) as $dcc)
                {{$dcc}},
                @endforeach
            ];
        var ccOptions = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'Yeni sadakat kartı sayısı',
                data: ccSeries
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#ff8c00'],
            xaxis: {
                type: 'string',
                categories: daysLabels,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var ccChart = new ApexCharts(document.querySelector("#cc_chart"), ccOptions);
        ccChart.render();
        @elseif($type=="kullanilan")
        var daysLabels = [
                @foreach(array_reverse($l15days) as $day)
                new Date({{$day}}).toLocaleDateString(),
                @endforeach
            ];
        var ucSeries = [
                @foreach(array_reverse($l15ducs) as $duc)
                {{$duc}},
                @endforeach
            ];
        var ucOptions = {
            chart: {
                height: 324,
                type: 'area',
                toolbar: false,
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                curve: 'smooth',
                width: 3,
            },
            series: [{
                name: 'Onaylanan kartı sayısı',
                data: ucSeries
            }],
            zoom: {
                enabled: false
            },
            legend: {
                show: false
            },
            colors: ['#25c2e3'],
            xaxis: {
                type: 'string',
                categories: daysLabels,
                tooltip: {
                    enabled: false
                },
                axisBorder: {
                    show: false
                },
                labels: {}

            },
            yaxis: {
                labels: {
                    formatter: function formatter(val) {
                        return val;
                    }
                }
            },
            fill: {
                type: 'gradient',
                gradient: {
                    type: "vertical",
                    shadeIntensity: 1,
                    inverseColors: false,
                    opacityFrom: 0.45,
                    opacityTo: 0.05,
                    stops: [45, 100]
                }
            }
        };
        var ucChart = new ApexCharts(document.querySelector("#uc_chart"), ucOptions);
        ucChart.render();
        @endif


    </script>
@endsection

@section('script-bottom')
    <script src="{{ URL::asset('assets/js/pages/datatables.init.js') }}"></script>
    <script src="{{ URL::asset('assets/js/pages/dropify.js') }}"></script>
@endsection
