<?php
//Check if credentials are valid

require "Classe/DbPDO.php";
DbPDO::connect();

DbPDO::checkLogin();

