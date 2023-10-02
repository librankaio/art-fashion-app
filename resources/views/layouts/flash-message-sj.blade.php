@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button> 
    <strong>SUCCESS : {{ $message }}</strong>
</div>
@endif

@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert" id="btnclose">×</button> 
    <strong>FAILED : {{ $message }}</strong> <br>
    <strong>Counter Pilihan : {{ Session::get('counter_selected') }}</strong>
    <div class="card-body">
        <div id="accordion">
          <div class="accordion">
            <div class="accordion-header" role="button" data-toggle="collapse" data-target="#panel-body-1" aria-expanded="true" style="background-color: #fc544b;">
              <h4>(Click For Details) Error Item : </h4>
            </div>
            <div class="accordion-body collapse show" id="panel-body-1" data-parent="#accordion">
              <p class="mb-0">- Item Code: {{ Session::get('items_error')[0] }}</p>
            </div>
          </div>
        </div>
      </div>
</div>
@endif
   
@if ($message = Session::get('warning'))
<div class="alert alert-warning alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>WARNING : {{ $message }}</strong>
</div>
@endif
   
@if ($message = Session::get('info'))
<div class="alert alert-info alert-block alert-dismissible">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    <strong>INFO : {{ $message }}</strong>
</div>
@endif
  
@if ($errors->any())
<div class="alert alert-danger">
    <button type="button" class="close" data-dismiss="alert">×</button>    
    Please check the form below for errors
</div>
@endif