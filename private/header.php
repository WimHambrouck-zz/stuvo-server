<?php
if (isset($page['requireperm'])){
  if ($page['requireperm'] != ""){
    $permission = $permissionManager->getPermissionByName(
       $config['permissionprefix'].'.'.$page['requireperm']);
    if(!$permissionManager->hasPermission($user,$permission)){
      echo "<div class=\"alert alert-danger\">";
      echo "<div class=\"row\">";
      echo "<div class=\"col-md-10\">";
      echo "<h4>You do not have permission to view this page!</h4>";
      echo "</div>";
      echo "</div>";
      echo "<div class=\"row\">";
      echo "<div class=\"col-md-10\">";
      echo "<a href=\"javascript:history.go(-1)\" class=\"btn btn-danger\">Go back</a>";
      echo "</div>";
      echo "</div>";
      echo "</div>";
      die();
    }
  }
}
?>
<header>
  <nav>
    <a href="<?php echo $page['root']; ?>./" id="header-logo" class="navbar-brand"></a>
    <ul class="nav nav-pills">
      <li class="dropdown user<?php if($page['name'] =="administration") echo " active"; ?>">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicons settings"></span>  <span class="mobile-hide">Administratie</span>
          <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li>
              <a href="<?php echo $page['root'];?>admin/users.php"
                <?php 
                if(!$permissionManager->hasPermission($user->getGroup(),
                  $permissionManager->getPermissionByName($config['permissionprefix'].'.users')))
                  echo " style=\"display: none;\"";
                ?>>Beheer gebruikers</a>
            </li>
            <li>
              <a href="<?php echo $page['root'];?>admin/groups.php"
                <?php 
                if(!$permissionManager->hasPermission($user->getGroup(),
                  $permissionManager->getPermissionByName($config['permissionprefix'].'.groups')))
                  echo " style=\"display: none;\"";
                ?>>Beheer groepen</a>
            </li>
            <li>
              <a href="<?php echo $page['root'];?>contacts.php" >Beheer Contacten</a>
            </li>
             <li>
              <a href="<?php echo $page['root'];?>spons.php" >Beheer Sponsors</a>
            </li>
            <li>
              <a href="<?php echo $page['root'];?>resto.php" >Beheer Restaurants</a>
            </li>
            <li>
              <a href="<?php echo $page['root'];?>admin/log.php"
                <?php 
                if(!$permissionManager->hasPermission($user->getGroup(),
                  $permissionManager->getPermissionByName($config['permissionprefix'].'.log')))
                  echo " style=\"display: none;\"";
                ?>>Activiteiten log</a>
            </li>
          </ul>
        </li>
       <li class="dropdown user">
          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><span class="glyphicon glyphicon-user"></span>  <?php echo $user->getUsername(); ?>
          <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li role="presentation" class="dropdown-header">
                <?php echo $user->getFirstName().' '.$user->getLastName(); ?>
            </li>
            <li>
              <a href="<?php echo $page['root'];?>profile.php">Verander profiel</a>
            </li>
            <li class="divider"></li>
            <li>
              <a href="" onclick="logOut();"><span class="glyphicon glyphicon-log-out"></span>  Log uit</a>
            </li>
          </ul>
        </li>
    </ul>
  </nav>
</header>