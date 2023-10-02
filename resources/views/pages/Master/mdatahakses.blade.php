@extends('layouts.main')
@section('content')
<section class="section">
    <div class="section-header">
        <h1>Master Data</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Master Data</a></div>
            <div class="breadcrumb-item"><a class="text-muted">Master Hak Akses</a></div>
        </div>
    </div>
    @php
        $role = session('privilage') ;
        $muser_save = session('muser_save');
        $muser_updt = session('muser_updt');
        $muser_dlt = session('muser_dlt');
    @endphp
    <div class="section-body">
        <div class="row">
            <div class="col-12 col-md-12 col-lg-12">
                @include('layouts.flash-message')
            </div>
        </div>
        <div class="row">
            <div class="col-12 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-header">
                        <h4>Master Hak Akses</h4>
                    </div>
                    <form action="" method="POST">
                        @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>NIK</label>
                                    <select class="form-control select2" name="nik" id="nik">
                                        <option disabled selected>--Select NIK--</option>
                                        @foreach($users as $user)
                                        <option value="{{ $user->nik }}">{{ $user->nik." - ".$user->name }}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Counter</label>
                                    <select class="form-control select2" name="counter" id="counter">
                                        <option disabled selected>--Select Counter--</option>
                                        @foreach($counters as $counter)
                                        <option>{{ $counter->name }}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        {{-- <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" class="form-control" name="password" id="password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Branch</label>
                                    <select class="form-control" name="branch" id="branch">
                                        <option disabled selected>--Select Branch--</option>
                                        @foreach($branhcs as $data => $branch)
                                        <option>{{ $branch->name }}</option>                                            
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div> --}}
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="d-block">Admin Privilage</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="create_acs" id="checkall" checked>
                                        <label class="form-check-label" for="flexCheckDefault">
                                          Check All
                                        </label>
                                      </div>
                                      {{-- <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="read_acs" value="R" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                          Read
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="update_acs" value="U" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                          Update
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delete_acs" value="D" checked>
                                        <label class="form-check-label" for="flexCheckChecked">
                                          Delete
                                        </label>
                                      </div> --}}
                                </div>                                
                            </div>
                        </div>
                        <div class="row pt-3">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <div class="table-responsive">
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th scope="col" class="border border-5">Feature</th>
                                                    <th scope="col" class="border border-5">Create</th>
                                                    <th scope="col" class="border border-5">Read</th>
                                                    <th scope="col" class="border border-5">Update</th>
                                                    <th scope="col" class="border border-5">Delete</th>
                                                    <th scope="col" class="border border-5">Print</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mitem'></td>
                                                    <td class="border border-5">Master Item</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_mitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_mitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_mitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_mitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_mitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='muser'></td>
                                                    <td class="border border-5">Master User / SPG</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_muser" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_muser" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_muser" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_muser" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_muser" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mwarna'></td>
                                                    <td class="border border-5">Master Warna</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_mwarna" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_mwarna" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_mwarna" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_mwarna" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_mwarna" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mcounter'></td>
                                                    <td class="border border-5">Master Counter / Lokasi</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_mcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_mcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_mcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_mcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_mcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mhakses'></td>
                                                    <td class="border border-5">Master Hak Akses</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_mhakses" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_mhakses" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_mhakses" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_mhakses" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_mhakses" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tsob'></td>
                                                    <td class="border border-5">Trans SOB</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tsob" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tsob" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tsob" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tsob" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tsob" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tpenerimaan'></td>
                                                    <td class="border border-5">Trans Penerimaan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tpenerimaan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tpenerimaan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tpenerimaan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tpenerimaan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tpenerimaan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tretur'></td>
                                                    <td class="border border-5">Trans Retur Penjualan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tretur" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tretur" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tretur" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tretur" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tretur" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tbonjual'></td>
                                                    <td class="border border-5">Trans Bon Penjualan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tbonjual" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tbonjual" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tbonjual" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tbonjual" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tbonjual" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tadjstock'></td>
                                                    <td class="border border-5">Trans Adjustment Stock</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tadjstock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tadjstock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tadjstock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tadjstock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tadjstock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tsuratjalan'></td>
                                                    <td class="border border-5">Trans Surat Jalan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tsuratjalan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tsuratjalan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tsuratjalan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tsuratjalan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tsuratjalan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tstopname'></td>
                                                    <td class="border border-5">Trans Stock Opname</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tstopname" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tstopname" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tstopname" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tstopname" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tstopname" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tbelibrg'></td>
                                                    <td class="border border-5">Trans Pembelian Barang</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_tbelibrg" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_tbelibrg" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_tbelibrg" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_tbelibrg" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_tbelibrg" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='romsetperitem'></td>
                                                    <td class="border border-5">Laporan Omset Per-Item</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_romsetperitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_romsetperitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_romsetperitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_romsetperitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_romsetperitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='romsetpercounter'></td>
                                                    <td class="border border-5">Laporan Omset Per-Counter</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_romsetpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_romsetpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_romsetpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_romsetpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_romsetpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='rstockpercounter'></td>
                                                    <td class="border border-5">Laporan Stock Per-Counter</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_rstockpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_rstockpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_rstockpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_rstockpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_rstockpercounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='rmutasistock'></td>
                                                    <td class="border border-5">Laporan Mutasi Stock</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_rmutasistock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_rmutasistock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_rmutasistock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_rmutasistock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_rmutasistock" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='rstockoverview'></td>
                                                    <td class="border border-5">Laporan Stock Overview</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_rstockoverview" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_rstockoverview" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_rstockoverview" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_rstockoverview" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_rstockoverview" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='umdataitem'></td>
                                                    <td class="border border-5">Upload Master Data Item</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_umdataitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_umdataitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_umdataitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_umdataitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_umdataitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='umitemcounter'></td>
                                                    <td class="border border-5">Upload Master Data Item Counter</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <button class="btn btn-primary mr-1" type="submit" formaction="{{ route('mhaksespost') }}" id="confirm">Save</button>
                        <button class="btn btn-secondary" type="reset">Cancel</button>
                    </div>
                    </form>
                </div>
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
                                        <th scope="col" class="border border-5" style="text-align: center;">No</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">NIK</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Counter</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Privilage Status</th>
                                        <th scope="col" class="border border-5" style="text-align: center;">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                    $no = 0;
                                    @endphp
                                    @foreach($datas as $key => $item)   
                                        @php $no++; @endphp  
                                            <tr>
                                                <th scope="row" class="border border-5" style="text-align: center;">{{ $no }}</th>
                                                <td class="border border-5" style="text-align: center;">{{ $item->nik }}</td>
                                                <td class="border border-5" style="text-align: center;">{{ $item->counter }}</td>
                                                @if ($item->acs_stat == null || $item->acs_stat == 'N')
                                                    <td class="border border-5" style="text-align: center;">Unregister</td>
                                                @elseif($item->acs_stat == 'Y')
                                                    <td class="border border-5" style="text-align: center;">Registred</td>
                                                @endif
                                                <td style="text-align: center;" class="d-flex justify-content-center">
                                                    @if ($item->acs_stat == null || $item->acs_stat == 'N')
                                                    <a href="/mhakses/{{ $item->id }}/edit"
                                                        class="btn btn-icon icon-left btn-primary" style="cursor: not-allowed; opacity: 0.5; pointer-events: none;" disabled><i class="far fa-edit">
                                                            Edit</i></a>
                                                    <form action="/mhakses/delete/{{ $item->id }}" id="del-{{ $item->id }}"
                                                        method="POST" class="px-2">
                                                        @csrf
                                                        <button disabled class="btn btn-icon icon-left btn-danger" style="cursor: not-allowed; opacity: 0.5;"
                                                            id="del-{{ $item->id }}" type="submit"
                                                            data-confirm="WARNING!|Do you want to delete {{ $item->id }} data?"
                                                            data-confirm-yes="submitDel({{ $item->id }})"><i
                                                                class="fa fa-trash">
                                                                Delete</i></button>
                                                    </form>
                                                    @elseif($item->acs_stat == 'Y')
                                                    <a href="/mhakses/{{ $item->id }}/edit"
                                                        class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                            Edit</i></a>
                                                    <form action="/mhakses/delete/{{ $item->id }}" id="del-{{ $item->id }}"
                                                        method="POST" class="px-2">
                                                        @csrf
                                                        <button class="btn btn-icon icon-left btn-danger"
                                                            id="del-{{ $item->id }}" type="submit"
                                                            data-confirm="WARNING!|Do you want to delete {{ $item->id }} data?"
                                                            data-confirm-yes="submitDel({{ $item->id }})"><i
                                                                class="fa fa-trash">
                                                                Delete</i></button>
                                                    </form>
                                                    @endif
                                                </td>
                                            </tr>
                                        @php
                                        $nik = $item->nik;
                                        @endphp
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
<script type="text/javascript">
    $(document).ready(function() {
        $('#checkall').click(function(){
            if($(".checkbox").is(":checked")){
                console.log("Checkbox is checked.");
                $('.checkbox').prop('checked', false)
            }
            else if($(".checkbox").is(":not(:checked)")){
                console.log("Checkbox is unchecked.");
                $('.checkbox').prop('checked', true)
            }
        });
    });

    $(document).on("click","#confirm",function(e){
        // Validate ifnull        
        nik = $("#nik").prop('selectedIndex');
        password = $("#password").val();
        counter = $("#counter").prop('selectedIndex');
        if (nik == 0){
            swal('WARNING', 'NIK Tidak boleh kosong!', 'warning');
            return false;
        }else if (counter == 0){
            swal('WARNING', 'Please select Counter!', 'warning');
            return false;
        }
    });

    function submitDel(id){
        $('#del-'+id).submit()
    }

    $('#datatable').DataTable({
        // "ordering":false,
        "bInfo" : false
    });
</script>    
@endsection