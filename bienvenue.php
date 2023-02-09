

<?php
session_start ();

?>
<?php if (isset($_SESSION["authentified"]) && $_SESSION["authentified"] === true): ?>
    <body style="background: antiquewhite">
    <div style="color: olivedrab" ><?php echo 'Bienvenue !'; ?></div>
    </body>


    <form action="logout.php" method="post">
        <button type="submit" name="button">Se déconnecter</button>
        </div>
    </form>


    </body>
    </html>
<?php else: ?>
    <p>Vous n'êtes pas login</p>
<?php endif; ?>



