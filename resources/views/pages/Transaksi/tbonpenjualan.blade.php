@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Bon Penjualan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Bon Penjualan</a></div>
        </div>
    </div>
    @php
        $tpos_save = session('tpos_save');
    @endphp
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @include('layouts.flash-message-sj')
            </div>
        </div>
        <form action="" method="POST" id="thisform">
            @csrf
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card" style="border: 1px solid lightblue">
                    <div class="card-header">
                        <h4>Add Items</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <select class="form-control" id="kode">
                                        {{-- <option disabled selected>--Select Kode--</option> --}}
                                        <option></option>
                                        {{-- @foreach($mitems as $data => $item)                                        
                                        <option value="{{ $item->code }}">{{ $item->code." - ".$item->name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" id="quantity" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input type="text" class="form-control" id="hrgjual" value="0">
                                </div>    
                                <div class="form-group">
                                    <label>Diskon (rate)</label>
                                    <input type="text" class="form-control" id="disc" value="0">
                                </div>    
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Nama Item</label>
                                    <input type="text" class="form-control" id="nama_item" disabled>
                                </div>                                
                                <div class="form-group">
                                    <label>Warna</label>
                                    <input type="text" class="form-control" id="warna" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuan" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control" id="subtot" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Keterangan</label>
                                    <textarea class="form-control" style="height:70px" id="keterangan"></textarea>
                                </div>
                                <div class="form-group">
                                    <a href="" id="addItem">
                                        <i class="fa fa-plus" style="font-size:18pt"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-4 col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Header Information</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>No Trans</label>
                                    @foreach($notrans as $key => $code)
                                        @php $codetrans = $code->codetrans @endphp
                                    @endforeach
                                    <input type="text" class="form-control" name="no" id="no" value="{{ $code->codetrans }}" readonly>
                                </div>       
                                <div class="form-group">
                                    <label>Counter</label>
                                    <select class="form-control select2" name="counter" id="counter">
                                        @if($latest_counter != null)
                                            <option selected>{{ $latest_counter->counter }}</option>
                                        @endif
                                        @foreach($counters as $counter)
                                        <option>{{ $counter->name}}</option>
                                        @endforeach
                                    </select>
                                </div>                         
                                <div class="form-group">
                                    <label>Jenis Promosi</label>
                                    <select class="form-control select2" name="jenis_promosi" id="jenis_promosi">
                                        {{-- <option disabled selected>--Select Jenis Promosi--</option> --}}
                                        <option selected>Diskon</option>
                                        <option>Special Price</option>
                                    </select>
                                </div>        
                                @if(session('privilage') != 'ADM' && session('privilage') != 'SPG DS')
                                    <div class="form-group">
                                        <label>No. Kartu</label>
                                        <input type="text" class="form-control" name="noreff" id="noreff">
                                    </div>                       
                                @endif  
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d") }}">
                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" style="height:100px" name="note"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>            
            <div class="col-12 col-md-12 col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="form-group">
                                {{-- <label>counter</label> --}}
                                <input type="text" class="form-control" id="number_counter" value="0" hidden readonly>
                            </div>
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5">No</th>
                                        <th scope="col" class="border border-5">Kode</th>
                                        <th scope="col" class="border border-5">Nama Item</th>
                                        <th scope="col" class="border border-5">Warna</th>
                                        <th scope="col" class="border border-5">Quantity</th>
                                        <th scope="col" class="border border-5">Satuan</th>
                                        <th scope="col" class="border border-5">Harga Awal</th>
                                        <th scope="col" class="border border-5">Harga</th>
                                        <th scope="col" class="border border-5">Diskon %</th>
                                        <th scope="col" class="border border-5">Total Diskon</th>
                                        <th scope="col" class="border border-5">Harga Sebelum Diskon</th>
                                        <th scope="col" class="border border-5">Harga Setelah Diskon</th>
                                        <th scope="col" class="border border-5">Subtotal</th>
                                        <th scope="col" class="border border-5">Keterangan</th>
                                        <th scope="col" class="border border-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @if ($message = Session::get('error'))
                                    
                                    @endif --}}
                                </tbody>                            
                            </table>
                        </div>                                              
                    </div>      
                    @if(session('privilage') != 'ADM')
                        <div class="col-12 col-md-12 col-lg-12 align-self-center">
                    @else
                        <div class="col-12 col-md-12 col-lg-12 d-flex justify-content-end">
                    @endif
                        <div class="row px-2">
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-6">
                                        @if(session('privilage') != 'ADM' && session('privilage') != 'SPG DS')
                                        <div class="form-group">
                                            <label>Payment Method</label>
                                            <select class="form-control select2" name="payment_mthd" id="payment_mthd">
                                                <option disabled selected>--Select Payment--</option>
                                                @foreach($payments as $payment)
                                                <option>{{ $payment->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-md-6">
                                        @if(session('privilage') != 'ADM' && session('privilage') != 'SPG DS')
                                        <div class="form-group">
                                            <label>Payment Method 2</label>
                                            <select class="form-control select2" name="payment_mthd_2" id="payment_mthd_2">
                                                <option disabled selected>--Select Payment--</option>
                                                @foreach($payments as $payment)
                                                <option>{{ $payment->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <button class="btn btn-primary mr-1" id="clear_payment2" type="button">Clear</button>
                                        @endif
                                    </div>
                                </div>
                                 
                                {{-- <div class="form-group">
                                    <label>Payment Method 2</label>
                                    <select class="form-control select2" name="payment_mthd_2" id="payment_mthd_2">
                                        <option disabled selected>--Select Payment--</option>
                                        @foreach($payments as $payment)
                                        <option>{{ $payment->name}}</option>
                                        @endforeach
                                    </select>
                                </div>  --}}
                            </div>
                            <div class="col-md-6">
                                @if(session('privilage') != 'ADM' && session('privilage') != 'SPG DS')
                               <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total Pembayaran</label>
                                            <input type="text" class="form-control" name="totbayar" form="thisform" id="totbayar" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total Pembayaran 2</label>
                                            <input type="text" class="form-control" name="totbayar_2" form="thisform" id="totbayar_2" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total Kembali</label>
                                            <input type="text" class="form-control" name="totkembali" form="thisform" id="totkembali" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total Diskon</label>
                                            <input type="text" class="form-control" name="price_disc" form="thisform" id="price_disc" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" class="form-control" name="price_total" form="thisform" id="price_total" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>Today Saldo</label>
                                            <input type="text" class="form-control" name="today_saldo" form="thisform" id="today_saldo" value="{{ $today_saldo }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>Total Sebelum Diskon</label>
                                            <input type="text" class="form-control" name="price_sebelumdisc" form="thisform" id="price_sebelumdisc" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>SPG ACCESS</label>
                                            <input type="text" class="form-control" name="spg_access" form="thisform" id="spg_access" value="{{ session('privilage') }}" readonly>
                                        </div>
                                    </div>
                               </div>
                               @else
                               <div class="row">
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>Total Pembayaran</label>
                                            <input type="text" class="form-control" name="totbayar" form="thisform" id="totbayar" value="0">
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>Total Pembayaran 2</label>
                                            <input type="text" class="form-control" name="totbayar_2" form="thisform" id="totbayar_2" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>Total Kembali</label>
                                            <input type="text" class="form-control" name="totkembali" form="thisform" id="totkembali" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Quantity</label>
                                            <input type="text" class="form-control" form="thisform" id="tot_qty" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Sebelum Diskon</label>
                                            <input type="text" class="form-control" name="price_sebelumdisc" form="thisform" id="price_sebelumdisc" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total Diskon</label>
                                            <input type="text" class="form-control" name="price_disc" form="thisform" id="price_disc" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>Total</label>
                                            <input type="text" class="form-control" name="price_total" form="thisform" id="price_total" value="0" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>Today Saldo</label>
                                            <input type="text" class="form-control" name="today_saldo" form="thisform" id="today_saldo" value="{{ $today_saldo }}" readonly>
                                        </div>
                                    </div>
                                    <div class="col-md-3" hidden>
                                        <div class="form-group">
                                            <label>SPG ACCESS</label>
                                            <input type="text" class="form-control" name="spg_access" form="thisform" id="spg_access" value="{{ session('privilage') }}" readonly>
                                        </div>
                                    </div>
                               </div>
                               @endif
                            </div>
                        </div>
                    </div>              
                    <div class="card-footer text-right">                        
                        @if(session('privilage') != 'ADM' && session('privilage') != 'SPG DS')
                            <a class="btn btn-warning mr-1" href="/tbonjuallist">List</a>
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('tbonjualpost') }}" onclick="timeout_init()" formtarget="_blank">Save</button>
                        @elseif(session('privilage') == 'SPG DS')
                            <a class="btn btn-warning mr-1" href="/tbonjuallist">List</a>
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('tbonjualpost') }}">Save</button>
                        @else
                            {{-- <a class="btn btn-warning mr-1" id="modal-list" onclick="filterlist()">List</a> --}}
                            <a class="btn btn-warning mr-1 text-light" id="modal-list" onclick="filterlist()">List</a>
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('tbonjualpost') }}">Save</button>
                        @endif
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
<!-- MODAL Input saldo awal-->
<div class="modal" tabindex="-1" id="mymodal">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">INPUT SALDO AWAL</h5>
          {{-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button> --}}
        </div>
        <form action="{{ route('msaldoawalpost') }}" method="POST">
            @csrf
            <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Tanggal</label>
                                <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d") }}">
                            </div>
                        </div>  
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Saldo</label>
                                <input type="text" class="form-control" name="saldo" id="saldo" value="{{  number_format(500000) }}">
                            </div>
                        </div>
                    </div>            
            </div>
            <div class="modal-footer">
            {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
            <button class="btn btn-primary mr-1" type="submit" id="confirm_modal" onclick="submitForm();">Save</button> 
            </div>
        </form>
      </div>
    </div>
  </div>
{{-- END MODAL --}}

<div class="modal" tabindex="-1" id="modal-list-part">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">FILTER LIST</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="{{ route('tbonjuallist') }}" method="GET">
            <div class="modal-body">
                <div class="form-group">
                    <label>Counter List</label>
                    <select class="form-control" name="counter_filter" id="counter_filter">
                        @if($latest_counter != null)
                            <option selected>{{ $latest_counter->counter }}</option>
                        @endif
                        @foreach($counters as $counter)
                        <option>{{ $counter->name}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button class="btn btn-primary mr-1" type="submit" id="confirm_modal_filter" onclick="submitFormFilter();">Search</button> 
            </div> 
        </form>
      </div>
    </div>
  </div>
{{-- MODAL INPUT FILTER LIST --}}
{{-- <form class="modal-part" id="modal-list-part" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="form-group">
        <label>Counter</label>
        <select class="form-control" name="counter_filter" id="counter_filter">
            @if($latest_counter != null)
                <option selected>{{ $latest_counter->counter }}</option>
            @endif
            @foreach($counters as $counter)
            <option>{{ $counter->name}}</option>
            @endforeach
        </select>
    </div>
  </form> --}}
{{-- END MODAL INPUT FILTER LIST --}}
@stop
@section('pluginjs')
<script src="{{ asset('assets/js/page/bootstrap-modal.js') }}"></script>
@stop
@section('botscripts')
<script type="text/javascript">
    function timeout_trigger() {
        window.location.reload();
    }

    function timeout_init() {
        setTimeout('timeout_trigger()', 3000);
    }

    function filterlist(){
        $('#modal-list-part').modal({
            backdrop: 'static',
            keyboard: true, 
            show: true,
        });
    }
    $(document).ready(function() {
        var today_saldo = $('#today_saldo').val();
        var spg_access = $('#spg_access').val();
        // console.log(spg_access);
        if(today_saldo != 'Y' && spg_access == 'SPG SR'){
            $('#mymodal').modal({
                backdrop: 'static',
                keyboard: true, 
                show: true
            });
        }

        function submitForm(){
            // alert('Form has been submitted');
            $('#confirm_modal').submit()
        }
        function submitFormFilter(){
            // alert('Form has been submitted');
            $('#confirm_modal_filter').submit()
        }

        $('#counter_filter').select2({
            dropdownParent: $('#modal-list-part')
        });

        // $("#modal-list").fireModal({
        // title: 'Login',
        // body: $("#modal-list-part"),
        // footerClass: 'bg-whitesmoke',
        // autoFocus: false,
        // onFormSubmit: function(modal, e, form) {
        //     // Form Data
        //     let form_data = $(e.target).serialize();
        //     console.log(form_data)
            
        //     // DO AJAX HERE
        //     let fake_ajax = setTimeout(function() {
        //     form.stopProgress();
        //     modal.find('.modal-body').prepend('<div class="alert alert-info">Please check your browser console</div>')

        //     clearInterval(fake_ajax);
        //     }, 1500);

        //     e.preventDefault();
        // },
        // shown: function(modal, form) {
        //     console.log(form)
        // },
        // buttons: [
        //     {
        //     text: 'Search List',
        //     submit: true,
        //     class: 'btn btn-primary btn-shadow',
        //     handler: function(modal) {
        //     }
        //     }
        // ]
        // });

        //CSRF TOKEN
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {         
            // $('.js-kode').select2({
            //     placeholder : 'Select Kode',
            //     // allowClear : true
            // });
            $("#kode").select2({
                placeholder : 'Select Kode',
                ajax: {
                    url: "{{ route('getmitemv2') }}",
                    type: "post",
                    dataType: "json",
                    delay: 250,
                    data: function (params) {
                        return {
                            _token: CSRF_TOKEN,
                            search : params.term, //search term
                        };
                    },
                    processResults: function (response) {
                        console.log(response)                  
                        return {
                            results: response,          
                        };
                    },
                    cache: true,
                }
            });
            
            $("#kode").on('select2:select', function(e) {
                var kode = $(this).val();
                console.log(kode);
                show_loading()
                $.ajax({
                    url: '{{ route('getmitem') }}', 
                    method: 'post', 
                    data: {'kode': kode}, 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                    dataType: 'json', 
                    success: function(response) {
                        // console.log(kode);
                        console.log(response);
                        for (i=0; i < response.length; i++) {
                            if(response[i].code == kode){
                                $("#nama_item").val(response[i].name)
                                hrg = Number(response[i].hrgjual);
                                $("#satuan").val(response[i].satuan);
                                $("#warna").val(response[i].warna);
                                subtotal = Number(hrg).toFixed(2) * $('#quantity').val()
                                $("#subtot").val(thousands_separators(subtotal.toFixed(2)));
                                $("#hrgjual").val(thousands_separators(hrg.toFixed(2)));
                            }
                        }
                        hide_loading()
                    }
                });
            });

            var counter = $('#number_counter').val();
            var counter_row = 0;
            $(document).on("click", "#addItem", function(e) {                
                e.preventDefault();
                if($('#quantity').val() == 0){
                    swal('WARNING', 'Quantity tidak boleh 0!', 'warning');
                    return false;
                }
                kode = $("#kode").val();
                counter_asal = $("#counter").val();
                if($("#counter").val() == 0 || $("#counter").val() == ''){
                    swal('WARNING', 'Silahkan pilih counter terlebih dahulu!', 'warning');
                    return false;
                }
                            kode = $("#select2-kode-container").text();
                            kode_id = $("#kode").val();
                            nama_item = $("#nama_item").val();
                            warna = $("#warna").val();
                            hrgjual = $("#hrgjual").val();
                            diskon = $("#disc").val();
                            quantity = $("#quantity").val();
                            satuan = $("#satuan").val();
                            subtot = $("#subtot").val();
                            keterangan = $("#keterangan").val();
                            harga_awal = '';
                            tot_qty = $('#tot_qty').val();
                            
                            // add duplicate code in qty
                            // var table   = document.getElementById('datatable');
                            // for (var i = 1; i < table.rows.length; i++) 
                            // {
                            // exist_code_row = table.rows[i].cells[2].getElementsByTagName('input')[0].value;
                            // console.log("isi input :"+ exist_code_row);
                            // if(exist_code_row == kode_id){
                            //     total_qty = $('#tot_qty').val();
                            //     var this_row_qty_val = table.rows[i].cells[5].getElementsByTagName('input')[0].value;
                            //     old_total_qty = total_qty - this_row_qty_val
                            //     $('#tot_qty').val(old_total_qty)
                            //     sum_exist_qty = Number(this_row_qty_val) +  Number(quantity);
                            //     table.rows[i].cells[5].getElementsByTagName('input')[0].value = sum_exist_qty;
                            //     normalize_tot_qty = $('#tot_qty').val();
                            //     new_tot_qty = Number(normalize_tot_qty) + Number(sum_exist_qty);
                            //     $('#tot_qty').val(new_tot_qty);
                            //     $("#kode").prop('selectedIndex', 0).trigger('change');
                            //     $("#warna").val('');
                            //     $("#nama_item").val('');
                            //     $("#hrgjual").val(0);
                            //     $("#disc").val(0);
                            //     $("#satuan").val('');
                            //     $("#quantity").val(0);
                            //     $("#merk").val('');
                            //     $("#subtot").val('');
                            //     $("#keterangan").val('');
                            //     // alert('Item yang sama ditambahkan!');
                            //     table.rows[i].cells[5].getElementsByTagName('input')[0].value = sum_exist_qty;
                            //     price_sebelumdisc = $('#price_sebelumdisc').val();
                            //     //NORMALIZE THE STR price_sebelumdisc
                            //     if (/\D/g.test(price_sebelumdisc))
                            //     {
                            //         // Filter comma
                            //         price_sebelumdisc = price_sebelumdisc.replace(/\,/g,"");
                            //         price_sebelumdisc = Number(Math.trunc(price_sebelumdisc))
                            //     }
                            //     hrg_row = table.rows[i].cells[9].getElementsByTagName('input')[0].value;
                            //     //NORMALIZE THE STR hrg_row
                            //     if (/\D/g.test(hrg_row))
                            //     {
                            //         // Filter comma
                            //         hrg_row = hrg_row.replace(/\,/g,"");
                            //         hrg_row = Number(Math.trunc(hrg_row))
                            //     }
                            //     old_price_sebelumdisc = Number(price_sebelumdisc) - Number(hrg_row)
                            //     console.log("old_price_sebelumdisc : "+old_price_sebelumdisc)
                            //     $('#price_sebelumdisc').val(old_price_sebelumdisc);

                            //     disc_row = table.rows[i].cells[10].getElementsByTagName('input')[0].value;
                            //     //NORMALIZE THE STR
                            //     if (/\D/g.test(hrg_row))
                            //     {
                            //         // Filter comma
                            //         hrg_row = hrg_row.replace(/\,/g,"");
                            //         hrg_row = Number(Math.trunc(hrg_row))
                            //     }

                            //     new_hrg_bfr_disc = Number(hrg_row) * Number(sum_exist_qty);
                            //     sum_exist_price_sebelumdisc = Number(old_price_sebelumdisc) + Number(new_hrg_bfr_disc);
                            //     $('#price_sebelumdisc').val(thousands_separators(sum_exist_price_sebelumdisc.toFixed(2)));

                            //     table.rows[i].cells[12].getElementsByTagName('input')[0].value = thousands_separators(new_hrg_bfr_disc.toFixed(2));
                            //     hrg_bfr_disc_row = table.rows[i].cells[12].getElementsByTagName('input')[0].value = thousands_separators(new_hrg_bfr_disc.toFixed(2));
                            //     new_disc_row = Number(new_hrg_bfr_disc) * disc_row/100;
                            //     table.rows[i].cells[11].getElementsByTagName('input')[0].value = thousands_separators(new_disc_row.toFixed(0));
                            //     new_hrg_aftr_disc_row = new_hrg_bfr_disc - new_disc_row
                            //     table.rows[i].cells[14].getElementsByTagName('input')[0].value = thousands_separators(new_hrg_aftr_disc_row.toFixed(0));
                            //     table.rows[i].cells[15].getElementsByTagName('input')[0].value = thousands_separators(new_hrg_aftr_disc_row.toFixed(0));
                                 
                                
                            //     console.log('harga_row : '+ hrg_row );
                            //     console.log('disc_row : '+ disc_row );
                            //     console.log('hrg_bfr_disc_row : '+ hrg_bfr_disc_row );
                            //     return false
                            // }
                            // }
                            counter++;
                            counter_row++;
                                        hrg = hrgjual
                                        if (/\D/g.test(hrg))
                                        {
                                            // Filter comma
                                            hrg = hrg.replace(/\,/g,"");
                                            hrg = Number(Math.trunc(hrg))
                                        }

                                        tot = hrg * quantity;
                                        diskon_total = (tot * diskon)/100;

                                        norm_subtot = subtot
                                        if (/\D/g.test(norm_subtot))
                                        {
                                            // Filter comma
                                            norm_subtot = norm_subtot.replace(/\,/g,"");
                                            norm_subtot = Number(Math.trunc(norm_subtot))
                                        }
                                        hrgsetdiskon = norm_subtot - diskon_total;


                                        tablerow = "<tr row_id="+ counter_row +" id='row_"+counter_row+"'><th style='readonly:true;' row_th="+ counter_row +" class='border border-5'>" + counter + "</th><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='numberclass form-control' type='text' value='" + counter_row + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode_id + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + warna + "'></td><td class='border border-5'><input style='width:120px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' type='text' value='" + quantity + "' id='qty_d_"+counter_row+"'></td><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='qtyoldclass form-control' type='text' value='" + quantity + "' id='qtyold_d_"+counter_row+"'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='satuanclass form-control' name='satuan_d[]' type='text' value='" + satuan + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='row_harga_awal harga_awalclass form-control' name='harga_awal_d[]' type='text' value='" + thousands_separators(harga_awal) + "' id='harga_awal_d_"+counter_row+"'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' type='text' value='" + hrgjual + "' id='hrgjual_d_"+counter_row+"'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='row_diskon diskonclass form-control' name='diskon_d[]' id='diskon_d_"+counter_row+"' type='text' value='" + diskon + "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='totdiscclass form-control' value='" +  thousands_separators(diskon_total) + "' name='totdisc_d[]' id='totdisc_d_"+counter_row+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='" + thousands_separators(subtot) + "' name='subtot_d[]' id='subtot_d_"+counter_row+"'></td><td class='border border-5' style='display:none;'><input style='width:120px;' readonly form='thisform' class='subtotoldclass form-control' type='text' value='" + thousands_separators(subtot) + "' id='subtotold_d_"+counter_row+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='hrgsetdiscclass form-control' value='" +  thousands_separators(hrgsetdiskon) + "' name='hrgsetdisc_d[]' id='hrgsetdisc_d_"+counter_row+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotfinalclass form-control' value='" + thousands_separators(hrgsetdiskon) + "' name='subtotfinal_d[]' id='subtotfinal_d_"+counter_row+"'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='keteranganclass form-control' name='keterangan_d[]' type='text' value='" + keterangan + "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                                        
                                        subtotparse = subtot.replaceAll(",", "");
                                        $("#datatable tbody").append(tablerow);
                                        if(counter == 1){
                                            if (/\D/g.test(subtot))
                                            {
                                                // Filter comma
                                                subtot = subtot.replace(/\,/g,"");
                                                subtot = Number(Math.trunc(subtot))
                                            }
                                            disc = subtot * ($("#disc").val() / 100);
                                            total =  (subtot - disc);

                                            grandtot = total;

                                            total_sebelum_disc = grandtot + disc;
                                            $('#price_sebelumdisc').val(thousands_separators(total_sebelum_disc));

                                            totbayar_1 = $('#totbayar').val();
                                            if (/\D/g.test(totbayar_1))
                                            {
                                                // Filter comma
                                                totbayar_1 = totbayar_1.replace(/\,/g,"");
                                                totbayar_1 = Number(Math.trunc(totbayar_1))
                                            }
                                            totbayar_2 = $('#totbayar_2').val();
                                            if (/\D/g.test(totbayar_2))
                                            {
                                                // Filter comma
                                                totbayar_2 = totbayar_2.replace(/\,/g,"");
                                                totbayar_2 = Number(Math.trunc(totbayar_2))
                                            }

                                            grandtotal_bayar = parseFloat(totbayar_1) + parseFloat(totbayar_2);

                                            kembali = grandtotal_bayar - grandtot;
                                            
                                            $("#totkembali").val(thousands_separators(kembali));
                                            $("#price_disc").val(thousands_separators(disc));
                                            $("#price_total").val(thousands_separators(grandtot.toFixed(2)));
                                        }else{
                                            if (/\D/g.test(subtot))
                                            {
                                                // Filter comma
                                                subtot = subtot.replace(/\,/g,"");
                                                subtot = Number(Math.trunc(subtot))
                                            }

                                            old_grandtot = $("#price_total").val();
                                            if (/\D/g.test(old_grandtot))
                                            {
                                                // Filter comma
                                                old_grandtot = old_grandtot.replace(/\,/g,"");
                                                old_grandtot = Number(Math.trunc(old_grandtot))
                                            }

                                            disc_old = $("#price_disc").val()
                                            if (/\D/g.test(disc_old))
                                            {
                                                // Filter comma
                                                disc_old = disc_old.replace(/\,/g,"");
                                                disc_old = Number(Math.trunc(disc_old))
                                            }

                                            disc = subtot * (parseFloat($("#disc").val()) / 100);

                                            console.log("disc" + disc)

                                            disc_new = parseFloat(disc_old) + disc;
                                            console.log("Disc New : ",disc_new);
                                            total =  (subtot - disc);
                                            subtot_new = old_grandtot + total;

                                            total_sebelum_disc = subtot_new + disc_new;
                                            $('#price_sebelumdisc').val(thousands_separators(total_sebelum_disc.toFixed(2)));

                                            totbayar_1 = $('#totbayar').val();
                                            if (/\D/g.test(totbayar_1))
                                            {
                                                // Filter comma
                                                totbayar_1 = totbayar_1.replace(/\,/g,"");
                                                totbayar_1 = Number(Math.trunc(totbayar_1))
                                            }
                                            totbayar_2 = $('#totbayar_2').val();
                                            if (/\D/g.test(totbayar_2))
                                            {
                                                // Filter comma
                                                totbayar_2 = totbayar_2.replace(/\,/g,"");
                                                totbayar_2 = Number(Math.trunc(totbayar_2))
                                            }

                                            grandtotal_bayar = parseFloat(totbayar_1) + parseFloat(totbayar_2);

                                            kembali = grandtotal_bayar - subtot_new;
                                            
                                            $("#totkembali").val(thousands_separators(kembali));
                                            $("#price_disc").val(thousands_separators(disc_new));
                                            $("#price_total").val(thousands_separators(subtot_new.toFixed(2)));
                                        }
                                        $('#number_counter').val(counter)
                                        console.log("Tot QTY : "+tot_qty+" qty : "+quantity);
                                        tot_qty_new = Number(tot_qty) + Number(quantity);
                                        $("#tot_qty").val(tot_qty_new);
                                        $("#kode").prop('selectedIndex', 0).trigger('change');
                                        $("#warna").val('');
                                        $("#nama_item").val('');
                                        $("#hrgjual").val(0);
                                        $("#disc").val(0);
                                        $("#satuan").val('');
                                        $("#quantity").val(0);
                                        $("#merk").val('');
                                        $("#subtot").val('');
                                        $("#keterangan").val('');
                                        hide_loading()
            });

            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                var r = confirm("Delete Transaksi ?");
                if (r == true) {
                    // counter_id = $(this).closest('tr').text();
                    // counter_id = $('td').find('.numberclass').val();
                    counter_id = $(this).closest('tr').find('.numberclass').val();
                    console.log(counter_id);
                    // console.log('counter_id = ' + counter_id);
                    // counter_id = $(this).closest('[row_id]').text();
                    // console.log('counter_id = ' + counter_id_v2);
                    // counter_id = $(this).closest('[row_th]').text();
                    // console.log(counter_id);
                    // console.log("TEST Number: "+counter_id);
                    // counter = $(this).closest('.row_qty').val();
                    subtot = $("#subtot_d_"+ counter_id).val().replaceAll(",", "");
                    qty_row = $("#qty_d_"+ counter_id).val();
                    // console.log(counter_id);
                    // console.log(qty_row);
                    grand_qty =  $("#tot_qty").val()
                    total_qty = Number(grand_qty) - Number(qty_row);
                    // console.log("qty value :"+qty_row);
                    $("#tot_qty").val(total_qty);

                    if (/\D/g.test(subtot))
                    {
                        // Filter comma
                        subtot = subtot.replace(/\,/g,"");
                        subtot = Number(Math.trunc(subtot))
                    }

                    old_grandtot = $("#price_total").val();

                    if (/\D/g.test(old_grandtot))
                    {
                        // Filter comma
                        old_grandtot = old_grandtot.replace(/\,/g,"");
                        old_grandtot = Number(Math.trunc(old_grandtot))
                    }

                    old_disc = $("#price_disc").val();

                    if (/\D/g.test(old_disc))
                    {
                        // Filter comma
                        old_disc = old_disc.replace(/\,/g,"");
                        old_disc = Number(Math.trunc(old_disc))
                    }
                    discrow = $("#totdisc_d_"+ counter_id).val();
                    console.log("discrow id = "+counter_id);
                    if (/\D/g.test(discrow))
                    {
                        // Filter comma
                        discrow = discrow.replace(/\,/g,"");
                        discrow = Number(Math.trunc(discrow))
                    }
                    new_disc = Number(old_disc) - Number(discrow);
                    console.log("discrow = "+discrow);
                    console.log("Total Discount baru = "+new_disc);
                    total_row = subtot - discrow;

                    price_totsebelumdisc = $("#price_sebelumdisc").val();
                    if (/\D/g.test(price_totsebelumdisc))
                    {
                        // Filter comma
                        price_totsebelumdisc = price_totsebelumdisc.replace(/\,/g,"");
                        price_totsebelumdisc = Number(Math.trunc(price_totsebelumdisc))
                    }

                    totsebelumdisc_new = price_totsebelumdisc - subtot;
                    $('#price_sebelumdisc').val(thousands_separators(totsebelumdisc_new.toFixed(2)));

                    price_setelahdisc_row = $('#subtotfinal_d_'+counter_id).val();
                    console.log("price_setelahdisc_row id = "+counter_id);
                    if (/\D/g.test(price_setelahdisc_row))
                    {
                        // Filter comma
                        price_setelahdisc_row = price_setelahdisc_row.replace(/\,/g,"");
                        price_setelahdisc_row = Number(Math.trunc(price_setelahdisc_row))
                    }
                    new_grantot = Number(old_grandtot) - Number(price_setelahdisc_row);
                    // disc = subtot * ( / 100);
                    // totaldisc = old_disc - disc;
                    // totalwithdisc = (subtot) - disc;
                    // total =  old_grandtot - totalwithdisc;
                    totbayar = $("#totbayar").val();
                    if (/\D/g.test(totbayar))
                    {
                        // Filter comma
                        totbayar = totbayar.replace(/\,/g,"");
                        totbayar = Number(Math.trunc(totbayar))
                    }
                    totbayar_2 = $("#totbayar_2").val();
                    if (/\D/g.test(totbayar_2))
                    {
                        // Filter comma
                        totbayar_2 = totbayar_2.replace(/\,/g,"");
                        totbayar_2 = Number(Math.trunc(totbayar_2))
                    }
                    grantot_bayar = Number(totbayar) + Number(totbayar_2)
                    console.log("grantot_bayar : "+ grantot_bayar)
                    console.log("new_grantot : "+ new_grantot)
                    // total_baru = Number(old_grandtot) - Number(new_grantot)

                    // total_kembali =  Number(grantot_bayar) - Number(total_baru)
                    total_kembali =  Number(grantot_bayar) - Number(new_grantot)

                    $("#totkembali").val(thousands_separators(total_kembali));
                    $("#price_disc").val(thousands_separators(new_disc));
                    $("#price_total").val(thousands_separators(new_grantot.toFixed(2)));

                    var table   = document.getElementById('datatable');
                    for (var i = 1; i < table.rows.length; i++) 
                    {
                    var firstCol = table.rows[i].cells[0];
                    firstCol.innerText = i;
                    }
                    counter--;
                    $('#number_counter').val(counter)
                    $(this).closest('tr').remove();
                } else {
                    return false;
                }
            });

            $(document).on("change", "#jenis_promosi", function(e) {
                isi = this.value

                if(isi == 'Special Price'){
                    $("#disc").val(0);
                    $("#disc").prop('readonly', true); 
                }else{
                    $("#disc").prop('readonly', false);
                }
            });

            $(document).on("change", "#quantity", function(e) {
                if($('#quantity').val() == ''){
                    $('#quantity').val(0);
                }
                hrg = $('#hrgjual').val();
                if (/\D/g.test(hrg))
                {
                    // Filter comma
                    hrg = hrg.replace(/\,/g,"");
                    hrg = Number(Math.trunc(hrg))
                }
                console.log(hrg);
                var qty = this.value
                var total = parseInt(hrg) * parseInt(qty);               
                $("#subtot").val(thousands_separators(total.toFixed(2)));
            });
            $(document).on("change", "#totbayar", function(e) {
                if($('#totbayar').val() == 0){
                    $('#totbayar').val();
                }else if($('#totbayar').val() == ''){
                    $('#totbayar').val(0);
                }

                grandtot = $('#price_total').val();
                if (/\D/g.test(grandtot))
                {
                    // Filter comma
                    grandtot = grandtot.replace(/\,/g,"");
                    grandtot = Number(Math.trunc(grandtot))
                }
                totbayar_2 = $('#totbayar_2').val();
                if (/\D/g.test(totbayar_2))
                {
                    // Filter comma
                    totbayar_2 = totbayar_2.replace(/\,/g,"");
                    totbayar_2 = Number(Math.trunc(totbayar_2))
                }

                total_bayar = parseFloat(this.value) + parseFloat(totbayar_2);
                kembali = total_bayar - grandtot;

                parse_totbayar = this.value;
                $("#totbayar").val(thousands_separators(parse_totbayar));
                $("#totkembali").val(thousands_separators(kembali));
                                
                if(kembali < 0){
                    swal('WARNING', 'Pembayaran tidak boleh kurang!', 'warning');
                    // $("#totbayar").val(0);
                    // $("#totkembali").val(0);
                    return false;
                }
            });

            $(document).on("change", "#payment_mthd_2", function(e) {
                payment_method_2 = $("#payment_mthd_2").prop('selectedIndex');
                console.log(payment_method_2);
                if(payment_method_2 >= 0){
                    $("#totbayar_2").val(0);
                    $("#totbayar_2").prop('readonly', false); 
                }else{
                    $("#totbayar_2").prop('readonly', true);
                }
            });

            $(document).on("click", "#clear_payment2", function(e) {
                $("#payment_mthd_2").prop('selectedIndex', 0).trigger('change');
            });

            $(document).on("change", "#totbayar_2", function(e) {
                if($('#totbayar_2').val() == 0){
                    $('#totbayar_2').val();
                }else if($('#totbayar_2').val() == ''){
                    $('#totbayar_2').val(0);
                }

                grandtot = $('#price_total').val();
                if (/\D/g.test(grandtot))
                {
                    // Filter comma
                    grandtot = grandtot.replace(/\,/g,"");
                    grandtot = Number(Math.trunc(grandtot))
                }
                totbayar_1 = $('#totbayar').val();
                if (/\D/g.test(totbayar_1))
                {
                    // Filter comma
                    totbayar_1 = totbayar_1.replace(/\,/g,"");
                    totbayar_1 = Number(Math.trunc(totbayar_1))
                }

                total_bayar = parseFloat(this.value) + parseFloat(totbayar_1);
                kembali = total_bayar - grandtot;

                parse_totbayar = this.value;
                $("#totbayar_2").val(thousands_separators(parse_totbayar));
                $("#totkembali").val(thousands_separators(kembali));
                                
                if(kembali < 0){
                    swal('WARNING', 'Pembayaran tidak boleh kurang!', 'warning');
                    // $("#totbayar").val(0);
                    // $("#totkembali").val(0);
                    return false;
                }
            });
            $(document).on("change", "#disc", function(e) {
                if($('#disc').val() == ''){
                    $('#disc').val(0);
                }
                if($('#disc').val() >= 100){
                    swal('WARNING', 'Diskon tidak bisa 100% / Lebih', 'warning');
                    $('#disc').val(0);
                    return false;
                }
            });

            $(document).on("change", "#hrgjual", function(e) {
                if($('#hrgjual').val() == ''){
                    $('#hrgjual').val(0);
                }
                $(this).val(thousands_separators($(this).val()));
                hrgparse = $('#hrgjual').val();
                if (/\D/g.test(hrgparse))
                {
                    // Filter comma
                    hrgparse = hrgparse.replace(/\,/g,"");
                    hrgparse = Number(Math.trunc(hrgparse))
                }
                var hrg = Number(hrgparse).toFixed(2);
                var qty = Number($("#quantity").val()).toFixed(2);
                var total = Number(hrg) * Number(qty);
                console.log(total);
            
                $("#subtot").val(thousands_separators(total.toFixed(2)));
            });
        });
        // VALIDATE TRIGGER
        $("#quantity").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#disc").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#totbayar").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#totbayar_2").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $(document).on("click", "#hrgjual", function(e) {
            if (/\D/g.test(this.value))
            {
                // Filter comma
                this.value = this.value.replace(/\,/g,"");
                this.value = Number(Math.trunc(this.value))
            }
        });

        $(document).on("click", "#totbayar", function(e) {
            if (/\D/g.test(this.value))
            {
                // Filter comma
                this.value = this.value.replace(/\,/g,"");
                this.value = Number(Math.trunc(this.value))
            }
        });
        $(document).on("click", "#totbayar_2", function(e) {
            if (/\D/g.test(this.value))
            {
                // Filter comma
                this.value = this.value.replace(/\,/g,"");
                this.value = Number(Math.trunc(this.value))
            }
        });

        $(document).on("click","#confirm",function(e){
            // Validate ifnull
            no = $("#no").val();
            code_cust = $("#code_cust").prop('selectedIndex');
            payment_method = $("#payment_mthd").prop('selectedIndex');
            if (spg_access != 'ADM'){
                if (no == ""){
                swal('WARNING', 'No Tidak boleh kosong!', 'warning');
                return false;
                }else if (code_cust == 0){
                    swal('WARNING', 'Please select Code Cust', 'warning');
                    return false;
                }else if (payment_method == 0){
                    swal('WARNING', 'Please select Jenis Payment', 'warning');
                    return false;
                }
            }
            show_loading()
            
        });

        $(document).on('keyup', '.row_qty', function(event) {
                event.preventDefault(); 
                if (/\D/g.test(this.value)){
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
        });

        $(document).on('focusout', '.row_qty', function(event) {
            event.preventDefault();

            console.log("focus out");
            var tbl_row = $(this).closest('tr');
            var row_id = tbl_row.attr('row_id');

            this_row_subtot = $('#subtot_d_'+row_id).val();
            console.log("subtot : "+this_row_subtot);
            if (/\D/g.test(this_row_subtot))
            {
                // Filter comma
                this_row_subtot = this_row_subtot.replace(/\,/g,"");
                this_row_subtot = Number(Math.trunc(this_row_subtot))
            }

            head_total = $('#price_total').val();
            console.log("total : "+head_total);
            if (/\D/g.test(head_total))
            {
                    // Filter comma
                    head_total = head_total.replace(/\,/g,"");
                    head_total = Number(Math.trunc(head_total))
            }

            head_disc = $('#price_disc').val();
            console.log("disc : "+head_disc);
            if (/\D/g.test(head_disc))
            {
                    // Filter comma
                    head_disc = head_disc.replace(/\,/g,"");
                    head_disc = Number(Math.trunc(head_disc))
            }


            this_row_qty = $(this).val();

            this_row_hrg = $('#hrgjual_d_'+row_id).val();
            if (/\D/g.test(this_row_hrg))
            {
                // Filter comma
                this_row_hrg = this_row_hrg.replace(/\,/g,"");
                this_row_hrg = Number(Math.trunc(this_row_hrg))
            }

            this_row_diskon = $('#diskon_d_'+row_id).val();

            this_row_old_diskon = $('#totdisc_d_'+row_id).val();
            if (/\D/g.test(this_row_old_diskon))
            {
                // Filter comma
                this_row_old_diskon = this_row_old_diskon.replace(/\,/g,"");
                this_row_old_diskon = Number(Math.trunc(this_row_old_diskon))
            }


            // INITIAL VARIABLE END

            // FIND THIS ROW OLD DISC and Total
            this_row_sum = this_row_hrg * this_row_qty; 
            this_row_totdisc = (this_row_sum * this_row_diskon)/100;
            this_row_total = this_row_subtot - this_row_old_diskon;

            this_row_subtot = this_row_sum - this_row_totdisc

            console.log("this_row_total " + this_row_total)

            $('#hrgsetdisc_d_'+row_id).val(thousands_separators(this_row_subtot.toFixed(2)));
            $('#subtotfinal_d_'+row_id).val(thousands_separators(this_row_subtot.toFixed(2)));
            $('#subtot_d_'+row_id).val(thousands_separators(this_row_sum.toFixed(2)));
            console.log("this row price sum :"+ this_row_sum)
            console.log("this row price discounted :"+ this_row_totdisc)

            // Mins Old Total Disc, total and This row Old disc, total
            old_total_disc_mins = head_disc - this_row_old_diskon;
            old_total_price_mins = head_total - this_row_total;
            console.log("old_total_disc_mins :" +old_total_disc_mins);
            console.log("old_total_price_mins :" +old_total_price_mins);
            $('#price_disc').val(thousands_separators(old_total_disc_mins.toFixed(2)))
            $('#price_total').val(thousands_separators(old_total_price_mins.toFixed(2)))

            // New Total disc and This row New disc
            $('#totdisc_d_'+row_id).val(thousands_separators(this_row_totdisc.toFixed(2)));

            console.log(this_row_totdisc)
            console.log(old_total_disc_mins)
            // This Row New disc
            this_row_new_disc = old_total_disc_mins + this_row_totdisc
            $('#price_disc').val(thousands_separators(this_row_new_disc.toFixed(2)))

            new_total_price = $('#totdisc_d_'+row_id).val();
            if (/\D/g.test(new_total_price))
            {
                    // Filter comma
                    new_total_price = new_total_price.replace(/\,/g,"");
                    new_total_price = Number(Math.trunc(new_total_price))
            }

            // Find total price row
            total_price_new = this_row_sum - new_total_price
            this_row_new_total = old_total_price_mins + total_price_new
            $('#price_total').val(thousands_separators(this_row_new_total.toFixed(2)))

            var counter = $('#number_counter').val();
            old_tot_qty = $('#tot_qty').val();
            old_totpricedisc = $('#price_sebelumdisc').val();
            if (/\D/g.test(old_totpricedisc))
            {
                    // Filter comma
                    old_totpricedisc = old_totpricedisc.replace(/\,/g,"");
                    old_totpricedisc = Number(Math.trunc(old_totpricedisc))
            }

            // console.log("this row qty : "+this_row_qty);
            console.log("this row sebelum_dsc : "+this_row_sum);
            if(counter > 1){
                total_old_qty_row = $('#qtyold_d_'+row_id).val()
                
                // console.log("total_old_qty_row : "+total_old_qty_row);
                // console.log("tot_qty : "+old_tot_qty);
                
                current_qty = Number(old_tot_qty) - Number(total_old_qty_row);
                // console.log("current qty :"+current_qty);
                current_tot_qty = $('#tot_qty').val(current_qty)
                new_total_qty = Number(this_row_qty) + Number(current_qty);
                $('#qtyold_d_'+row_id).val(this_row_qty)
                
                // console.log("current qty :"+this_row_qty);
                $('#tot_qty').val(new_total_qty);

                total_old_pricedisc_row = $('#subtotold_d_'+row_id).val()
                if (/\D/g.test(total_old_pricedisc_row))
                {
                        // Filter comma
                        total_old_pricedisc_row = total_old_pricedisc_row.replace(/\,/g,"");
                        total_old_pricedisc_row = Number(Math.trunc(total_old_pricedisc_row))
                }
                console.log("total_old_sblmdisc_row : "+total_old_pricedisc_row);
                console.log("tot_sblmdisc : "+old_totpricedisc);

                this_row_sum = $('#subtot_d_'+row_id).val()
                if (/\D/g.test(this_row_sum))
                {
                        // Filter comma
                        this_row_sum = this_row_sum.replace(/\,/g,"");
                        this_row_sum = Number(Math.trunc(this_row_sum))
                }

                current_pricedisc = Number(old_totpricedisc) - Number(total_old_pricedisc_row);

                console.log("current price disc :"+current_pricedisc);

                current_tot_pricedisc = $('#price_sebelumdisc').val(current_pricedisc)
                new_total_pricedisc = Number(this_row_sum) + Number(current_pricedisc);
                $('#subtotold_d_'+row_id).val(thousands_separators(this_row_sum.toFixed(2)))

                $('#price_sebelumdisc').val(thousands_separators(new_total_pricedisc.toFixed(2)));

                ///DISCOUNT CHANGES
                tot_bayar1 = $('#totbayar').val()
                // Normalization tot_bayar1
                if (/\D/g.test(tot_bayar1))
                {
                    // Filter comma
                    tot_bayar1 = tot_bayar1.replace(/\,/g,"");
                    tot_bayar1 = Number(Math.trunc(tot_bayar1))
                }
                tot_bayar2 = $('#totbayar_2').val()
                // Normalization tot_bayar2
                if (/\D/g.test(tot_bayar2))
                {
                    // Filter comma
                    tot_bayar2 = tot_bayar2.replace(/\,/g,"");
                    tot_bayar2 = Number(Math.trunc(tot_bayar2))
                }

                grand_tot_bayar = Number(tot_bayar1) + Number(tot_bayar2);

                price_tot = $('#price_total').val()
                // Normalization price_tot
                if (/\D/g.test(price_tot))
                {
                    // Filter comma
                    price_tot = price_tot.replace(/\,/g,"");
                    price_tot = Number(Math.trunc(price_tot))
                }

                tot_kembali = Number(price_tot) * -1

                if(tot_kembali < price_tot){
                    kembali = Number(grand_tot_bayar) + Number(tot_kembali)

                    $('#totkembali').val(thousands_separators(kembali.toFixed(2)));
                }else{
                    kembali = Number(grand_tot_bayar) - Number(tot_kembali)

                    $('#totkembali').val(thousands_separators(kembali.toFixed(2)));
                }

            }else if(counter == 1){
                console.log(counter);
                old_tot_qty = $('#tot_qty').val(this_row_qty);
                old_tot_pricedisc = $('#price_sebelumdisc').val(thousands_separators(this_row_sum.toFixed(2)));
                price_tot = $('#price_total').val()
                
                ///DISCOUNT CHANGES
                tot_bayar1 = $('#totbayar').val()
                // Normalization tot_bayar1
                if (/\D/g.test(tot_bayar1))
                {
                    // Filter comma
                    tot_bayar1 = tot_bayar1.replace(/\,/g,"");
                    tot_bayar1 = Number(Math.trunc(tot_bayar1))
                }
                tot_bayar2 = $('#totbayar_2').val()
                // Normalization tot_bayar2
                if (/\D/g.test(tot_bayar2))
                {
                    // Filter comma
                    tot_bayar2 = tot_bayar2.replace(/\,/g,"");
                    tot_bayar2 = Number(Math.trunc(tot_bayar2))
                }

                grand_tot_bayar = Number(tot_bayar1) + Number(tot_bayar2);

                price_tot = $('#price_total').val()
                // Normalization price_tot
                if (/\D/g.test(price_tot))
                {
                    // Filter comma
                    price_tot = price_tot.replace(/\,/g,"");
                    price_tot = Number(Math.trunc(price_tot))
                }

                tot_kembali = Number(price_tot) * -1

                if(tot_kembali < price_tot){
                    kembali = Number(grand_tot_bayar) + Number(tot_kembali)

                    $('#totkembali').val(thousands_separators(kembali.toFixed(2)));
                }else{
                    kembali = Number(grand_tot_bayar) - Number(tot_kembali)

                    $('#totkembali').val(thousands_separators(kembali.toFixed(2)));
                }
            }
        })	
        
    })

</script>
@endsection
