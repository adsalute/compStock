<?php
$pass = "test";
$newHash = password_hash($pass, PASSWORD_DEFAULT);
echo $newHash;