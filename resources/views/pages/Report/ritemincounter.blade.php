@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Item in Counter</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Report</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Item in Counter</a></div>
            </div>
        </div>
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
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label>Kode Item</label>
                                            <select class="form-control select2" id="kode" name="kode">
                                                @if (request('kode') == null)
                                                    <option></option>
                                                @else
                                                    <option selected>@php echo $_GET['kode']; @endphp</option>
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 d-flex justify-content-end">
                                        <div class="form-group">
                                            <button class="btn btn-primary mr-1" id="confirm" type="submit"
                                                formaction="/ritemincountersearch" onclick="show_loading()">View</button>
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
                                    {{-- <div class="col-6 d-flex justify-content-end">
                                        <button type="submit" formaction="ritemincounterexcl" formtarget="_blank"
                                            class="btn btn-success"><i class="far fa-file-excel"></i><span> Export
                                                Excel</span></button>
                                    </div> --}}
                                </div>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="datatable">
                                        <thead>
                                            <tr>
                                                <th scope="col" class="border border-5" style="text-align: center;">No
                                                </th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Nama
                                                    Counter</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Kode
                                                    Barang</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">Nama
                                                    Barang</th>
                                                <th scope="col" class="border border-5" style="text-align: center;">
                                                    Quantity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @isset($results)
                                                @php $counter = 0 @endphp
                                                @foreach ($results as $data => $item)
                                                    @php $counter++ @endphp
                                                    <tr>
                                                        <th scope="row" class="border border-5">{{ $counter }}</th>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->name_mcounters }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->code_mitem }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ $item->name_mitem }}</td>
                                                        <td class="border border-5" style="text-align: center;">
                                                            {{ number_format($item->stock) }}</td>
                                                    </tr>
                                                @endforeach
                                            @endisset
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="card-footer text-right">

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

                $("#kode").select2({
                    placeholder: 'Select Kode',
                    ajax: {
                        url: "{{ route('getmitemv2') }}",
                        type: "post",
                        dataType: "json",
                        delay: 250,
                        data: function(params) {
                            return {
                                _token: CSRF_TOKEN,
                                search: params.term, //search term
                            };
                        },
                        processResults: function(response) {
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
                    $.ajax({
                        url: '{{ route('getmitem') }}',
                        method: 'post',
                        data: {
                            'kode': kode
                        },
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        dataType: 'json',
                        success: function(response) {

                        }
                    });
                });
            });

            $('#datatable').DataTable({
                "bInfo": false,
            });
        })
    </script>
@endsection
