@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan Omset Per Counter</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Report</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Laporan Omset Per Counter</a></div>
        </div>
    </div>
    @php
        $tpos_save = session('tpos_save');
    @endphp
    <div class="section-body">
        <form action="" method="GET" id="thisform">
        <div class="row">
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Header Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">                    
                                <div class="form-group">
                                    <label>Periode</label>
                                    <input type="date" class="form-control" name="dtfr" value="@php if(request('dtfr')==NULL){ echo date('Y-m-d');} else{ echo $_GET['dtfr']; } @endphp">
                                </div>                                
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>s/d</label>
                                    <input type="date" class="form-control" name="dtto" value="@php if(request('dtto')==NULL){ echo date('Y-m-d');} else{ echo $_GET['dtto']; } @endphp">
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">                    
                                <div class="form-group">
                                    <label>Counter</label>
                                    <select class="form-control select2" name="counter" id="counter">
                                        @if(request('counter') == NULL)
                                        <option disabled selected>--Select Counter--</option>
                                        @else
                                        <option selected>@php echo $_GET['counter']; @endphp</option>
                                        @endif
                                        @foreach($counters as $data => $counter)
                                        <option>{{ $counter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">                    
                                <div class="form-group">
                                    <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="/romsetcountersearch" onclick="show_loading()">View</button>
                                </div>                                
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row pb-3">
                            <div class="col-6"></div>
                            <div class="col-6 d-flex justify-content-end">
                                <button type="submit" formaction="romsetcounterexcl" formtarget="_blank" class="btn btn-success"><i
                                    class="far fa-file-excel"></i><span> Export Excel</span></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5" style="text-align: center;">No</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Nama Counter</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Total Quantity</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Total Nominal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($results)
                                    @php $counter = 0 @endphp
                                    @foreach($results as $data => $item)
                                        @php $counter++ @endphp
                                        <tr>
                                            <th scope="row" class="border border-5">{{ $counter }}</th>
                                            <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                                        </tr>
                                    @endforeach
                                    @endisset
                                </tbody>                            
                            </table>
                        </div>                                              
                    </div>      
                    <div class="col-12 col-md-6 col-lg-6 align-self-end">
                        <div class="row">
                            <div class="col-md-4">
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Quantity</label>
                                    @if(isset($totqty))
                                        @foreach ($totqty as $qty)
                                        <input type="text" class="form-control" form="thisform" value="{{ $qty->totalqty }}" readonly>
                                        @endforeach
                                    @else
                                        <input type="text" class="form-control" form="thisform" readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total</label>
                                    @if(isset($grandtot))
                                        @foreach ($grandtot as $grdtot)
                                        <input type="text" class="form-control" form="thisform" value="{{ number_format($grdtot->grandtotal, 2, '.', ',') }}" readonly>
                                        @endforeach
                                    @else
                                        <input type="text" class="form-control" form="thisform" readonly>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="card-footer text-right">
                        {{-- @if($tpos_save == 'Y')
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('transpospost') }}">Submit</button>
                        @elseif($tpos_save == 'N' || $tpos_save == null)
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('transpospost') }}" disabled>Submit</button>
                        @endif --}}
                    </div>
                </div>
            </div>
        </div>
    </form>
    </div>
</section>
@stop
@section('botscripts')
<script type="text/javascript">
    $(document).ready(function() {
        //CSRF TOKEN
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            $('.select2').select2({});

        });

        $('#datatable').DataTable({
        "ordering":false,
        "bInfo" : false,
        "bPaginate": false,
        // "searching": false
        });
    })
</script>
@endsection
