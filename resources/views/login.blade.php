<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <!-- Bootstrap 3.3.5 -->
  <link rel="stylesheet" href="{{url('')}}/plugin/bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{url('')}}/css/font.css">

  <!-- Theme style -->
  <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->

  <meta charset="utf-8">
  <title>Gass Management Login</title>
</head>
<body>
<style >
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

<div class="ss" style="padding-top:7em;">

  <div class="col-md-12">
    <div class="row">
      <div class="col-md-4">
      </div>
      <div class="col-md-4 text-center" style="color:white;">
        @if (session('success'))
          <div class="alert alert-success">
              {{ session('success') }}
          </div>
        @endif
        @if (session('failed'))
          <div class="alert alert-danger">
              {{ session('failed') }}
          </div>
        @endif
        <h2 class="jud"style="margin-bottom:10px">GASS Order Management</h2>
      </div>
    </div>
    <div class="row" id="login">
      <div class="col-md-4">
      </div>
      <div class="col-md-4">

        <div style="background-color:white;">
          <div class="text-center" style="padding:20px">
            <h3 class="jud"style="margin:20px 0px;color:#32c5d2">Sign In</h3>
            <form action="{{url('/')}}/login" method="post" style="margin-top:10px">
              <div class="form-group">
                <input type="text"  class="form-control"name="id" value="" style="background-color:#dde3ec;padding:20px;" placeholder="Username">
              </div>
              <div class="form-group">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="password"  class="form-control"name="password" value="" style="background-color:#dde3ec;padding:20px;"placeholder="Password">
              </div>
              <div style="margin:20px 0px 30px 0px;padding:20px 0px">
                <button type="submit" class="blove col-md-3 btn" >
                  LOGIN
                </button>

                <div class="col-md-4" style="padding-top:15px;">
                  <input type="checkbox" name="remember" value="" style=""> <p style="color:grey;display:inline;">Remember</p>
                </div>
                <div class="col-md-5" style="padding-top:15px;">
                  <a href="#">Forgot Password?</a>
                </div>

              </div>
            </form>

          </div>
          <div class="text-center"style="color:white;background-color: #6c7a8d;padding:20px;">
            <div id="showform"role="button"style="text-decoration:none; color:white;">Sign Up</div>
          </div>
        </div>
      </div>

    </div>
    <div id="register">
      <div class="col-md-2">
      </div>
      <div class="col-md-8" style="background-color:white; padding 20px;">
        <div style="background-color:white;">
          <div class="text-center">
            <h3 class="jud"style="margin:20px 0px;color:#32c5d2">Register new account</h3>
            <form id="formreg" action="{{url('/')}}/register" method="post" style="margin-top:10px">
              <div class="row">
                <div class="col-md-6 col-xs-12">
                  <div class="form-group">
                    <label >ID Number</label>
                    <input type="text"  class="form-control"name="id" value="" style="background-color:#dde3ec;padding:20px;" placeholder="ID Number" required>
                  </div>
                  <div class="form-group">
                    <label >Name</label>
                    <input type="text"  class="form-control"name="name" value="" style="background-color:#dde3ec;padding:20px;" placeholder="Name" required>
                  </div>
                  <div class="form-group">
                    <label >Unit</label>
                    <select name="unit" class="form-control inputs"  style="padding:0px;" required>
                      <option value=""></option>
                      <option value="GASS">GASS</option>
                    </select>
                  </div>
                  <div  class="form-group">
                    <label >Sub Unit</label>
                    <select  name="subunit"class="form-control inputs" style="padding:0px;" required>
                      <option value=""></option>
                      <option value="PG">PG</option>
                    </select>
                  </div>
                  <div class="form-group">
                    <label >Telephone Number</label>
                    <input type="text"  class="form-control" name="number" value="" style="background-color:#dde3ec;padding:20px;" placeholder="Telephone Number" required>
                  </div>
                </div>
                <div class="col-md-6 col-xs-12">

                  <div class="form-group">
                    <label >Email</label>
                    <input type="email"  class="form-control" name="email" value="" style="background-color:#dde3ec;padding:20px;" placeholder="Email" required>
                  </div>

                  <div class="form-group">
                    <label >Jabatan</label>
                    <select name="position" class="form-control inputs" style="padding:0px;" required>
                      <option value=""></option>
                      <option value="staff">Staff</option>

                    </select>
                  </div>
                  <div class="form-group">
                    <label >Password</label>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input data-toggle="popover" title="Warning!" data-placement="bottom" data-content="Password must be at least 8 characters" type="password" id="pass" class="form-control" name="password" value="" style="background-color:#dde3ec;padding:20px;" placeholder="Password" required>


                  </div>

                  <div class="form-group">
                    <label >Verify Password</label>
                    <input id="ver"data-toggle="popover" title="Warning!" data-placement="bottom" data-content="Password doesn't match" type="password"  class="form-control" name="passwordv" value="" style="background-color:#dde3ec;padding:20px;" placeholder="Verify Password" required>
                  </div>
                  <div class="form-group ">
                    <button type="submit" class="blove col-md-3 btn" >
                      Submit
                    </button>
                    <div role="button"id="back" class="blove col-md-3 btn" style="margin-left:10px; background-color:#008CBA;" >
                      << Back
                    </div>
                  </div>
                </div>
                </div>
              </div>





          </form>

        </div>

      </div>
    </div>

  </div>
  <div class="row col-md-12 text-center" style="color:grey;margin-top:10px">
    <p>2017 © Shafly Naufal Adianto Hariyoso Ario Bimo</p>
  </div>

</div>

</div>
</body>
<script src="{{url('')}}/plugin/jQuery/jQuery-2.1.4.min.js"></script>

<script src="{{url('')}}/plugin/bootstrap/js/bootstrap.min.js"></script>

<script type="text/javascript">
  var regex;
  var valid1;
  var valid2;
$(document).ready(function(){
  $('#register').hide();
  $('[data-toggle="popover"]').popover();
  regex = new RegExp("^.{8,}$");
});

$('#showform').click(function(){
  $('#login').hide(500);
  $('#register').show(500);
  $(".ss").css("height", "110vh");
});
$('#back').click(function(){
  window.scrollTo(0, 0);

  $(".ss").css("height", "100vh");

  $('#register').hide(500);
  $('#login').show(500);

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
   if(valid1 == true && valid2 == true) validationFailed = false;
   if (validationFailed) {
      e.preventDefault();
      return false;
   }
});


</script>


</html>
