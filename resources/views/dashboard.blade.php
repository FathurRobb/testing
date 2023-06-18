@extends('layout.template')

@section('title')
    Dashboard
@endsection

@section('content')
    {{-- <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-warning card-header-icon">
                    <div class="card-icon">
                        <i class="material-icons">content_copy</i>
                    </div>
                    <p class="card-category">Used Space</p>
                    <h3 class="card-title">49/50
                        <small>GB</small>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons text-danger">warning</i>
                        <a href="javascript:;">Get More Space...</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6">
            <div class="card card-stats">
                <div class="card-header card-header-success card-header-icon">
                <div class="card-icon">
                    <i class="material-icons">store</i>
                </div>
                <p class="card-category">Revenue</p>
                <h3 class="card-title">$34,245</h3>
                </div>
                <div class="card-footer">
                <div class="stats">
                    <i class="material-icons">date_range</i> Last 24 Hours
                </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class="card card-chart">
                <div class="card-header card-header-success">
                    <div class="ct-chart" id="dailySalesChart"></div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Daily Sales</h4>
                    <p class="card-category">
                    <span class="text-success"><i class="fa fa-long-arrow-up"></i> 55% </span> increase in today sales.</p>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">access_time</i> updated 4 minutes ago
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-chart">
                <div class="card-header card-header-warning">
                    <div class="ct-chart" id="websiteViewsChart"></div>
                </div>
                <div class="card-body">
                    <h4 class="card-title">Email Subscriptions</h4>
                    <p class="card-category">Last Campaign Performance</p>
                </div>
                <div class="card-footer">
                    <div class="stats">
                        <i class="material-icons">access_time</i> campaign sent 2 days ago
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header card-header-info">
                    <h4 class="card-title float-left mb-2">Laporan Profit/Loss</h4>
                </div>
                <div class="card-body">
                    <a href="{{ route('export') }}" type="button" class="btn btn-outline-success btn-sm">
                        <i class="material-icons">print</i> Excel
                    </a>
                    <div class="table-responsive">
                        <table class="table" id="table">
                            <thead class="text-info">
                                <th>Kategori</th>
                                @foreach ($tanggals as $tanggal)
                                    <th>{{$tanggal}}</th>
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($namas as $nama)
                                    <tr>
                                        <td>{{$nama}}</td>
                                        @foreach ($recordsProfitByName[$nama] as $rpn => $val)
                                            @foreach($tanggals as $tanggal)
                                            @if ($rpn === $tanggal)
                                                <td>{{$val}}</td>    
                                            @endif
                                            @endforeach
                                        @endforeach
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="mx-auto d-block">
                    {{ $datas->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection