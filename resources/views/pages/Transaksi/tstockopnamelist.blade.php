@extends('layouts.main')
@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Stock Opname List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Transaction</a></div>
                <div class="breadcrumb-item"><a class="text-muted">Stock Opname List</a></div>
            </div>
        </div>
        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    @include('layouts.flash-message')
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <a href="{{ route('tstockopname') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Tambah Stock Opname
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="datatable">
                                    <thead>
                                        <tr>
                                            <th class="border border-5" style="text-align:center;">No</th>
                                            <th class="border border-5" style="text-align:center;">No Trans</th>
                                            <th class="border border-5" style="text-align:center;">Tanggal</th>
                                            <th class="border border-5" style="text-align:center;">Counter</th>
                                            <th class="border border-5" style="text-align:center;">Catatan</th>
                                            <th class="border border-5" style="text-align:center;">Status</th>
                                            <th class="border border-5" style="text-align:center;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php $no = 0; @endphp
                                        @foreach ($data as $item)
                                            @php $no++; @endphp
                                            <tr>
                                                <td class="border border-5" style="text-align:center;">{{ $no }}
                                                </td>
                                                <td class="border border-5" style="text-align:center;">{{ $item->no }}
                                                </td>
                                                <td class="border border-5" style="text-align:center;">
                                                    {{ date('Y-m-d', strtotime($item->tanggal)) }}</td>
                                                <td class="border border-5" style="text-align:center;">{{ $item->counter }}
                                                </td>
                                                <td class="border border-5">{{ $item->note }}</td>
                                                <td class="border border-5" style="text-align:center;">
                                                    <span
                                                        class="badge badge-{{ $item->status == 'POSTED' ? 'success' : 'secondary' }}">
                                                        {{ $item->status ?? '-' }}
                                                    </span>
                                                </td>
                                                <td class="border border-5" style="text-align:center;">
                                                    <a href="{{ route('tstockopnameedit', $item->id) }}"
                                                        class="btn btn-sm btn-primary"><i class="far fa-edit"></i> Edit</a>
                                                    <form action="{{ route('tstockopnamedelete', $item->id) }}"
                                                        id="del-{{ $item->id }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        <button class="btn btn-sm btn-danger" type="submit"
                                                            data-confirm="WARNING!|Hapus data {{ $item->notrans }}?"
                                                            data-confirm-yes="submitDel({{ $item->id }})">
                                                            <i class="fa fa-trash"></i> Delete
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
@section('botscripts')
    <script>
        $('#datatable').DataTable({
            "bInfo": false
        });

        $(".alert button.close").click(function() {
            $(this).parent().fadeOut(2000);
        });

        function submitDel(id) {
            $('#del-' + id).submit();
        }
    </script>
@endsection
