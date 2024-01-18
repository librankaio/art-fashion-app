@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Pembelian Barang Edit</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Pembelian Barang Edit</a></div>
        </div>
    </div>
    @php
        $tpos_save = session('tpos_save');
    @endphp
    <div class="section-body">
        <form action="" method="POST" id="thisform">
            @csrf
        <div class="row">
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
                                    {{-- @foreach($notrans as $key => $code)
                                        @php $codetrans = $code->codetrans @endphp
                                    @endforeach --}}
                                    <input type="text" class="form-control" name="no" id="no" value="{{ $tpembelianh->no }}" readonly>
                                </div>       
                                <div class="form-group">
                                    <label>Supplier</label>
                                    <input type="text" class="form-control" name="supplier" id="supplier" value="{{ $tpembelianh->supplier }}">
                                </div>                         
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d", strtotime($tpembelianh->tgl)) }}">
                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" style="height:100px" name="note">{{$tpembelianh->note}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                                    <select class="form-control select2" id="kode">
                                        <option></option>
                                        {{-- @foreach($mitems as $data => $item)                                        
                                        <option value="{{ $item->code }}">{{ $item->code." - ".$item->name }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Item</label>
                                    <input type="text" class="form-control" id="nama_item" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" id="quantity" value="0">
                                </div>                                                                   
                                <div class="form-group">
                                    <a href="" id="addItem">
                                        <i class="fa fa-plus" style="font-size:18pt"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Warna</label>
                                    <input type="text" class="form-control" id="warna" readonly>
                                    {{-- <select class="form-control select2" id="warna">
                                        <option disabled selected>--Select Warna--</option>
                                        @foreach($mwarnas as $data => $item)                                        
                                        <option value="{{ $item->code }}">{{ $item->code." - ".$item->name }}</option>
                                        @endforeach
                                    </select> --}}
                                </div>  
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuan" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Harga Beli</label>
                                    <input type="text" class="form-control" id="hrgbeli" value="0">
                                </div>   
                                <div class="form-group">
                                    <label>Harga Jual</label>
                                    <input type="text" class="form-control" id="hrgjual" value="0">
                                </div>  
                                <div class="form-group">
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control" id="subtot" readonly>
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
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5">No</th>
                                        <th scope="col" class="border border-5">Kode</th>
                                        <th scope="col" class="border border-5">Nama Item</th>
                                        <th scope="col" class="border border-5">Warna</th>
                                        <th scope="col" class="border border-5">Quantity</th>
                                        <th scope="col" class="border border-5">Satuan</th>
                                        <th scope="col" class="border border-5">Harga Beli</th>
                                        <th scope="col" class="border border-5">Harga Jual</th>
                                        <th scope="col" class="border border-5">Subtotal Harga</th>
                                        <th scope="col" class="border border-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0; @endphp
                                    @for($i = 0; $i < sizeof($tpembeliands); $i++) @php $counter++; @endphp 
                                        <tr row_id="{{$counter}}" id='row_id_{{$counter}}'>
                                            <th class="id-header border border-5" style='readonly:true;' headers="{{ $counter }}">{{ $counter }}</th>
                                            <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='{{ $tpembeliands[$i]->code }}'></td>
                                            <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='nama_item_d[]' type='text' value='{{ $tpembeliands[$i]->name }}'></td>
                                            <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='{{ $tpembeliands[$i]->warna }}'></td>
                                            <td class="border border-5"><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' id='qty_d_{{ $counter }}' value='{{ number_format($tpembeliands[$i]->qty, 0, '.', '') }}'></td>
                                            <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='{{ $tpembeliands[$i]->satuan }}' name='satuan_d[]'></td>
                                            <td class="border border-5"><input type='text' form='thisform' style='width:100px;' class='row_hrgbeli hrgbeliclass form-control' value='{{ number_format($tpembeliands[$i]->hrgbeli, 2, '.', ',') }}' name='hrgbeli_d[]' id='hrgbeli_d_{{ $counter }}'></td>
                                            <td class="border border-5"><input type='text' form='thisform' style='width:100px;' class='row_hrgjual hrgjualclass form-control' value='{{ number_format($tpembeliands[$i]->hrgjual, 2, '.', ',') }}' name='hrgjual_d[]' id='hrgjual_d_{{ $counter }}'></td>
                                            <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='{{ number_format($tpembeliands[$i]->subtotal, 2, '.', ',') }}' name='subtot_d[]' id='subtot_d_{{ $counter }}'></td>
                                            <td class="border border-5"><button title='Delete' class='delete btn btn-primary' value="{{ $counter }}"><i style='font-size:15pt;color:#ffff;' class='fa fa-trash'></i></button></td>
                                            <td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value=''></td>
                                            <td class="border border-5" hidden><input style='width:120px;' readonly form='thisform' class='idclass form-control' name='id_d[]' type='text' value='{{ $tpembeliands[$i]->id }}' id="tbl_detail_id_{{ $counter }}"></td>
                                            <td class="border border-5" hidden><input style='width:120px;' readonly form='thisform' class='delclass form-control' name='deleted_item_d[]' type='text' value='' id="deleted_d_{{ $counter }}"></td>
                                            <td class="border border-5" hidden><input style='width:120px;' readonly form='thisform' class='existdbclass form-control' name='existdb_d[]' type='text' value='{{ $tpembeliands[$i]->id }}' id="existdb_{{ $counter }}"></td>
                                        </tr>
                                    @endfor
                                </tbody>                            
                            </table>
                        </div>                                              
                    </div>      
                    <div class="col-12 col-md-6 col-lg-6 align-self-end">
                        <div class="row">
                            <div class="col-md-8">
                                
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Total</label>
                                    <input type="text" class="form-control" name="price_total" form="thisform" id="price_total" value="{{ number_format($tpembelianh->grdtotal, 2, '.', ',') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="/tpembelianbarang/{{ $tpembelianh->id }}">Update</button>
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
                                $("#satuan").val(response[i].satuan);
                                $("#warna").val(response[i].warna);
                            }
                        }
                        hide_loading()
                    }
                });
            });

            var counter = parseInt({{ $counter}}) +1;
            $(document).on("click", "#addItem", function(e) {
                e.preventDefault();
                if($('#quantity').val() == 0){
                    alert('Quantity tidak boleh 0');
                    return false;
                }

                kode = $("#select2-kode-container").text();
                warna = $("#warna").val();
                kode_id = $("#kode").val();
                nama_item = $("#nama_item").val();
                hrgbeli = $("#hrgbeli").val();
                hrgjual = $("#hrgjual").val();
                quantity = $("#quantity").val();
                satuan = $("#satuan").val();
                subtot = $("#subtot").val();


                tablerow = "<tr row_id="+ counter +"><th style='readonly:true;' class='border border-5'>" + counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='nama_item_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + warna + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" + quantity + "' id='qty_d_"+counter+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" + satuan + "' name='satuan_d[]'></td><td class='border border-5'><input type='text' form='thisform' style='width:100px;' class='row_hrgbeli hrgbeliclass form-control' value='" + hrgbeli + "' name='hrgbeli_d[]' id='hrgbeli_d_"+counter+"'></td><td class='border border-5'><input type='text' form='thisform' style='width:100px;' class='row_hrgjual hrgjualclass form-control' value='" + hrgjual + "' name='hrgjual_d[]' id='hrgjual_d"+ counter +"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='" + subtot + "' name='subtot_d[]' id='subtot_d_"+counter+"'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td><td class='border border-5' hidden><input style='width:120px;' readonly form='thisform' class='idclass form-control' name='id_d[]' type='text' value='new_item' id='tbl_detail_id_'"+ counter +"></td><td class='border border-5' hidden><input style='width:120px;' readonly form='thisform' class='delclass form-control' name='deleted_item_d[]' type='text' id='deleted_d_'"+ counter +"></td></tr>";
                
                subtotparse = subtot.replaceAll(",", "");
                $("#datatable tbody").append(tablerow);
                if(counter == 1){
                    if (/\D/g.test(subtot))
                    {
                        // Filter comma
                        subtot = subtot.replace(/\,/g,"");
                        subtot = Number(Math.trunc(subtot))
                    }
                    grandtot = subtot;

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
                    
                    console.log("subtotal: " + subtot + ", grandtot: " + old_grandtot);
                    sum = subtot + old_grandtot;

                    $("#price_total").val(thousands_separators(sum.toFixed(2)));
                }
                counter++;
                $("#kode").prop('selectedIndex', 0).trigger('change');
                $("#nama_item").val('');
                $("#warna").val('');
                $("#hrgbeli").val(0);
                $("#hrgjual").val(0);
                $("#quantity").val(0);
                $("#satuan").val('');
                $("#subtot").val('');
            });

            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                counter_id = $(this).val();
                var r = confirm("Delete Transaksi ?");
                if (r == true) {
                    if(counter_id != 0){
                        console.log(counter_id);
                        subtot = $("#subtot_d_" + counter_id).val().replaceAll(",", "");

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

                        sum = old_grandtot - subtot;

                        $("#price_total").val(thousands_separators(sum.toFixed(2)));
                        // $(this).closest('tr').remove();
                        // $('#row_id_' + counter_id).hidden = true;
                        id_detail = $("#tbl_detail_id_"+counter_id).val()
                        $("#deleted_d_" + counter_id).val(id_detail);
                        $(this).closest('tr').hide();

                        $(this).closest('tr').wrap('<div/>');

                        var table   = document.getElementById('datatable');
                        for (var i = 1; i < table.rows.length; i++) 
                        {
                        var firstCol = table.rows[i].cells[0];
                        firstCol.innerText = i;
                        }

                        counter_id = 0;
                    }else{
                        counter_id = $(this).closest('tr').text();
                        console.log(counter_id);
                        subtot = $("#subtot_d_"+ counter_id).val().replaceAll(",", "");
                        
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

                        sum = old_grandtot - subtot;

                        $("#price_total").val(thousands_separators(sum.toFixed(2)));
                        // $(this).closest('tr').remove();
                        // $('#row_id_' + counter_id).hidden = true;
                        id_detail = $("#tbl_detail_id_"+counter_id).val()
                        $("#deleted_d_" + counter_id).val(id_detail);
                        // $(this).closest('tr').hide();
                        $(this).closest('tr').remove();
                        
                        var table   = document.getElementById('datatable');
                        for (var i = 1; i < table.rows.length; i++) 
                        {
                        var firstCol = table.rows[i].cells[0];
                        firstCol.innerText = i;
                        }
                    }  
                } else {
                    return false;
                }
            });

            $(document).on("change", "#quantity", function(e) {
                if($('#quantity').val() == ''){
                    $('#quantity').val(0);
                }
                hrg = $('#hrgbeli').val();
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

            $(document).on("change", "#hrgbeli", function(e) {
                if($('#hrgbeli').val() == ''){
                    $('#hrgbeli').val(0);
                }
                $(this).val(thousands_separators($(this).val()));
                hrgparse = $('#hrgbeli').val();
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

            $(document).on("change", "#hrgjual", function(e) {
                if($('#hrgjual').val() == ''){
                    $('#hrgjual').val(0);
                }
                $(this).val(thousands_separators($(this).val()));
            });

            $(document).on("click", "#hrgbeli", function(e) {
                if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
                }
            });

            $(document).on("click", "#hrgjual", function(e) {
                if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
                }
            });

            // VALIDATE TRIGGER
            $("#quantity").keyup(function(e){
                if (/\D/g.test(this.value)){
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            });
            $("#hrgbeli").keyup(function(e){
                if (/\D/g.test(this.value)){
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            });

            $(document).on("click","#confirm",function(e){
            // Validate ifnull
            no = $("#no").val();
            code_cust = $("#code_cust").prop('selectedIndex');
            if (no == ""){
                swal('WARNING', 'No Tidak boleh kosong!', 'warning');
                return false;
            }else if (code_cust == 0){
                swal('WARNING', 'Please select Code Cust', 'warning');
                return false;
            }
            });

            $(document).on('keyup', '.row_hrgjual', function(event) 
            {
                event.preventDefault(); 
                if (/\D/g.test(this.value)){
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            }); 

            $(document).on('keyup', '.row_hrgbeli', function(event) 
            {
                event.preventDefault(); 
                if (/\D/g.test(this.value)){
                    // Filter non-digits from input value.
                    this.value = this.value.replace(/\D/g, '');
                }
            }); 

            $(document).on('click', '.row_hrgjual', function(event) 
            {
                event.preventDefault(); 
                
                if (/\D/g.test(this.value))
                {
                    // Filter comma
                    this.value = this.value.replace(/\,/g,"");
                    this.value = Number(Math.trunc(this.value))
                }

                $(this).focus();
            }); 

            $(document).on('click', '.row_hrgbeli', function(event) 
            {
                event.preventDefault(); 
                
                if (/\D/g.test(this.value))
                {
                    // Filter comma
                    this.value = this.value.replace(/\,/g,"");
                    this.value = Number(Math.trunc(this.value))
                }

                $(this).focus();
            });

            $(document).on('focusin', '.row_hrgjual', function(event) 
            {
                event.preventDefault(); 
                
                if (/\D/g.test(this.value))
                {
                    // Filter comma
                    this.value = this.value.replace(/\,/g,"");
                    this.value = Number(Math.trunc(this.value))
                }

                $(this).focus();
            });        

            $(document).on('focusin', '.row_hrgbeli', function(event) 
            {
                event.preventDefault(); 
                
                if (/\D/g.test(this.value))
                {
                    // Filter comma
                    this.value = this.value.replace(/\,/g,"");
                    this.value = Number(Math.trunc(this.value))
                }

                $(this).focus();
            });        

            $(document).on('focusout', '.row_hrgjual', function(event) 
            {
                event.preventDefault();
                var tbl_row = $(this).closest('tr');
		        var row_id = tbl_row.attr('row_id');

                hrgjual = $(this).val();
                console.log("hrgjual : "+hrgjual);

                $(this).val(thousands_separators(Number(hrgjual).toFixed(2)));
            })	

            $(document).on('focusout', '.row_hrgbeli', function(event) 
            {
                event.preventDefault();

                console.log("focus out");
                var tbl_row = $(this).closest('tr');
                var row_id = tbl_row.attr('row_id');

                subtot = $('#subtot_d_'+row_id).val();
                console.log("subtot : "+subtot);
                if (/\D/g.test(subtot))
                {
                    // Filter comma
                    subtot = subtot.replace(/\,/g,"");
                    subtot = Number(Math.trunc(subtot))
                }

                total = $('#price_total').val();
                console.log("total : "+total);
                if (/\D/g.test(total))
                {
                    // Filter comma
                    total = total.replace(/\,/g,"");
                    total = Number(Math.trunc(total))
                }

                total_old = total - subtot;

                hrg = $(this).val();

                qty = $('#qty_d_'+row_id).val();
                if (/\D/g.test(hrg))
                {
                    // Filter comma
                    hrg = hrg.replace(/\,/g,"");
                    hrg = Number(Math.trunc(hrg))
                }

                sum = hrg * qty;
                $('#subtot_d_'+row_id).val(thousands_separators(sum.toFixed(2)));

                total_new = total_old + sum;

                $(this).val(thousands_separators(Number(hrg).toFixed(2)))
                $('#price_total').val(thousands_separators(total_new.toFixed(2)));
            })	

            $(document).on('focusout', '.row_qty', function(event) 
            {
                event.preventDefault();

                console.log("focus out");
                var tbl_row = $(this).closest('tr');
                var row_id = tbl_row.attr('row_id');

                subtot = $('#subtot_d_'+row_id).val();
                console.log("subtot : "+subtot);
                if (/\D/g.test(subtot))
                {
                    // Filter comma
                    subtot = subtot.replace(/\,/g,"");
                    subtot = Number(Math.trunc(subtot))
                }

                total = $('#price_total').val();
                console.log("total : "+total);
                if (/\D/g.test(total))
                {
                    // Filter comma
                    total = total.replace(/\,/g,"");
                    total = Number(Math.trunc(total))
                }

                total_old = total - subtot;

                qty = $(this).val();

                hrg = $('#hrgbeli_d_'+row_id).val();
                if (/\D/g.test(hrg))
                {
                    // Filter comma
                    hrg = hrg.replace(/\,/g,"");
                    hrg = Number(Math.trunc(hrg))
                }

                sum = hrg * qty;
                $('#subtot_d_'+row_id).val(thousands_separators(sum.toFixed(2)));

                total_new = total_old + sum;

                $('#price_total').val(thousands_separators(total_new.toFixed(2)));
            })	
        
        })
    });
</script>
@endsection
