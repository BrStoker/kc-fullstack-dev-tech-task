<?php

require 'api/src/Core/Database.php';
$database = new \Core\Database();
$database->migrate('/var/www/html/database/migrations');