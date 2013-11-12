<?php

$mysqli = mysqli_connect('localhost', 'firefox', '123456','firefox');
if ($mysqli->connect_errno) {
    echo "Fallo al contenctar a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}