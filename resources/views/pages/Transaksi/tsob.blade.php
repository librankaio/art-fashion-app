@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Surat Order Barang (SOB)</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Surat Order Barang (SOB)</a></div>
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
                                    @foreach($notrans as $key => $code)
                                        @php $codetrans = $code->codetrans @endphp
                                    @endforeach
                                    <input type="text" class="form-control" name="no" id="no" value="{{ $code->codetrans }}" readonly>
                                </div>       
                                <div class="form-group">
                                    <label>Counter</label>
                                    <select class="form-control select2" name="counter" id="counter">
                                        {{-- <option disabled selected>--Select Counter--</option> --}}
                                        @foreach($counters as $counter)
                                        <option>{{ $counter->name}}</option>
                                        @endforeach
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
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5">No</th>
                                        <th scope="col" class="border border-5">Kode</th>
                                        <th scope="col" class="border border-5">Nama Item</th>
                                        <th scope="col" class="border border-5">Warna</th>
                                        <th scope="col" class="border border-5">Quantity</th>
                                        <th scope="col" class="border border-5">Satuan</th>
                                        <th scope="col" class="border border-5">Harga Jual</th>
                                        <th scope="col" class="border border-5">Subtotal</th>
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
                        <a class="btn btn-warning mr-1" href="/tsoblist">List</a>
                        <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('tsobpost') }}">Save</button>
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
        rowCount = 0;
        //CSRF TOKEN
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $(document).ready(function() {
            // $('.select2').select2({
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

            var counter = 1;
            $(document).on("click", "#addItem", function(e) {
                e.preventDefault();
                if($('#quantity').val() == 0){
                    swal('WARNING', 'Quantity Tidak boleh 0!', 'warning');
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


                tablerow = "<tr row_id="+ counter +"><th style='readonly:true;' class='border border-5'>" + counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode_id + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + warna + "'></td><td class='border border-5'><input style='width:120px;' form='thisform' class='row_qty quantityclass form-control' name='quantity_d[]' type='text' value='" + quantity + "' id='qty_d_"+counter+"'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='satuanclass form-control' name='satuan_d[]' type='text' value='" + satuan + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='row_hrgjual hrgjualclass form-control' name='hrgjual_d[]' type='text' value='" + hrgjual + "' id='hrgjual_d_"+ counter +"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='" + subtot + "' name='subtot_d[]' id='subtot_d_"+counter+"'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                
                subtotparse = subtot.replaceAll(",", "");
                $("#datatable tbody").append(tablerow);
                // if(counter == 1){
                //     disc = Number(subtotparse).toFixed(2) * ($("#disc").val() / 100);
                //     tax = (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) * ($("#tax").val() / 100);
                //     total =  (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) + Number(tax.toFixed(2));
                //     subtot = Number(subtotparse);

                //     $("#subtotal_h").val(thousands_separators(subtot.toFixed(2)));
                //     $("#price_disc").val(thousands_separators(disc.toFixed(2)));
                //     $("#price_tax").val(thousands_separators(tax.toFixed(2)));
                //     $("#price_total").val(thousands_separators(total.toFixed(2)));


                //     $("#nama_item").val('');
                //     $('#tax').val(0);
                //     $('#disc').val(0);
                //     $('#hrgjual').val(0);
                //     $('#quantity').val(0);
                //     console.log("Disc : "+disc.toFixed(2), "Tax : "+tax, "Total : "+total);
                // }else{
                //     subtot_old = $("#subtotal_h").val().replaceAll(",", "");
                //     disc_old = $("#price_disc").val().replaceAll(",", "");
                //     tax_old = $("#price_tax").val().replaceAll(",", "");
                //     total_old = $("#price_total").val().replaceAll(",", "");
                //     thisdisc = $("#disc").val();
                //     thistax = $("#tax").val()

                //     disc = Number(subtotparse).toFixed(2) * (Number(thisdisc).toFixed(2) / 100);
                //     tax = (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) * (Number(thistax).toFixed(2) / 100);
                //     total =  (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) + Number(tax.toFixed(2));

                //     subtot_new = Number(Number(subtotparse).toFixed(2)) + Number(Number(subtot_old).toFixed(2));
                //     disc_new = Number(Number(disc_old).toFixed(2)) + Number(disc.toFixed(2));
                //     tax_new = Number(Number(tax_old).toFixed(2)) + Number(tax.toFixed(2));
                //     total_new = Number(Number(total_old).toFixed(2)) + Number(total.toFixed(2));

                //     $("#subtotal_h").val(thousands_separators(subtot_new.toFixed(2)));
                //     $("#price_disc").val(thousands_separators(disc_new.toFixed(2)));
                //     $("#price_tax").val(thousands_separators(tax_new.toFixed(2)));
                //     $("#price_total").val(thousands_separators(total_new.toFixed(2)));

                //     $("#nama_item").val('');
                //     $('#tax').val(0);
                //     $('#disc').val(0);
                //     $('#hrgjual').val(0);
                //     $('#quantity').val(0);
                // }
                if(counter == 1){
                    if (/\D/g.test(subtot))
                    {
                        // Filter comma
                        subtot = subtot.replace(/\,/g,"");
                        subtot = Number(Math.trunc(subtot))
                    }
                    grandtot = subtot;

                    rowCount++;
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
                    
                    console.log("subtotal: " + subtot + ", grandtot: " + grandtot);
                    sum = subtot + old_grandtot;

                    rowCount++;
                    $("#price_total").val(thousands_separators(sum.toFixed(2)));
                }
                counter++;
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

                    rowCount--;
                    $("#price_total").val(thousands_separators(sum.toFixed(2)));
                    $(this).closest('tr').remove();
                } else {
                    return false;
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
            
            $(document).on("change", "#kurs", function(e) {
                if($('#kurs').val() == ''){
                    $('#kurs').val(1);
                }
                $(this).val(thousands_separators($(this).val()));
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
        $("#hrgjual").keyup(function(e){
            if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
            }
        });

        $(document).on("click","#confirm",function(e){
            // Validate ifnull
            no = $("#no").val();
            counter = $("#counter").prop('selectedIndex');
            if (rowCount == 0){
                swal('WARNING', 'Silahkan Masukkan data detail terlebih dahulu!', 'warning');
                return false;
            }
            else if (no == ""){
                swal('WARNING', 'No Tidak boleh kosong!', 'warning');
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
