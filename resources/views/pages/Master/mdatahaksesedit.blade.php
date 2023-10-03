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
                                        <option disabled selected value="{{ $hakakses_user->nik }}">{{ $hakakses_user->nik }}</option>
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
                                        <option disabled selected value="{{ $mhakakses->counter }}">{{ $mhakakses->counter }}</option>
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
                                                            @if($auth_mitem->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mitem" value="Y" checked>
                                                            @elseif($auth_mitem->save == 'N' || $auth_mitem->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mitem" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mitem->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mitem" value="Y" checked>
                                                            @elseif($auth_mitem->open == 'N' || $auth_mitem->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mitem" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mitem->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mitem" value="Y" checked>
                                                            @elseif($auth_mitem->updt == 'N' || $auth_mitem->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mitem" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mitem->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mitem" value="Y" checked>
                                                                @elseif($auth_mitem->dlt == 'N' || $auth_mitem->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mitem" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mitem->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mitem" value="Y" checked>
                                                                @elseif($auth_mitem->print == 'N' || $auth_mitem->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mitem" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='muser'></td>
                                                    <td class="border border-5">Master User / SPG</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_muser->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_muser" value="Y" checked>
                                                            @elseif($auth_muser->save == 'N' || $auth_muser->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_muser" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_muser->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_muser" value="Y" checked>
                                                            @elseif($auth_muser->open == 'N' || $auth_muser->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_muser" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_muser->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_muser" value="Y" checked>
                                                            @elseif($auth_muser->updt == 'N' || $auth_muser->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_muser" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_muser->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_muser" value="Y" checked>
                                                                @elseif($auth_muser->dlt == 'N' || $auth_muser->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_muser" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_muser->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_muser" value="Y" checked>
                                                                @elseif($auth_muser->print == 'N' || $auth_muser->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_muser" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mwarna'></td>
                                                    <td class="border border-5">Master Warna</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mwarna->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mwarna" value="Y" checked>
                                                            @elseif($auth_mwarna->save == 'N' || $auth_mwarna->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mwarna" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mwarna->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mwarna" value="Y" checked>
                                                            @elseif($auth_mwarna->open == 'N' || $auth_mwarna->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mwarna" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mwarna->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mwarna" value="Y" checked>
                                                            @elseif($auth_mwarna->updt == 'N' || $auth_mwarna->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mwarna" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mwarna->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mwarna" value="Y" checked>
                                                                @elseif($auth_mwarna->dlt == 'N' || $auth_mwarna->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mwarna" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mwarna->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mwarna" value="Y" checked>
                                                                @elseif($auth_mwarna->print == 'N' || $auth_mwarna->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mwarna" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mcounter'></td>
                                                    <td class="border border-5">Master Counter / Lokasi</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mcounter->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mcounter" value="Y" checked>
                                                            @elseif($auth_mcounter->save == 'N' || $auth_mcounter->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mcounter" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mcounter->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mcounter" value="Y" checked>
                                                            @elseif($auth_mcounter->open == 'N' || $auth_mcounter->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mcounter" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mcounter->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mcounter" value="Y" checked>
                                                            @elseif($auth_mcounter->updt == 'N' || $auth_mcounter->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mcounter" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mcounter->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mcounter" value="Y" checked>
                                                                @elseif($auth_mcounter->dlt == 'N' || $auth_mcounter->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mcounter" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mcounter->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mcounter" value="Y" checked>
                                                                @elseif($auth_mcounter->print == 'N' || $auth_mcounter->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mcounter" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>                                                
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mhakses'></td>
                                                    <td class="border border-5">Master Hak Akses</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mhakses->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mhakses" value="Y" checked>
                                                            @elseif($auth_mhakses->save == 'N' || $auth_mhakses->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_mhakses" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mhakses->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mhakses" value="Y" checked>
                                                            @elseif($auth_mhakses->open == 'N' || $auth_mhakses->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_mhakses" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mhakses->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mhakses" value="Y" checked>
                                                            @elseif($auth_mhakses->updt == 'N' || $auth_mhakses->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_mhakses" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mhakses->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mhakses" value="Y" checked>
                                                                @elseif($auth_mhakses->dlt == 'N' || $auth_mhakses->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_mhakses" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_mhakses->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mhakses" value="Y" checked>
                                                                @elseif($auth_mhakses->print == 'N' || $auth_mhakses->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_mhakses" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tsob'></td>
                                                    <td class="border border-5">Trans SOB</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsob->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tsob" value="Y" checked>
                                                            @elseif($auth_tsob->save == 'N' || $auth_tsob->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tsob" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsob->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tsob" value="Y" checked>
                                                            @elseif($auth_tsob->open == 'N' || $auth_tsob->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tsob" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsob->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tsob" value="Y" checked>
                                                            @elseif($auth_tsob->updt == 'N' || $auth_tsob->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tsob" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsob->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tsob" value="Y" checked>
                                                                @elseif($auth_tsob->dlt == 'N' || $auth_tsob->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tsob" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsob->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tsob" value="Y" checked>
                                                                @elseif($auth_tsob->print == 'N' || $auth_tsob->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tsob" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tpenerimaan'></td>
                                                    <td class="border border-5">Trans Penerimaan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tpenerimaan->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tpenerimaan" value="Y" checked>
                                                            @elseif($auth_tpenerimaan->save == 'N' || $auth_tpenerimaan->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tpenerimaan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tpenerimaan->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tpenerimaan" value="Y" checked>
                                                            @elseif($auth_tpenerimaan->open == 'N' || $auth_tpenerimaan->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tpenerimaan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tpenerimaan->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tpenerimaan" value="Y" checked>
                                                            @elseif($auth_tpenerimaan->updt == 'N' || $auth_tpenerimaan->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tpenerimaan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tpenerimaan->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tpenerimaan" value="Y" checked>
                                                                @elseif($auth_tpenerimaan->dlt == 'N' || $auth_tpenerimaan->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tpenerimaan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tpenerimaan->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tpenerimaan" value="Y" checked>
                                                                @elseif($auth_tpenerimaan->print == 'N' || $auth_tpenerimaan->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tpenerimaan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tretur'></td>
                                                    <td class="border border-5">Trans Retur Penjualan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tretur->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tretur" value="Y" checked>
                                                            @elseif($auth_tretur->save == 'N' || $auth_tretur->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tretur" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tretur->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tretur" value="Y" checked>
                                                            @elseif($auth_tretur->open == 'N' || $auth_tretur->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tretur" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tretur->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tretur" value="Y" checked>
                                                            @elseif($auth_tretur->updt == 'N' || $auth_tretur->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tretur" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tretur->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tretur" value="Y" checked>
                                                                @elseif($auth_tretur->dlt == 'N' || $auth_tretur->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tretur" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tretur->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tretur" value="Y" checked>
                                                                @elseif($auth_tretur->print == 'N' || $auth_tretur->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tretur" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tbonjual'></td>
                                                    <td class="border border-5">Trans Bon Penjualan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbonjual->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tbonjual" value="Y" checked>
                                                            @elseif($auth_tbonjual->save == 'N' || $auth_tbonjual->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tbonjual" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbonjual->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tbonjual" value="Y" checked>
                                                            @elseif($auth_tbonjual->open == 'N' || $auth_tbonjual->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tbonjual" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbonjual->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tbonjual" value="Y" checked>
                                                            @elseif($auth_tbonjual->updt == 'N' || $auth_tbonjual->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tbonjual" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbonjual->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tbonjual" value="Y" checked>
                                                                @elseif($auth_tbonjual->dlt == 'N' || $auth_tbonjual->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tbonjual" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbonjual->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tbonjual" value="Y" checked>
                                                                @elseif($auth_tbonjual->print == 'N' || $auth_tbonjual->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tbonjual" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tadjstock'></td>
                                                    <td class="border border-5">Trans Adjustment Stock</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tadjstock->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tadjstock" value="Y" checked>
                                                            @elseif($auth_tadjstock->save == 'N' || $auth_tadjstock->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tadjstock" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tadjstock->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tadjstock" value="Y" checked>
                                                            @elseif($auth_tadjstock->open == 'N' || $auth_tadjstock->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tadjstock" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tadjstock->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tadjstock" value="Y" checked>
                                                            @elseif($auth_tadjstock->updt == 'N' || $auth_tadjstock->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tadjstock" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tadjstock->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tadjstock" value="Y" checked>
                                                                @elseif($auth_tadjstock->dlt == 'N' || $auth_tadjstock->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tadjstock" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tadjstock->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tadjstock" value="Y" checked>
                                                                @elseif($auth_tadjstock->print == 'N' || $auth_tadjstock->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tadjstock" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tsuratjalan'></td>
                                                    <td class="border border-5">Trans Surat Jalan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsuratjalan->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tsuratjalan" value="Y" checked>
                                                            @elseif($auth_tsuratjalan->save == 'N' || $auth_tsuratjalan->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tsuratjalan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsuratjalan->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tsuratjalan" value="Y" checked>
                                                            @elseif($auth_tsuratjalan->open == 'N' || $auth_tsuratjalan->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tsuratjalan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsuratjalan->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tsuratjalan" value="Y" checked>
                                                            @elseif($auth_tsuratjalan->updt == 'N' || $auth_tsuratjalan->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tsuratjalan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsuratjalan->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tsuratjalan" value="Y" checked>
                                                                @elseif($auth_tsuratjalan->dlt == 'N' || $auth_tsuratjalan->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tsuratjalan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tsuratjalan->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tsuratjalan" value="Y" checked>
                                                                @elseif($auth_tsuratjalan->print == 'N' || $auth_tsuratjalan->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tsuratjalan" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tstopname'></td>
                                                    <td class="border border-5">Trans Stock Opname</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tstopname->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tstopname" value="Y" checked>
                                                            @elseif($auth_tstopname->save == 'N' || $auth_tstopname->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tstopname" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tstopname->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tstopname" value="Y" checked>
                                                            @elseif($auth_tstopname->open == 'N' || $auth_tstopname->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tstopname" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tstopname->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tstopname" value="Y" checked>
                                                            @elseif($auth_tstopname->updt == 'N' || $auth_tstopname->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tstopname" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tstopname->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tstopname" value="Y" checked>
                                                                @elseif($auth_tstopname->dlt == 'N' || $auth_tstopname->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tstopname" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tstopname->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tstopname" value="Y" checked>
                                                                @elseif($auth_tstopname->print == 'N' || $auth_tstopname->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tstopname" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='tbelibrg'></td>
                                                    <td class="border border-5">Trans Pembelian Barang</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbelibrg->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tbelibrg" value="Y" checked>
                                                            @elseif($auth_tbelibrg->save == 'N' || $auth_tbelibrg->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_tbelibrg" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbelibrg->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tbelibrg" value="Y" checked>
                                                            @elseif($auth_tbelibrg->open == 'N' || $auth_tbelibrg->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_tbelibrg" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbelibrg->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tbelibrg" value="Y" checked>
                                                            @elseif($auth_tbelibrg->updt == 'N' || $auth_tbelibrg->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_tbelibrg" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbelibrg->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tbelibrg" value="Y" checked>
                                                                @elseif($auth_tbelibrg->dlt == 'N' || $auth_tbelibrg->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_tbelibrg" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_tbelibrg->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tbelibrg" value="Y" checked>
                                                                @elseif($auth_tbelibrg->print == 'N' || $auth_tbelibrg->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_tbelibrg" value="Y">
                                                            @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='romsetperitem'></td>
                                                    <td class="border border-5">Laporan Omset Per-Item</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetperitem->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_romsetperitem" value="Y" checked>
                                                            @elseif($auth_romsetperitem->save == 'N' || $auth_romsetperitem->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_romsetperitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetperitem->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_romsetperitem" value="Y" checked>
                                                            @elseif($auth_romsetperitem->open == 'N' || $auth_romsetperitem->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_romsetperitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetperitem->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_romsetperitem" value="Y" checked>
                                                            @elseif($auth_romsetperitem->updt == 'N' || $auth_romsetperitem->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_romsetperitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetperitem->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_romsetperitem" value="Y" checked>
                                                                @elseif($auth_romsetperitem->dlt == 'N' || $auth_romsetperitem->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_romsetperitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetperitem->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_romsetperitem" value="Y" checked>
                                                                @elseif($auth_romsetperitem->print == 'N' || $auth_romsetperitem->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_romsetperitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='romsetpercounter'></td>
                                                    <td class="border border-5">Laporan Omset Per-Counter</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetpercounter->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_romsetpercounter" value="Y" checked>
                                                            @elseif($auth_romsetpercounter->save == 'N' || $auth_romsetpercounter->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_romsetpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetpercounter->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_romsetpercounter" value="Y" checked>
                                                            @elseif($auth_romsetpercounter->open == 'N' || $auth_romsetpercounter->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_romsetpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetpercounter->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_romsetpercounter" value="Y" checked>
                                                            @elseif($auth_romsetpercounter->updt == 'N' || $auth_romsetpercounter->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_romsetpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetpercounter->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_romsetpercounter" value="Y" checked>
                                                                @elseif($auth_romsetpercounter->dlt == 'N' || $auth_romsetpercounter->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_romsetpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_romsetpercounter->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_romsetpercounter" value="Y" checked>
                                                                @elseif($auth_romsetpercounter->print == 'N' || $auth_romsetpercounter->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_romsetpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='rstockpercounter'></td>
                                                    <td class="border border-5">Laporan Stock Per-Counter</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockpercounter->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_rstockpercounter" value="Y" checked>
                                                            @elseif($auth_rstockpercounter->save == 'N' || $auth_rstockpercounter->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_rstockpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockpercounter->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_rstockpercounter" value="Y" checked>
                                                            @elseif($auth_rstockpercounter->open == 'N' || $auth_rstockpercounter->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_rstockpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockpercounter->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_rstockpercounter" value="Y" checked>
                                                            @elseif($auth_rstockpercounter->updt == 'N' || $auth_rstockpercounter->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_rstockpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockpercounter->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_rstockpercounter" value="Y" checked>
                                                                @elseif($auth_rstockpercounter->dlt == 'N' || $auth_rstockpercounter->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_rstockpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockpercounter->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_rstockpercounter" value="Y" checked>
                                                                @elseif($auth_rstockpercounter->print == 'N' || $auth_rstockpercounter->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_rstockpercounter" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='rmutasistock'></td>
                                                    <td class="border border-5">Laporan Mutasi Stock</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rmutasistock->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_rmutasistock" value="Y" checked>
                                                            @elseif($auth_rmutasistock->save == 'N' || $auth_rmutasistock->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_rmutasistock" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rmutasistock->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_rmutasistock" value="Y" checked>
                                                            @elseif($auth_rmutasistock->open == 'N' || $auth_rmutasistock->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_rmutasistock" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rmutasistock->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_rmutasistock" value="Y" checked>
                                                            @elseif($auth_rmutasistock->updt == 'N' || $auth_rmutasistock->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_rmutasistock" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rmutasistock->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_rmutasistock" value="Y" checked>
                                                                @elseif($auth_rmutasistock->dlt == 'N' || $auth_rmutasistock->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_rmutasistock" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rmutasistock->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_rmutasistock" value="Y" checked>
                                                                @elseif($auth_rmutasistock->print == 'N' || $auth_rmutasistock->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_rmutasistock" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='rstockoverview'></td>
                                                    <td class="border border-5">Laporan Stock Overview</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockoverview->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_rstockoverview" value="Y" checked>
                                                            @elseif($auth_rstockoverview->save == 'N' || $auth_rstockoverview->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_rstockoverview" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockoverview->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_rstockoverview" value="Y" checked>
                                                            @elseif($auth_rstockoverview->open == 'N' || $auth_rstockoverview->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_rstockoverview" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockoverview->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_rstockoverview" value="Y" checked>
                                                            @elseif($auth_rstockoverview->updt == 'N' || $auth_rstockoverview->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_rstockoverview" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockoverview->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_rstockoverview" value="Y" checked>
                                                                @elseif($auth_rstockoverview->dlt == 'N' || $auth_rstockoverview->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_rstockoverview" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_rstockoverview->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_rstockoverview" value="Y" checked>
                                                                @elseif($auth_rstockoverview->print == 'N' || $auth_rstockoverview->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_rstockoverview" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='umdataitem'></td>
                                                    <td class="border border-5">Upload Master Data Item</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umdataitem->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_umdataitem" value="Y" checked>
                                                            @elseif($auth_umdataitem->save == 'N' || $auth_umdataitem->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_umdataitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umdataitem->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_umdataitem" value="Y" checked>
                                                            @elseif($auth_umdataitem->open == 'N' || $auth_umdataitem->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_umdataitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umdataitem->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_umdataitem" value="Y" checked>
                                                            @elseif($auth_umdataitem->updt == 'N' || $auth_umdataitem->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_umdataitem" value="Y">
                                                            @endif
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umdataitem->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_umdataitem" value="Y" checked>
                                                                @elseif($auth_umdataitem->dlt == 'N' || $auth_umdataitem->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_umdataitem" value="Y">
                                                            @endif
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_umdataitem" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umdataitem->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_umdataitem" value="Y" checked>
                                                                @elseif($auth_umdataitem->print == 'N' || $auth_umdataitem->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_umdataitem" value="Y">
                                                            @endif
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
                                                            @if($auth_umitemcounter->save == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_umitemcounter" value="Y" checked>
                                                            @elseif($auth_umitemcounter->save == 'N' || $auth_umitemcounter->save == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="create_umitemcounter" value="Y">
                                                            @endif
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umitemcounter->open == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_umitemcounter" value="Y" checked>
                                                            @elseif($auth_umitemcounter->open == 'N' || $auth_umitemcounter->open == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="read_umitemcounter" value="Y">
                                                            @endif
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umitemcounter->updt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_umitemcounter" value="Y" checked>
                                                            @elseif($auth_umitemcounter->updt == 'N' || $auth_umitemcounter->updt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="update_umitemcounter" value="Y">
                                                            @endif
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umitemcounter->dlt == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_umitemcounter" value="Y" checked>
                                                                @elseif($auth_umitemcounter->dlt == 'N' || $auth_umitemcounter->dlt == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="delete_umitemcounter" value="Y">
                                                            @endif
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_umitemcounter" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            @if($auth_umitemcounter->print == 'Y')
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_umitemcounter" value="Y" checked>
                                                                @elseif($auth_umitemcounter->print == 'N' || $auth_umitemcounter->print == null)
                                                                <input class="form-check-input checkbox" type="checkbox" name="print_umitemcounter" value="Y">
                                                            @endif
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
                        <button class="btn btn-primary mr-1" type="submit" formaction="/mhakses/{{ $mhakakses->id_user }}" id="confirm">Update</button>
                        <button class="btn btn-secondary" type="reset">Cancel</button>
                    </div>
                    </form>
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
        nik = $("#nik").val();
        password = $("#password").val();
        counter = $("#counter").prop('selectedIndex');
        if (nik == ""){
            swal('WARNING', 'NIK Tidak boleh kosong!', 'warning');
            return false;
        }
        // else if (counter == 0){
        //     swal('WARNING', 'Please select Counter!', 'warning');
        //     return false;
        // }
    });

    $('#datatable').DataTable({
        // "ordering":false,
        "bInfo" : false
    });
</script>    
@endsection