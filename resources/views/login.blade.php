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
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{url('')}}/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="{{url('')}}/dist/css/skins/_all-skins.min.css">


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
      </style>
      <div class="ss">
        <div class="col-md-12">
          <div class="row">
            <div class="col-md-4">

            </div>
            <div class="col-md-4 text-center" style="color:white;">
              <h2 style="margin-bottom:0px">GASS Order Management</h2>
            </div>
          </div>
          <div class="row">
            <div class="col-md-4">
            </div>
            <div class="col-md-4">
              <div style="margin-top:5em;background-color:white;">
                <div class="text-center" style="padding:20px">
                  <h3 style="margin:20px 0px;color:#32c5d2">Sign In</h3>
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
                  Back to Homepage
                </div>
              </div>
            </div>

          </div>
          <div class="row text-center" style="color:grey;margin-top:10px">
            <p>2017 © Shafly Naufal Adianto Hariyoso Ario Bimo</p>
          </div>

        </div>

      </div>
  </body>

  <script src="{{url('')}}/plugin/bootstrap/js/bootstrap.min.js"></script>


</html>
