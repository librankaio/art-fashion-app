@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Laporan Mutasi Stock</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Report</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Laporan Mutasi Stock</a></div>
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
                                    <label>Artikel</label>
                                    <select class="form-control select2" name="artikel" id="artikel">
                                        @if(request('artikel') == NULL)
                                        <option disabled selected>--Select Artikel--</option>
                                        @else
                                        <option selected>@php echo $_GET['artikel']; @endphp</option>
                                        @endif
                                        @foreach($mitems as $data => $mitem)
                                        <option>{{ $mitem->code }}</option>
                                        @endforeach
                                    </select>
                                </div>                                
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 d-flex justify-content-end">                    
                                <div class="form-group">
                                    <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="/rmutasistocksearch" onclick="show_loading()">View</button>
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
                                <button type="submit" formaction="rmutasistockexcl" formtarget="_blank" class="btn btn-success"><i
                                    class="far fa-file-excel"></i><span> Export Excel</span></button>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-bordered" id="datatable">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5">Jenis Transaksi</th>
                                        <th scope="col" class="border border-5">No Transaksi</th>
                                        <th scope="col" class="border border-5">Tanggal</th>
                                        <th scope="col" class="border border-5">Counter</th>
                                        <th scope="col" class="border border-5">Quantity</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @isset($results)
                                    @php $counter = 0 @endphp
                                    @foreach($results as $data => $item)
                                        @php $counter++ @endphp
                                        <tr>
                                            <th scope="row" class="border border-5">{{ $item->JenisTransaksi }}</th>
                                            <td class="border border-5" style="text-align: center;">{{ $item->no }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ date("Y-m-d", strtotime($item->tgl)) }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                                            <td class="border border-5" style="text-align: center;">{{ number_format($item->qty) }}</td>
                                        </tr>
                                    @endforeach
                                    @endisset
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
                                    @if(isset($totqty))
                                    @foreach ($totqty as $qty)
                                        <input type="text" class="form-control" form="thisform" value="{{ number_format($qty->totalqty) }}" readonly>
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

            var counter = 1;
            $(document).on("click", "#addItem", function(e) {
                e.preventDefault();
                if($('#quantity').val() == 0){
                    alert('Quantity tidak boleh 0');
                    return false;
                }

                no = $("#no").val();
                kode = $("#select2-kode-container").text();
                nama = $("#nama").val();
                hrgsatuan = $("#hrgsatuan").val();
                discount = $("#disc").val();
                tax = $("#tax").val();
                nama_item = $("#nama_item").val();
                satuan = $("#satuan").val();
                quantity = $("#quantity").val();
                merk = $("#merk").val();
                subtot = $("#subtot").val();
                note = $("#note").val();


                tablerow = "<tr><th style='readonly:true;' class='border border-5'>" + counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='nama_item_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='quantityclass form-control' name='quantity[]' value='" + quantity + "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" + satuan + "' name='satuan_d[]'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='hargaclass form-control' value='" + hrgsatuan + "' name='harga_d[]'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='discclass form-control' value='" + discount + "' name='disc_d[]' id='disc_d_"+counter+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='taxclass form-control' value='" + tax + "' name='tax_d[]' id='tax_d_"+counter+"'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='subtotclass form-control' value='" + subtot + "' name='subtot_d[]' id='subtot_d_"+counter+"'></td><td class='border border-5'><input type='text' form='thisform' style='width:100px;' class='subtotclass form-control' value='" + note + "' name='note_d[]'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td></tr>";
                
                subtotparse = subtot.replaceAll(",", "");
                $("#datatable tbody").append(tablerow);
                if(counter == 1){
                    disc = Number(subtotparse).toFixed(2) * ($("#disc").val() / 100);
                    tax = (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) * ($("#tax").val() / 100);
                    total =  (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) + Number(tax.toFixed(2));
                    subtot = Number(subtotparse);

                    $("#subtotal_h").val(thousands_separators(subtot.toFixed(2)));
                    $("#price_disc").val(thousands_separators(disc.toFixed(2)));
                    $("#price_tax").val(thousands_separators(tax.toFixed(2)));
                    $("#price_total").val(thousands_separators(total.toFixed(2)));


                    $("#nama_item").val('');
                    $('#tax').val(0);
                    $('#disc').val(0);
                    $('#hrgsatuan').val(0);
                    $('#quantity').val(0);
                    console.log("Disc : "+disc.toFixed(2), "Tax : "+tax, "Total : "+total);
                }else{
                    subtot_old = $("#subtotal_h").val().replaceAll(",", "");
                    disc_old = $("#price_disc").val().replaceAll(",", "");
                    tax_old = $("#price_tax").val().replaceAll(",", "");
                    total_old = $("#price_total").val().replaceAll(",", "");
                    thisdisc = $("#disc").val();
                    thistax = $("#tax").val()

                    disc = Number(subtotparse).toFixed(2) * (Number(thisdisc).toFixed(2) / 100);
                    tax = (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) * (Number(thistax).toFixed(2) / 100);
                    total =  (Number(subtotparse).toFixed(2) - Number(disc).toFixed(2)) + Number(tax.toFixed(2));

                    subtot_new = Number(Number(subtotparse).toFixed(2)) + Number(Number(subtot_old).toFixed(2));
                    disc_new = Number(Number(disc_old).toFixed(2)) + Number(disc.toFixed(2));
                    tax_new = Number(Number(tax_old).toFixed(2)) + Number(tax.toFixed(2));
                    total_new = Number(Number(total_old).toFixed(2)) + Number(total.toFixed(2));

                    $("#subtotal_h").val(thousands_separators(subtot_new.toFixed(2)));
                    $("#price_disc").val(thousands_separators(disc_new.toFixed(2)));
                    $("#price_tax").val(thousands_separators(tax_new.toFixed(2)));
                    $("#price_total").val(thousands_separators(total_new.toFixed(2)));

                    $("#nama_item").val('');
                    $('#tax').val(0);
                    $('#disc').val(0);
                    $('#hrgsatuan').val(0);
                    $('#quantity').val(0);
                }
                counter++;
                $("#kode").prop('selectedIndex', 0).trigger('change');
                $("#nama").val('');
                $("#nama_item").val('');
                $("#hrgsatuan").val(0);
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
                    // console.log(subtot);
                    price_tax = $("#price_tax").val().replaceAll(",", "");
                    price_disc = $("#price_disc").val().replaceAll(",", "");
                    price_total = $("#price_total").val().replaceAll(",", "");
                    subtotal_h = $("#subtotal_h").val().replaceAll(",", "");
                    disc_d = $("#disc_d_"+ counter_id).val()
                    tax_d = $("#tax_d_"+ counter_id).val()
                    
                    
                    disc = Number(subtot).toFixed(2) * (Number(disc_d).toFixed(2) / 100);
                    tax = (Number(subtot).toFixed(2) - Number(disc).toFixed(2)) * (Number(tax_d).toFixed(2) / 100);
                    total =  (Number(subtot).toFixed(2) - Number(disc).toFixed(2)) + Number(tax.toFixed(2));                    

                    subtotal = Number(subtotal_h).toFixed(2) - Number(subtot).toFixed(2);
                    totaltax = Number(price_tax).toFixed(2) - Number(tax).toFixed(2);
                    totaldisc = Number(price_disc).toFixed(2) - Number(disc).toFixed(2);
                    totalfinal = Number(price_total).toFixed(2) - Number(total).toFixed(2);

                    $("#subtotal_h").val(thousands_separators(subtotal.toFixed(2)));
                    $("#price_disc").val(thousands_separators(totaldisc.toFixed(2)));
                    $("#price_tax").val(thousands_separators(totaltax.toFixed(2)));
                    $("#price_total").val(thousands_separators(totalfinal.toFixed(2)));
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
                hrgparse = $('#hrgsatuan').val();
                if (/\D/g.test(hrgparse)){
                // Filter non-digits from input value.
                hrgparse = hrgparse.replace(/\D/g, '');
                }
                var hrg = Number(hrgparse).toFixed(2);
                var qty = Number($("#quantity").val()).toFixed(2);
                var total = Number(hrg) * Number(qty);
                // console.log(hrg);                
                $("#subtot").val(thousands_separators(total));
            });

            $(document).on("change", "#hrgsatuan", function(e) {
                if($('#hrgsatuan').val() == ''){
                    $('#hrgsatuan').val(0);
                }
                $(this).val(thousands_separators($(this).val()));
                hrgparse = $('#hrgsatuan').val();
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

            $(document).on("click", "#hrgsatuan", function(e) {
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
        code_cust = $("#code_cust").prop('selectedIndex');
        if (no == ""){
            swal('WARNING', 'No Tidak boleh kosong!', 'warning');
            return false;
        }else if (code_cust == 0){
            swal('WARNING', 'Please select Code Cust', 'warning');
            return false;
        }
        });

        $('#datatable').DataTable({
        "ordering":false,
        "bInfo" : false,
        // "bPaginate": false,
        // "searching": false
        });
        
    })

</script>
@endsection
