<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <title><?php echo $title; ?></title>
    <link rel="stylesheet" type="text/css" href="style.css" />
    <script src="javascript.js"></script>
</head>
<body>
<?php
  include_once "functions.php";
?>

<table>
      <tr>
        <td id="logodata">
          <a href="index.php"><img class="logo" src="./images/logo.png" alt="logodata" /></a>
        </td>
        <td id="menudata">
          <div class="nav-area">
            <ul>
              <li class="active"><a href="index.php">HOME</a></li>
              <!--sub menu Services-->
              <li>
                <a href="online-appointment.php">SERVICES</a>
                <div class="sub-nav-area">
                  <ul>
                    <li>
                      <a href="online-appointment.php">online-appointment</a>
                    </li>
                    <li>
                      <a href="virtual_consultation.php"
                        >virtual consultation</a
                      >
                    </li>
                  </ul>
                </div>
              </li>
              <!--sub-menu under NEWS-->
              <li>
                <a href="#">NEWS</a>
                <div class="sub-nav-area">
                  <ul>
                    <li><a href="HealthNews.php">Health news</a></li>
                    <li><a href="Blog.php">Blog</a></li>
                  </ul>
                </div>
              </li>
              <!--sub-menu under ACCOUNT-->
              <li>
                <a href="#">ACCOUNT</a>
                <div class="sub-nav-area">
                  <ul>
                    <?php
                      if(isLoggedIn()) {
                        echo '<li><a href="logout.php">Log out</a></li>';
                      } else {
                        echo '<li><a href="login.php">Log in</a></li>';
                        echo '<li><a href="register.php">Register</a></li>';
                      }
                    ?>
                    <li><a href="admin.php">Admin</a></li>
                    <li id="logout"><a href="logout.php">Logout</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          </div>
        </td>
      </tr>
    </table>
</body>
</html>
