<?php
session_start();
include('config/config.php');
//login 
if (isset($_POST['login'])) {
  $admin_email = $_POST['admin_email'];
  $admin_password = sha1(md5($_POST['admin_password'])); //double encrypt to increase security
  $stmt = $mysqli->prepare("SELECT admin_email, admin_password, admin_id  FROM   rpos_admin WHERE (admin_email =? AND admin_password =?)"); //sql to log in user
  $stmt->bind_param('ss',  $admin_email, $admin_password); //bind fetched parameters
  $stmt->execute(); //execute bind 
  $stmt->bind_result($admin_email, $admin_password, $admin_id); //bind result
  $rs = $stmt->fetch();
  $_SESSION['admin_id'] = $admin_id;
  if ($rs) {
    //if its sucessfull
	
    header("location:dashboard.php");
  } else {
    $err = "Incorrect Authentication Credentials ";
  }
}
require_once('partials/_head.php');
?>

<style>
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  background-image: url('./assets/img/brand/plm_bg.jpg');
  background-repeat: no-repeat;
  background-size: cover;
  background-attachment: fixed;
  background-position: center center;
  height: 100vh;
  width: 100vw;
  overflow: hidden;
  position: relative;
  z-index: -1;
  color: white;
}

.blur {
  position: absolute;
  left: 0;
  top: 0;
  z-index: 1;
  background-color: rgba(31, 37, 69, .6);
  width: 100%;
  height: 100%;
  backdrop-filter: blur(8px);
}

.hero {
  position: relative;
  z-index: 10;
  display: flex;
  flex-direction: column;
}

.container {
  width: 96%;
  max-width: 1600px;
  margin: 0 auto;
  height: 100vh;
}

.header {
  margin-top: 1.5rem;
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.logo-container {
  width: 8rem;
}

.logo {
  width: 100%;
}

.form-container {
  flex: 1;
  display: flex;
  align-items: center;
  justify-content: center;

}

.form-inner-container {
  width: 26rem;
  max-width: 70%;
  background: rgba(209, 215, 248, .5);
  backdrop-filter: blur(15px);
  padding: 2.6rem;
  display: flex;
  flex-direction: column;
  align-items: center;
  border-radius: 20px;
  box-shadow: rgba(0, 0, 0, 0.35) 0px 5px 15px;
}

.btn-container {
  width: 225px;
  display: flex;
  justify-content: space-between;
  border-radius: 30px;
  background: #D9D9D9;
}

.toggle-btn,
.submit-btn {
  padding: 10px 25px;
  cursor: pointer;
  border-radius: 30px;
  outline: none;
  position: relative;
  font-weight: 600;
  font-size: 1rem;
  outline: none;
  border: none;
}

.btn__admin,
.submit-btn {
  background: linear-gradient(to right, #4855A1, #95A2EE);
  color: #fff;
  width: 50%;

}

.btn__staff {
  background: transparent;
  color: #343D73;
  width: 50%;

}

.input-groupp {
  width: 100%;
  margin-top: 1.8rem;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.input {
  display: block;
  width: 100%;
  padding: .6rem 1rem;
  background: #D1D7F8;
  border-radius: 8px;
  color: #29315C;
  font-size: .8rem;
  border: none;
  outline: none;
}

.input~.input {
  margin-top: 1rem;
}

.submit-btn-container {
  display: grid;
  padding-left: center;
  width: 70%;
  margin-top: 1.8rem;
}

.submit-btn {
  width: 100%;
}
</style>

<body>

  <!-- Page content -->

  <div class="blur"></div>
  <div class="hero container">

    <!-- HEADER -->
    <div class="header">
      <div class="logo-container">
        <img class="logo" src="./assets/img/brand/plm-merch-logo-light2.png" alt="plm merch logo">
      </div>
      <div class="day">
        <span>Today is </span>
        <span class="currentDay"></span>
      </div>
    </div>

    <!--FORM -->
    <div class="form-container">

      <!--BUTTON TOP-->
      <div class="form-inner-container">

        <form method="post" id="admin" class="input-groupp" role="form">
          <input type="email" id="input-field" class="input input__email" required name="admin_email"
            placeholder="Email">
          <input type="password" id="input-field" class="input input__password" required name="admin_password"
            placeholder="Password">

          <div class="submit-btn-container">
            <button type="submit" name="login" class="submit-btn">Log In</button>
          </div>
        </form>

        <div class="row mt-3">
          <!-- <a href="forgot_pwd.php" class="text-light"><small>Forgot password?</small></a> -->
        </div>
      </div>
    </div>
  </div>

  </div>
  </div>

  <!-- Argon Scripts -->

  <script>
  const currentDateEl = document.querySelector('.currentDay');
  const today = new Date();
  const locale = navigator.language;
  const options = {
    day: 'numeric',
    month: 'long',
    year: 'numeric'
  }
  currentDateEl.textContent = new Intl.DateTimeFormat(locale, options).format(today);
  </script>
  <?php
  require_once('pos/admin/partials/_scripts.php');
  ?>
</body>

</html>