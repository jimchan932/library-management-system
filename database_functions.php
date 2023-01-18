<?php

function normal_user_database_connect() {
   $result = new mysqli('localhost', 'normaluser', 'normaluser', 'library');
   if (!$result) {
     throw new Exception('Could not connect to database server');
   } else {
     return $result;
   }
}

?>