<?php if (isset($_GET["logout"]) && $_GET["logout"] === 1): ?>

    <div style="position: absolute; left: 0; top: 0; color:white; background: red">
        <p>Vous vous êtes déconnecter</p>
    </div>
<?php else: ?>
<?php endif; ?>


<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/basics.css" media="screen" title="no title" charset="utf-8">
  </head>
  <body>

    <form action="check_login.php" method="post">
      <div>
        <label for="username">Identifiant</label>
        <input type="text" name="username" required>
      </div>
      <div>
        <label for="password">Mot de passe </label>
        <input type="password" name="password" required>
      </div>
      <div>
          <input type="submit">
      </div>
    </form>
  </body>
</html>
