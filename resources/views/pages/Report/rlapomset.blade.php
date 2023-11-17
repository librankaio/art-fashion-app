@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan Omset Per Item</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Report</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Laporan Omset Per Item</a></div>
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
                        <div class="row">
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
                        </div>
                        <div class="row">
                            <div class="col-md-12">                    
                                <div class="form-group">
                                    <label>Payment Method</label>
                                    <select class="form-control select2" name="payment_mthd" id="payment_mthd">
                                        @if(request('payment_mthd') == NULL)
                                        <option selected>ALL</option>
                                        @else
                                        <option selected>@php echo $_GET['payment_mthd']; @endphp</option>
                                        @endif
                                        @foreach($payments as $payment)
                                        <option>{{ $payment->name}}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-12">                    
                                <div class="form-group">
                                    <label>Nomor Penjualan</label>
                                    <select class="form-control select2" name="no_tpenjualan" id="no_tpenjualan">
                                        @if(request('no_tpenjualan') == NULL)
                                        <option disabled selected>--Select Counter--</option>
                                        @else
                                        <option selected>@php echo $_GET['no_tpenjualan']; @endphp</option>
                                        @endif
                                        @foreach($tpenjualans as $tpenjualan)
                                        <option>{{ $tpenjualan->no}}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">                    
                                <div class="form-group">
                                    <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="/romsetitemsearch" onclick="show_loading()">View</button>
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
                                <button type="submit" formaction="romsetitemexcl" formtarget="_blank" class="btn btn-success"><i
                                    class="far fa-file-excel"></i><span> Export Excel</span></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5" style="text-align: center;">No</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">No Transaksi</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Tanggal</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Kode</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Nama Item</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Quantity</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Discount (%)</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Discount</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Subtotal Sebelum Discount</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Subtotal</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Jenis Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($results)
                                    @php $counter = 0 @endphp
                                    @php $total = 0; @endphp
                                    @php $notrans = ""; @endphp
                                    
                                    @foreach($results as $data => $item)
                                        @php $counter++ @endphp
                                        @php $total_item = (float) $item->subtotal @endphp
                                        @php $subtotal = $total + $total_item   @endphp
                                        <tr>
                                            <th scope="row" class="border border-5">{{ $counter }}</th>
                                            <td class="border border-5" style="text-align: center;">{{ $item->no }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ $item->code }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ number_format($item->diskon, 0, '.', '') }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ number_format($item->disctot, 2, '.', ',') }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotalbef, 2, '.', ',') }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ $item->payment_mthd }}</td>
                                            {{-- @if( $item->no == $notrans )
                                                <th scope="row" class="border border-5">{{ $counter }}</th>
                                                <td class="border border-5" style="text-align: center;"></td>
                                                <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->code }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->diskon, 0, '.', '') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->disctot, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotalbef, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->payment_mthd }}</td>
                                            @else
                                                <th scope="row" class="border border-5">{{ $counter }}</th>
                                                <td class="border border-5" style="text-align: center;">{{ $item->no }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->code }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->name }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->qty }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->diskon, 0, '.', '') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->disctot, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotalbef, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ number_format($item->subtotal, 2, '.', ',') }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->payment_mthd }}</td>
                                            @endif                                             --}}
                                        </tr>
                                        
                                        @php $tot_sblmdisc = $item->no; @endphp
                                        {{-- @php $notrans = $item->no; @endphp --}}
                                    @endforeach
                                    @endisset
                                </tbody>                            
                            </table>
                        </div>                                              
                    </div>      
                    <div class="col-12 col-md-6 col-lg-6 align-self-end">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Grand Total Sebelum Disc</label>
                                    @if(isset($results))
                                    @php $old_sumtot_sblmdisc = 0; @endphp
                                    @php $old_sumtot_sblmdisc_2 = 0; @endphp
                                    @php $tot_sblmdisc = 0; @endphp
                                    @foreach($results as $data => $item)
                                    @if($tot_sblmdisc == 0)
                                        @php $tot_sblmdisc = number_format($item->subtotalbef, 2, '.', '') @endphp
                                    @else
                                        @if ($old_sumtot_sblmdisc == 0)
                                            @php $old_sumtot_sblmdisc = $tot_sblmdisc + number_format($item->subtotalbef, 2, '.', '') @endphp
                                        @else
                                            @php $old_sumtot_sblmdisc_2 = $old_sumtot_sblmdisc + number_format($item->subtotalbef, 2, '.', '') @endphp
                                            @php $old_sumtot_sblmdisc = $old_sumtot_sblmdisc_2 @endphp
                                        @endif
                                    @endif
                                    @endforeach                                   
                                        <input type="text" class="form-control" form="thisform" value="{{ number_format($old_sumtot_sblmdisc, 2, '.', ',')}}" readonly>
                                    @else
                                        <input type="text" class="form-control" form="thisform" readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Quantity</label>
                                    @if(isset($results))
                                        @php $total_qty = 0; @endphp
                                        @foreach($results as $item1)
                                            @if($total_qty == 0)
                                                @php $total_qty = $total_qty + $item1->qty @endphp
                                            @else
                                                @php $total_qty = $total_qty + $item1->qty @endphp
                                            @endif
                                        @endforeach
                                            <input type="text" class="form-control" form="thisform" value="{{ $total_qty }}" readonly>
                                    @else
                                        <input type="text" class="form-control" form="thisform" readonly>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total Penjualan</label>
                                    @if(isset($results))
                                        @php $total = 0; @endphp
                                        @foreach($results as $item2)
                                            @if($total == 0)
                                                @php $total = $total + $item2->subtotal @endphp
                                            @else
                                                @php $total = $total + $item2->subtotal @endphp
                                            @endif
                                        @endforeach
                                            <input type="text" class="form-control" form="thisform" value="{{ number_format($total, 2, '.', ',') }}" readonly>
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
                        {{-- <button class="btn btn-secondary" type="reset">Reset</button> --}}
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
        // "ordering":false,
        "bInfo" : false,
        // "bPaginate": false,
        // "searching": false
        });
    })
</script>
@endsection
