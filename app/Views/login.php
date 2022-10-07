<html>
  <head>
    <title>.::SIPD Importer Tools::.</title>
    <?php
      echo "<link rel='stylesheet' href='".base_url("public/assets/css/bootstrap.min.css?t=".time())."'>";
      session()->set('tahun','2021');
    ?>
    <style>
    body {
      margin: 0;
      padding: 0;
      background-color: #333333;
      height: 100vh;
      background-image: url('../public/background.jpg');
    }
    #login .container #login-row #login-column #login-box {
      margin-top: 60px;
      max-width: 600px;
      border: 1px solid #9C9C9C;
      background-color: #EAEAEA;
    }
    #login .container #login-row #login-column #login-box #login-form {
      padding: 20px;
    }
    #login .container #login-row #login-column #login-box #login-form #register-link {
      margin-top: -85px;
    }
    #login-box{
      margin: auto;
      padding-top: 30px;
      padding-bottom: 30px;
    }
    #logo-login{
      margin:auto;
      width: 80px;
      background-image: url("../public/logo-batu.png");
      height:10px;
      background-size: cover;
      margin-top:20px;
      margin-bottom: 20px;
    }
    hr{
      border-bottom:1px solid #FFF;
    }
    </style>
  </head>
  <body>
  <?php
    if(session()->getFlashdata('message')){ ?>
      <div class="alert alert-danger" style="text-align:center">
        <?php echo session()->getFlashdata('message') ?>
      </div>
  <?php } ?>
  <div id="login">
    <div class="container">
      <div id="login-row" class="row justify-content-center align-items-center">
        <div id="login-column" class="col-md-8"></div>
        <div id="login-column" class="col-md-4">
          <div id="login-box" class="">
            <div id='logo-login'></div>
            <hr>
            <h3 class="text-center text-white pt-5">SIPKD Next Generation</h3>
            <form id="login-form" class="form" action="<?=base_url('login/verify')?>" method="post">
              <div class="form-group">
                <label for="username" class="text-info">Username</label><br>
                <input type="text" name="username" id="username" class="form-control" placeholder="Username">
              </div>
              <div class="form-group">
                <label for="password" class="text-info">Password</label><br>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
              </div>
              <div class="form-group">
                <label for="tahun" class="text-info">Tahun Anggaran</label><br>
                <select class="form-control" id="tahun" name="tahun" required>
                  <option value="2021">2021</option>
                  <option value="2022">2022</option>
                </select>
              </div>
              <div class="form-group">
              <label for="modul" class="text-info">Modul</label><br>
                <select class="form-control" id="modul" name="modul" required>
                  <option value="anggaran">Anggaran</option>
                  <option value="tu">Penatausahaan</option>
                  <option value="accounting">Akuntansi</option>
                  <option value="master">Master Data</option>
                  <option value="setting">Setting</option>
                </select>
              </div>

              <div class="form-group">
                <label for="remember-me" class="text-info"><span>Remember me</span> <span><input id="remember-me" name="remember-me" type="checkbox"></span></label><br>
                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
              </div>
            </form>
            <div style="float:none;height:1px"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
  </body>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://nusantaraprov.sipd.kemendagri.go.id/assets/js/crypto_base64.js"></script>
  <script>
    $(document).ready(function(){
      $('#login-form').submit(function(e){
        //e.preventDefault();
      });
    });
  </script>
</html>