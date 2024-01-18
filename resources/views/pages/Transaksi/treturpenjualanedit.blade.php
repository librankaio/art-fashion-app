@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Retur Penjualan Edit</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Retur Penjualan Edit</a></div>
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
                                    <input type="text" class="form-control" name="no" id="no" value="{{ $treturh->no }}" readonly>
                                </div>
                                <div class="form-group">
                                    <label>Counter From</label>
                                    <input type="text" class="form-control" name="counter_from" id="counter_from" value="{{ $treturh->counter_from }}" readonly>             
                                </div>     
                                <div class="form-group">
                                    <label>Counter To</label>
                                    <select class="form-control select2" name="counter" id="counter">
                                        <option selected>{{ $treturh->counter }}</option>
                                        @foreach($counters as $counter)
                                        <option>{{ $counter->name}}</option>
                                        @endforeach
                                    </select>                                    
                                </div>                         
                                <div class="form-group">
                                    <label>Tanggal</label>
                                    <input type="date" class="form-control" name="dt" value="{{ date("Y-m-d", strtotime($treturh->tgl)) }}">
                                </div>
                                <div class="form-group">
                                    <label>Catatan</label>
                                    <textarea class="form-control" style="height:100px" name="note">{{ $treturh->note }}</textarea>
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
                                    <label>Quantity</label>
                                    <input type="text" class="form-control" id="quantity" value="0">
                                </div>
                                <div class="form-group">
                                    <label>Satuan</label>
                                    <input type="text" class="form-control" id="satuan" disabled>
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
                                        <th scope="col" class="border border-5">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $counter = 0; @endphp
                                    @for($i = 0; $i < sizeof($treturds); $i++) @php $counter++; @endphp 
                                    <tr row_id="{{ $counter }}" id='row_id_{{$counter}}'>
                                        <th class="id-header border border-5" style='readonly:true;' headers="{{ $counter }}">{{ $counter }}</th>
                                        <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='{{ $treturds[$i]->code }}'></td>
                                        <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='nama_item_d[]' type='text' value='{{ $treturds[$i]->name }}'></td>
                                        <td class="border border-5"><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='warna_d[]' type='text' value='{{ $treturds[$i]->warna }}'></td>
                                        <td class="border border-5"><input type='text' style='width:100px;' form='thisform' class='quantityclass form-control' name='quantity_d[]' value='{{ number_format($treturds[$i]->qty, 0, '.', '') }}'></td>
                                        <td class="border border-5"><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='{{ $treturds[$i]->satuan }}' name='satuan_d[]'></td>
                                        <td class="border border-5"><button title='Delete' class='delete btn btn-primary' value="{{ $counter }}"><i style='font-size:15pt;color:#ffff;' class='fa fa-trash'></i></button></td>
                                        <td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value=''></td>
                                        <td class="border border-5" hidden><input style='width:120px;' readonly form='thisform' class='idclass form-control' name='id_d[]' type='text' value='{{ $treturds[$i]->id }}' id="tbl_detail_id_{{ $counter }}"></td>
                                        <td class="border border-5" hidden><input style='width:120px;' readonly form='thisform' class='delclass form-control' name='deleted_item_d[]' type='text' value='' id="deleted_d_{{ $counter }}"></td>
                                        <td class="border border-5" hidden><input style='width:120px;' readonly form='thisform' class='existdbclass form-control' name='existdb_d[]' type='text' value='{{ $treturds[$i]->id }}' id="existdb_{{ $counter }}"></td>
                                    </tr>
                                    @endfor
                                </tbody>                            
                            </table>
                        </div>                                              
                    </div>      
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" id="confirm" type="submit" formaction="/treturjual/{{ $treturh->id }}">Update</button>
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
            // $('.select2').select2({});
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
                                $("#warna").val(response[i].warna)
                                $("#satuan").val(response[i].satuan)
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
                    alert('Quantity tidak boleh 0');
                    return false;
                }

                kode = $("#select2-kode-container").text();
                counter_asal = $("#counter_from").val();

                show_loading()
                $.ajax({
                    url: '{{ route('getstock') }}', 
                    method: 'post', 
                    data: {'kode': kode, 'counter_asal': counter_asal}, 
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}, 
                    dataType: 'json', 
                    success: function(response) {
                        // console.log(kode);
                        console.log(response.stock);
                        if(response.stock <= 0){
                            swal('WARNING', 'Stock dari Item '+kode+' pada Counter '+counter_asal+' Kosong!', 'warning');
                            hide_loading();
                            return false;
                        }else{
                            kode = $("#select2-kode-container").text();
                            kode_id = $("#kode").val();
                            nama_item = $("#nama_item").val();
                            warna = $("#warna").val();
                            quantity = $("#quantity").val();
                            satuan = $("#satuan").val();


                            tablerow = "<tr row_id="+ counter +"><th style='readonly:true;' class='border border-5'>" + counter + "</th><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='kodeclass form-control' name='kode_d[]' type='text' value='" + kode + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='namaitemclass form-control' name='nama_item_d[]' type='text' value='" + nama_item + "'></td><td class='border border-5'><input style='width:120px;' readonly form='thisform' class='warnaclass form-control' name='warna_d[]' type='text' value='" + warna + "'></td><td class='border border-5'><input type='text' style='width:100px;' form='thisform' class='quantityclass form-control' name='quantity_d[]' value='" + quantity + "'></td><td class='border border-5'><input type='text' readonly form='thisform' style='width:100px;' class='satuanclass form-control' value='" + satuan + "' name='satuan_d[]'></td><td class='border border-5'><a title='Delete' class='delete'><i style='font-size:15pt;color:#6777ef;' class='fa fa-trash'></i></a></td><td hidden><input style='width:120px;' readonly form='thisform' class='noclass form-control' name='no_d[]' type='text' value='" + no + "'></td><td class='border border-5' hidden><input style='width:120px;' readonly form='thisform' class='idclass form-control' name='id_d[]' type='text' value='new_item' id='tbl_detail_id_'"+ counter +"></td><td class='border border-5' hidden><input style='width:120px;' readonly form='thisform' class='delclass form-control' name='deleted_item_d[]' type='text' id='deleted_d_'"+ counter +"></td></tr>";
                            
                            $("#datatable tbody").append(tablerow);
                            if(counter == 1){
                                $("#nama_item").val('');
                                $("#warna").val('');
                                $('#hrgsatuan').val(0);
                                $('#quantity').val(0);
                            }else{

                                $("#nama_item").val('');
                                $("#warna").val('');
                                $('#hrgsatuan').val(0);
                                $('#quantity').val(0);
                            }
                            counter++;
                            $("#kode").prop('selectedIndex', 0).trigger('change');
                            $("#nama_item").val('');
                            $("#warna").val('');
                            $("#satuan").val('');
                            $("#quantity").val(0);
                            $("#note").val('');
                            hide_loading()
                        }
                    }
                });
            });

            $(document).on("click", ".delete", function(e) {
                e.preventDefault();
                counter_id = $(this).val();
                var r = confirm("Delete Transaksi ?");
                if (r == true) {
                    if(counter_id != 0){
                        // $(this).closest('tr').remove();
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
                        // $(this).closest('tr').remove();

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
            });

            
        });
        // VALIDATE TRIGGER
        $("#quantity").keyup(function(e){
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
        
    })

</script>
@endsection
