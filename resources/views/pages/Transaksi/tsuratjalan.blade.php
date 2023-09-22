@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Surat Jalan</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Surat Jalan</a></div>
        </div>
    </div>
    @php
        $tpos_save = session('tpos_save');
    @endphp
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @include('layouts.flash-message')
            </div>
        </div>
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
                                    @foreach($notrans as $key => $code)
                                        @php $codetrans = $code->codetrans @endphp
                                    @endforeach
                                    <input type="text" class="form-control" name="no" id="no" value="{{ $code->codetrans }}" readonly>
                                </div>       
                                <div class="form-group">
                                    <label>No SOB.</label>
                                    <select class="form-control select2" name="nosob" id="nosob">
                                        <option disabled selected>--Select No SOB--</option>
                                        @foreach($sobs as $data => $sob)
                                        <option>{{ $sob->no }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Counter</label>
                                    <input type="text" class="form-control" name="counter" id="counter" readonly>
                                    {{-- <select class="form-control select2" name="counter" id="counter">
                                        <option disabled selected>--Select Counter--</option>
                                        @foreach($counters as $counter)
                                        <option>{{ $counter->name}}</option>
                                        @endforeach
                                    </select> --}}
                                </div>                  
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select class="form-control" name="jenis" id="jenis">
                                        <option disabled selected>--Select Jenis--</option>
                                        <option>Normal</option>
                                        <option>Retur</option>
                                    </select>
                                </div>                         
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
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card" id="card_items" style="border: 1px solid lightblue; display:none;">
                    <div class="card-header">
                        <h4>Add Items</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kode</label>
                                    <select class="form-control select2" id="kode">
                                        <option disabled selected>--Select Kode--</option>
                                        @foreach($mitems as $data => $item)                                        
                                        <option value="{{ $item->code }}">{{ $item->code." - ".$item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Nama Item</label>
                                    <input type="text" class="form-control" id="nama_item" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Warna</label>
                                    <input type="text" class="form-control" id="warna" disabled>
                                </div>     
                                <div class="form-group">
                                    <a href="" id="addItem">
                                        <i class="fa fa-plus" style="font-size:18pt"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6">                                
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuan" disabled>
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
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control" id="subtot" disabled>
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
                                <input type="text" class="form-control" id="number_counter" value="0" readonly>
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
                                        <th scope="col" class="border border-5">Harga</th>
                                        <th scope="col" class="border border-5">Sub Total Harga</th>
                                        <th scope="col" class="border border-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
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
                                    <input type="text" class="form-control" name="price_total" form="thisform" id="price_total" readonly>
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="card-footer text-right">
                        <a class="btn btn-warning mr-1" href="/tsuratjalanlist">List</a>
                        <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('tsuratjalanpost') }}">Save</button>
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
        rowCount = $('#number_counter').val();
        //CSRF TOKEN
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            $('.select2').select2({});
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

            $("#nosob").on('select2:select', function(e) {
                var nosob = $(this).val();
                show_loading()
                console.log(nosob);
                $.ajax({
                    url: '{{ route('getnosobd') }}', 
                    method: 'post', 
                    data: {'nosob': nosob}, 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                    dataType: 'json', 
                    success: function(response) {
                        if($('#number_counter').val() == 0){
                            console.log('masuk');
                            console.log(response);
                            number_counter = Number($('#number_counter').val());
                            for (i=0; i < response.length; i++) {
                                if(response[i].no_sob == nosob){
                                    // if(number_counter == 0){
                                    //     number_counter++;
                                    // }

                                    subtotparse = thousands_separators(Number(response[i].subtotal).toFixed(2));

                                    if($("#price_total").val() == 0 || $("#price_total").val() == ''){
                                        $("#price_total").val(subtotparse);
                                        number_counter++;
                                        console.log(number_counter);
                                    }else if($("#price_total").val() >= 0 || $("#price_total").val() != ''){
                                        old_grandtot = $('#price_total').val();
                                    
                                        if (/\D/g.test(old_grandtot))
                                        {
                                            // Filter comma
                                            old_grandtot = old_grandtot.replace(/\,/g,"");
                                            old_grandtot = Number(Math.trunc(old_grandtot))
                                        }

                                        if (/\D/g.test(subtotparse))
                                        {
                                            // Filter comma
                                            subtotparse = subtotparse.replace(/\,/g,"");
                                            subtotparse = Number(Math.trunc(subtotparse))
                                        }

                                        sum = subtotparse + old_grandtot;

                                        new_grandtot = thousands_separators(Number(sum).toFixed(2));
                                        $("#price_total").val(new_grandtot);
                                        console.log(number_counter);
                                        // number_counter++;
                                    }
                                    // number_new = $('#number_counter').val();
                                    tablerow = "<tr row_id="+ number_counter +"><th style='readonly:true;' class='border border-5'>" + number_counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + response[i].code + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" + response[i].name + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + response[i].warna + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" + parseInt(response[i].qty) + "' id='qty_d_"+counter+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" + response[i].satuan + "' name='satuan_d[]'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' readonly class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' value='" + thousands_separators(Number(response[i].hrgjual).toFixed(2)) + "' id='hrgjual_d_"+number_counter+"'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' readonly class='subtotclass form-control' name='subtot_d[]' id='subtot_d_"+number_counter+"' value='" + thousands_separators(Number(response[i].subtotal).toFixed(2)) + "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                                    $("#datatable tbody").append(tablerow);
                                    number_counter++;
                                    $('#number_counter').val(number_counter);
                                    
                                }
                            }
                            var x = document.getElementById("card_items");
                            if (x.style.display === "none") {
                                x.style.display = "block";
                            } else {
                                x.style.display = "none";
                            }
                        }else if($('#number_counter').val() >= 0){
                            console.log('masuk222');

                            $('#number_counter').val(0)
                            $('#price_total').val(0)
                            $("#datatable tbody").empty();

                            number_counter = Number($('#number_counter').val());
                            for (i=0; i < response.length; i++) {
                                if(response[i].no_sob == nosob){
                                    // if(number_counter == 0){
                                    //     number_counter++;
                                    // }

                                    old_grandtot = $('#price_total').val();
                                    
                                    if (/\D/g.test(old_grandtot))
                                    {
                                        // Filter comma
                                        old_grandtot = old_grandtot.replace(/\,/g,"");
                                        old_grandtot = Number(Math.trunc(old_grandtot))
                                    }

                                    subtot = thousands_separators(Number(response[i].subtotal).toFixed(2))

                                    console.log(subtot)
                                    if (/\D/g.test(subtot))
                                    {
                                        // Filter comma
                                        subtot = subtot.replace(/\,/g,"");
                                        subtot = Number(Math.trunc(subtot))
                                    }

                                    sum = parseFloat(subtot) + parseFloat(old_grandtot);

                                    new_grandtot = thousands_separators(Number(sum).toFixed(2));

                                    $("#price_total").val(new_grandtot);
                                    number_counter++

                                    
                                    // number_new = $('#number_counter').val();
                                    
                                    tablerow = "<tr row_id="+ number_counter +"><th style='readonly:true;' class='border border-5'>" + number_counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + response[i].code + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" + response[i].name + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + response[i].warna + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' value='" + parseInt(response[i].qty) + "' id='qty_d_"+counter+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" + response[i].satuan + "' name='satuan_d[]'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' value='" + thousands_separators(Number(response[i].hrgjual).toFixed(2)) + "' id='hrgjual_d_"+number_counter+"'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='subtotclass form-control' name='subtot_d[]' id='subtot_d_"+number_counter+"' value='" + thousands_separators(Number(response[i].subtotal).toFixed(2)) + "'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                                    $("#datatable tbody").append(tablerow);
                                    $('#number_counter').val(number_counter);
                                }
                            }
                            number_counter++;
                            $('#number_counter').val(number_counter);
                            
                            var x = document.getElementById("card_items");
                            if (x.style.display === "none") {
                                x.style.display = "block";
                            }
                        }
                        $.ajax({
                            url: '{{ route('getcounter') }}', 
                            method: 'post', 
                            data: {'nosob': nosob}, 
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                            dataType: 'json', 
                            success: function(response) {
                                console.log(response);
                                for (i=0; i < response.length; i++) {
                                    if(response[i].no == nosob){
                                        $("#counter").val(response[i].counter);
                                    }
                                }
                            }
                        });
                        hide_loading()
                    }
                });                
            });

            var counter = Number($('#number_counter').val());
            $(document).on("click", "#addItem", function(e) {
                e.preventDefault();
                if($('#quantity').val() == 0){
                    alert('Quantity tidak boleh 0');
                    return false;
                }

                kode = $("#select2-kode-container").text();
                kode_id = $("#kode").val();
                nama_item = $("#nama_item").val();
                warna = $("#warna").val();
                hrgjual = $("#hrgjual").val();
                quantity = $("#quantity").val();
                satuan = $("#satuan").val();
                subtot = $("#subtot").val();
                rowCount = $('#number_counter').val();
                counter = rowCount;
                
                subtotparse = subtot.replaceAll(",", "");
                
                if(counter == 1){
                    if (/\D/g.test(hrgjual))
                    {
                        // Filter comma
                        hrgjual = hrgjual.replace(/\,/g,"");
                        hrgjual = Number(Math.trunc(hrgjual))
                    }
                    sum = hrgjual * quantity;
                    
                    $("#subtot").val(thousands_separators(sum.toFixed(2)));

                    total_old = $('#price_total').val();
                    console.log("total old : "+total_old);
                    if (/\D/g.test(total_old))
                    {
                        // Filter comma
                        total_old = total_old.replace(/\,/g,"");
                        total_old = Number(Math.trunc(total_old))
                    }
                    
                    total = sum + total_old
                    
                    // rowCount++;
                    // console.log(rowCount);
                    // $('#number_counter').val(rowCount);
                    $("#price_total").val(thousands_separators(Number(total).toFixed(2)));

                }else{
                    if (/\D/g.test(hrgjual))
                    {
                        // Filter comma
                        hrgjual = hrgjual.replace(/\,/g,"");
                        hrgjual = Number(Math.trunc(hrgjual))
                    }
                    sum = hrgjual * quantity;
                    
                    $("#subtot").val(thousands_separators(sum.toFixed(2)));

                    total_old = $('#price_total').val();
                    console.log("total old : "+total_old);
                    if (/\D/g.test(total_old))
                    {
                        // Filter comma
                        total_old = total_old.replace(/\,/g,"");
                        total_old = Number(Math.trunc(total_old))
                    }
                    
                    total = sum + total_old

                    $("#price_total").val(thousands_separators(Number(total).toFixed(2)));
                }

                tablerow = "<tr row_id="+ rowCount +"><th style='readonly:true;' class='border border-5'>" + rowCount + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode_id + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + warna + "'></td><td class='border border-5'><input style='width:120px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' type='text' value='" + quantity + "' id='qty_d_"+counter+"'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='satuanclass form-control' name='satuan_d[]' type='text' value='" + satuan + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' type='text' value='" + hrgjual + "' id='hrgjual_d_"+rowCount+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='" + subtot + "' name='subtot_d[]' id='subtot_d_"+rowCount+"'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                
                $("#datatable tbody").append(tablerow);

                rowCount++;
                console.log(rowCount);
                $('#number_counter').val(rowCount);

                $("#kode").prop('selectedIndex', 0).trigger('change');
                $("#nama_item").val('');
                $("#warna").val('');
                $("#hrgjual").val(0);
                $("#satuan").val('');
                $("#quantity").val(0);
                $("#merk").val('');
                $("#subtot").val('');
                $("#note").val('');
            });

            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                var r = confirm("Delete Transaksi ?");
                if (r == true) {
                    counter_id = $(this).closest('tr').text();
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
                    console.log(sum);
                    
                    // rowCount = $('#number_counter').val();

                    // rowCount--;
                    // $('#number_counter').val(rowCount);
                    $("#price_total").val(thousands_separators(sum.toFixed(2)));
                    $(this).closest('tr').remove();
                } else {
                    return false;
                }
            });

            $(document).on("change", "#disc", function(e) {
                if($('#disc').val() == ''){
                    $('#disc').val(0);
                }
            });

            $(document).on("change", "#tax", function(e) {
                if($('#tax').val() == ''){
                    $('#tax').val(0);
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

            $(document).on("click", "#hrgjual", function(e) {
                if (/\D/g.test(this.value))
                {
                    // Filter comma
                    this.value = this.value.replace(/\,/g,"");
                    this.value = Number(Math.trunc(this.value))
                }
            });
        });
        // VALIDATE TRIGGER
        $("#quantity").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#hrgsatuan").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });
        $("#kurs").keyup(function(e){
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
            if(this.value >= 99){
                this.value = 99;
            }
        });
        $("#tax").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
            if(this.value >= 99){
                this.value = 99;
            }
        });

        $(document).on("click","#confirm",function(e){
        // Validate ifnull
        no = $("#no").val();
        counter = $("#counter").val();
        code_cust = $("#code_cust").prop('selectedIndex');
        nosob = $("#nosob").prop('selectedIndex');
        jenis = $("#jenis").prop('selectedIndex');
        if (no == ""){
            swal('WARNING', 'No Tidak boleh kosong!', 'warning');
            return false;
        }else if (code_cust == 0){
            swal('WARNING', 'Please select Code Cust', 'warning');
            return false;
        }
        else if (nosob == 0){
            swal('WARNING', 'Please select Nomer SOB', 'warning');
            return false;
        }else if (jenis == 0){
            swal('WARNING', 'Please select Jenis', 'warning');
            return false;
        }
        });

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

                hrg = $('#hrgjual_d_'+row_id).val();
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

</script>
@endsection
