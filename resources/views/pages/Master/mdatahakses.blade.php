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
                                    <label>Username</label>
                                    <input type="text" class="form-control" name="username" id="username">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Counter</label>
                                    <select class="form-control" name="counter" id="counter">
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
                                                    <td class="border border-5">Master User</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_user" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_user" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_user" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_user" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_user" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='msatuan'></td>
                                                    <td class="border border-5">Master Satuan</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_satuan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_satuan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_satuan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_satuan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_satuan" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td hidden><input style='width:120px;' readonly class='noteclass form-control' name='features[]' type='text' value='mdtgrp'></td>
                                                    <td class="border border-5">Master Data Group</td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="create_group" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="read_group" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="update_group" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="delete_group" value="Y" checked>
                                                            {{-- <label class="form-check-label" for="flexCheckDefault">Create</label> --}}
                                                        </div>
                                                    </td>
                                                    <td class="border border-5 text-center pb-3">
                                                        <div class="form-check">
                                                            <input class="form-check-input checkbox" type="checkbox" name="print_group" value="Y" checked>
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
                        <button class="btn btn-primary mr-1" type="submit" formaction="" id="confirm">Save</button>
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
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col" class="border border-5">No</th>
                                        <th scope="col" class="border border-5">Name</th>
                                        <th scope="col" class="border border-5">Email</th>
                                        <th scope="col" class="border border-5">Branch</th>
                                        <th scope="col" class="border border-5">Edit</th>
                                        <th scope="col" class="border border-5">Delete</th>
                                    </tr>
                                </thead>
                                {{-- <tbody>
                                    @php 
                                    $no = 0;
                                    @endphp
                                    @foreach($datas as $key => $item)
                                    @php $no++; @endphp
                                    <tr>
                                        <th scope="row" class="border border-5">{{ $no }}</th>
                                        <td class="border border-5">{{ $item->username }}</td>
                                        <td class="border border-5">{{ $item->email }}</td>
                                        <td class="border border-5">{{ $item->branch }}</td>
                                        @if($muser_updt == 'Y')
                                        <td class="border border-5"><a href="/materdatauser/{{ $item->id }}/edit"
                                            class="btn btn-icon icon-left btn-primary"><i class="far fa-edit">
                                                Edit</i></a></td>
                                        @elseif($muser_updt == null || $muser_updt == 'N')
                                        <td class="border border-5"><a href="/materdatauser/{{ $item->id }}/edit"
                                            class="btn btn-icon icon-left btn-primary" style="pointer-events: none;"><i class="far fa-edit">
                                                Edit</i></a></td>
                                        @endif
                                        <td class="border border-5">
                                            <form action="/materdatauser/delete/{{ $item->id }}" id="del-{{ $item->id }}"
                                                method="POST">
                                                @csrf
                                                @if($muser_dlt == 'Y')
                                                <button class="btn btn-icon icon-left btn-danger"
                                                    id="del-{{ $item->id }}" type="submit"
                                                    data-confirm="WARNING!|Do you want to delete {{ $item->username }} data?"
                                                    data-confirm-yes="submitDel({{ $item->id }})"><i
                                                        class="fa fa-trash">
                                                        Delete</i></button>
                                                @elseif($muser_dlt == null || $muser_dlt == 'N')
                                                <button class="btn btn-icon icon-left btn-danger"
                                                    id="del-{{ $item->id }}" type="submit"
                                                    data-confirm="WARNING!|Do you want to delete {{ $item->username }} data?"
                                                    data-confirm-yes="submitDel({{ $item->id }})" disabled><i
                                                        class="fa fa-trash">
                                                        Delete</i></button>
                                                @endif
                                            </form>
                                        </td>
                                    </tr>                                    
                                    @endforeach
                                </tbody> --}}
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
        username = $("#username").val();
        password = $("#password").val();
        branch = $("#branch").prop('selectedIndex');
        if (username == ""){
            swal('WARNING', 'Username Tidak boleh kosong!', 'warning');
            return false;
        }else if (password == '' || password == null){
            swal('WARNING', 'password Tidak boleh kosong!', 'warning');
            return false;
        }else if (branch == 0){
            swal('WARNING', 'Please select Branch!', 'warning');
            return false;
        }
    });
</script>    
@endsection