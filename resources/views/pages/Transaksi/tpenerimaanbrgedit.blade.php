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
                                    {{-- @foreach($notrans as $key => $code)
                                        @php $codetrans = $code->codetrans @endphp
                                    @endforeach --}}
                                    <input type="text" class="form-control" name="no" id="no" value="{{ $tpenerimaanh->no }}">
                                </div>       
                                <div class="form-group">
                                    <label>No. SJ</label>
                                    <select class="form-control select2" name="nosj" id="nosj">
                                        <option selected>{{ $tpenerimaanh->no_sj }}</option>
                                        <option selected>No SJ 1</option>
                                        {{-- @foreach($cabangs as $data => $cabang)
                                        <option>{{ $cabang->name." - ".$cabang->address }}</option>
                                        @endforeach --}}
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Counter</label>
                                    <select class="form-control select2" name="counter" id="counter">
                                        <option selected>{{ $tpenerimaanh->counter }}</option>
                                        @foreach($counters as $data => $counter)
                                        <option>{{ $counter->name }}</option>
                                        @endforeach
                                    </select>
                                </div>                         
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d", strtotime($tpenerimaanh->tgl)) }}">
                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" style="height:100px" name="note">{{ $tpenerimaanh->note }}</textarea>
                                </div>
                                <div class="form-group">
                                    <label>Jenis</label>
                                    <select class="form-control select2" name="jenis" id="jenis">
                                        <option selected>{{ $tpenerimaanh->jenis }}</option>
                                        <option>Normal</option>
                                        <option>Retur</option>
                                    </select>
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
                                    <label>Harga Jual</label>
                                    <input type="text" class="form-control" id="hrgjual" value="0">
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
                                    <label>Keterangan</label>
                                    <textarea class="form-control" style="height:70px" id="keterangan"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" id="quantity" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Subtotal</label>
                                    <input type="text" class="form-control" id="subtot" value="0" readonly>
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
                                        <th scope="col" class="border border-5">Quantity</th>
                                        <th scope="col" class="border border-5">Harga Jual</th>
                                        <th scope="col" class="border border-5">Subtotal</th>
                                        <th scope="col" class="border border-5">Satuan</th>
                                        <th scope="col" class="border border-5">Keterangan</th>
                                        <th scope="col" class="border border-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0; @endphp
                                @for($i = 0; $i < sizeof($tpenerimaands); $i++) @php $counter++; @endphp <tr>
                                    <th class="id-header border border-5" style='readonly:true;' headers="{{ $counter }}">{{ $counter }}</th>
                                    <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='{{ $tpenerimaands[$i]->code }}'></td>
                                    <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='namaitem_d[]' type='text' value='{{ $tpenerimaands[$i]->name }}'></td>
                                    <td class="border border-5"><input type='text' style='width:100px;' form='thisform' class='quantityclass form-control' name='quantity_d[]' value='{{ number_format($tpenerimaands[$i]->qty, 0, '.', '') }}'></td>
                                    <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='hrgjualclass form-control' value='{{ number_format($tpenerimaands[$i]->hrgjual, 2, '.', ',') }}' name='hrgjual_d[]'></td>
                                    <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='{{ number_format($tpenerimaands[$i]->subtotal, 2, '.', ',') }}' name='subtot_d[]' id='subtot_d{{ $counter }}'></td>
                                    <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='{{ $tpenerimaands[$i]->satuan }}' name='satuan_d[]'></td>
                                    <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='keteranganclass form-control' value='{{ $tpenerimaands[$i]->keterangan }}' name='keterangan_d[]'></td>
                                    <td class="border border-5"><button title='Delete' class='delete btn btn-primary' value="{{ $counter }}"><i style='font-size:15pt;color:#ffff;' class='fa fa-trash'></i></button></td>
                                    <td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value=''></td>
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
                                    <input type="text" class="form-control" name="price_total" form="thisform" id="price_total" value="{{ number_format($tpenerimaanh->grdtotal, 2, '.', ',') }}" readonly>
                                </div>
                            </div>
                        </div>
                    </div>              
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('tpenerimaanbrgpost') }}">Update</button>
                        {{-- @if($tpos_save == 'Y')
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('transpospost') }}">Submit</button>
                        @elseif($tpos_save == 'N' || $tpos_save == null)
                            <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="{{ route('transpospost') }}" disabled>Submit</button>
                        @endif --}}
                        <button class="btn btn-secondary" type="reset">Reset</button>
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
            $("#kode").on('select2:select', function(e) {
                var kode = $(this).val();
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
                                $("#satuan").val(response[i].satuan)
                                subtotal = Number(hrg).toFixed(2) * $('#quantity').val()
                                $("#subtot").val(thousands_separators(subtotal.toFixed(2)));
                                $("#hrgjual").val(thousands_separators(hrg.toFixed(2)));
                            }
                        }
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
                kode_id = $("#kode").val();
                nama_item = $("#nama_item").val();
                hrgjual = $("#hrgjual").val();
                quantity = $("#quantity").val();
                satuan = $("#satuan").val();
                subtot = $("#subtot").val();
                keterangan = $("#keterangan").val();


                tablerow = "<tr><th style='readonly:true;' class='border border-5'>" + counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode_id + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='nama_item_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='quantityclass form-control' name='quantity_d[]' value='" + quantity + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='hrgjualclass form-control' name='hrgjual_d[]' value='" + hrgjual + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='subtotclass form-control' name='subtot_d[]' id='subtot_d_"+counter+"' value='" + subtot + "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" + satuan + "' name='satuan_d[]'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='keteranganclass form-control' value='" + keterangan + "' name='keterangan_d[]'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                
                subtotparse = subtot.replaceAll(",", "");
                $("#datatable tbody").append(tablerow);
                console.log("Counter = "+counter)
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
                $("#nama").val('');
                $("#nama_item").val('');
                $("#hrgjual").val(0);
                $("#satuan").val('');
                $("#quantity").val(0);
                $("#merk").val('');
                $("#subtot").val('');
                $("#note").val('');
                $("#keterangan").val('');
            });

            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                counter_id = $(this).val();
                var r = confirm("Delete Transaksi ?");
                if (r == true) {
                    if(counter_id != 0){
                        console.log(counter_id);
                        subtot = $("#subtot_d" + counter_id).val().replaceAll(",", "");

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
                        $(this).closest('tr').remove();

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
                        $(this).closest('tr').remove();
                        }  
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
                if (/\D/g.test(hrgparse)){
                // Filter non-digits from input value.
                hrgparse = hrgparse.replace(/\D/g, '');
                }
                var hrg = Number(hrgparse).toFixed(2);
                var qty = Number($("#quantity").val()).toFixed(2);
                var total = Number(hrg) * Number(qty);
                console.log(total);
                
                $("#subtot").val(thousands_separators(total));
            });
            $(document).on("change", "#kurs", function(e) {
                if($('#kurs').val() == ''){
                    $('#kurs').val(1);
                }
                $(this).val(thousands_separators($(this).val()));
            });

            $(document).on("click", "#hrgjual", function(e) {
                if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
                }
            });

            $(document).on("click", "#kurs", function(e) {
                if (/\D/g.test(this.value)){
                // Filter non-digits from input value.
                this.value = this.value.replace(/\D/g, '');
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
        code_cust = $("#code_cust").prop('selectedIndex');
        if (no == ""){
            swal('WARNING', 'No Tidak boleh kosong!', 'warning');
            return false;
        }else if (code_cust == 0){
            swal('WARNING', 'Please select Code Cust', 'warning');
            return false;
        }
        });
        
    })

</script>
@endsection
