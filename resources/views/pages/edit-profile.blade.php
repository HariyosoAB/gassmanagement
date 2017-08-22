@extends('master.master')

@section('judul')
Edit Account
@stop

@section('content')
@if (session('failed'))
		<div class="alert alert-danger">
				{{ session('failed') }}
		</div>
@endif
@if (session('success'))
		<div class="alert alert-success">
				{{ session('success') }}
		</div>
@endif
<style media="screen">
.ss{
  background-color: #364150;
  height : 100vh;
}
.blove{
  background-color:#32c5d2;
  color: white;
  padding: 15px;
}
.jud{
  font-family: bebas;
}
.inputs{
  background-color:#dde3ec;
  padding:20px;
}

</style>
<div class="col-md-12" style="background-color:white; padding 20px;">
  <div style="background-color:white;">
    <div >
      <form id="formreg" action="{{url('/')}}/editaccount/{{$user->user_id}}" method="post" style="margin-top:10px">
        <div class="row">
          <div class="col-md-6 col-xs-12">
            <div class="form-group">
              <label >ID Number</label>
              <input type="text"  class="form-control"name="id" value="{{$user->user_no_pegawai}}"  placeholder="ID Number" required>
            </div>
            <div class="form-group">
              <label >Name</label>
              <input type="text"  class="form-control"name="name" value="{{$user->user_nama}}"  placeholder="Name" required>
            </div>
            <div class="form-group">
              <label >Unit</label>
              <input class="form-control"  type="text" name="unit" value="{{$user->user_unit}}">
            </div>
            <div  class="form-group">
              <label >Sub Unit</label>
              <input class="form-control"  type="text" name="subunit" value="{{$user->user_subunit}}">
            </div>
            <div class="form-group">
              <label >Telephone Number</label>
              <input type="text"  class="form-control" name="number" value="{{$user->user_telp}}"  placeholder="Telephone Number" required>
            </div>
          </div>
          <div class="col-md-6 col-xs-12">
            <div class="form-group">
              <label >Email</label>
              <input type="email"  class="form-control" name="email" value="{{$user->user_email}}"  placeholder="Email" required>
            </div>
            <div class="form-group">
              <label >Jabatan</label>
              <input type="text" class="form-control"name="position"  value="{{$user->user_jabatan}}">
            </div>
            <div class="form-group">
              <label >Old Password</label>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input data-toggle="popover" title="Warning!" data-placement="bottom" data-content="Password must be at least 8 characters" type="password" id="passold" class="form-control" name="oldpassword" value=""  placeholder="Type your old password" required>
              <small>Leave this form empty if there are no password changes</small>
            </div>
            <div class="form-group">
              <label >New Password</label>
              <input type="hidden" name="_token" value="{{ csrf_token() }}">
              <input data-toggle="popover" title="Warning!" data-placement="bottom" data-content="Password must be at least 8 characters" type="password" id="pass" class="form-control" name="newpassword" value=""  placeholder="Password" required>
              <small>Leave this form empty if there are no password changes</small>
            </div>
            <div class="form-group">
              <label >Verify New Password</label>
              <input id="ver"data-toggle="popover" title="Warning!" data-placement="bottom" data-content="Password doesn't match" type="password"  class="form-control" name="passwordv" value=""  placeholder="Verify Password" required>
              <small>Leave this form empty if there are no password changes</small>
            </div>
            <div class="form-group ">
              <button type="submit" class="blove col-md-3 btn" >
                Submit
              </button>
            </div>
          </div>
          </div>
        </div>
    </form>
  </div>
</div>

<script type="text/javascript">
var regex;
var valid1;
var valid2;
var valid3;
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();
  regex = new RegExp("^.{8,}$");
});

$('#pass').keyup(function(){
  if (event.keyCode != '13'){
    var a = $('#pass').val();
    console.log(a);
    console.log(regex.test(a));
    if(regex.test($('#pass').val())){
      $('#pass').popover('hide');
      valid1 = true;
    }
    else {
      $('#pass').popover('show');
      valid1 = false;
    }
  }
});

$('#passold').keyup(function(){
  if (event.keyCode != '13'){
    var a = $('#passold').val();
    console.log(a);
    console.log(regex.test(a));
    if(regex.test($('#passold').val())){
      $('#passold').popover('hide');
      valid3 = true;
    }
    else {
      $('#passold').popover('show');
      valid3 = false;
    }
  }
});

$('#ver').keyup(function(){
  if (event.keyCode != '13')
  {
    var a = $('#ver').val();
    var b = $('#pass').val();
    if(a!=b){
      $('#ver').popover('show');
      valid2 = false;
    }
    else {
      $('#ver').popover('hide');
      valid2 =true;
    }
  }
});

$("#formreg").submit(function (e) {
  var validationFailed = true;
  console.log(valid1);
   if(valid1 == true && valid2 == true && valid3 == true) validationFailed = false;
   if (validationFailed) {
      e.preventDefault();
      return false;
   }
});
</script>
@stop
