<header class="row">
  <div class='col-*-12 container-header'>
    <div class='col-xs-6 col-sm-4 col-md-2 col-md-push-2 col-lg-2 col-lg-push-2'>
      <a href="/" title="What's Up" class="logo"></a>
    </div>
    <div class='hidden-xs hidden-sm col-md-3 col-md-push-6 col-lg-3 col-lg-push-7'>
      <?php require('social.php'); ?>
    </div>
    <div class='container hidden-xl hidden-lg hidden-md col-sm-2 col-sm-push-5 col-xs-3 col-xs-push-3' style='position: relative;'>
      <nav class='navbar-custom navbar-fixed-top' style='position: absolute;top: 50%;transform: translateY(15%);'>
        <ul class="nav nav-pills navbar-right">
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle glyphicon glyphicon-th-list" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"></a>
            <ul class="dropdown-menu">
              <?php require('social-list.php'); ?>
              <li class="divider"></li>
              <li><a class="dropdown-item" href="/account">Mon Compte</a></li>
              <li class="divider"></li>
              <li><a class="dropdown-item logout" href="#">Deconnexion</a></li>
            </ul>
          </li>
        </ul>
      </nav>
    </div>
</header>