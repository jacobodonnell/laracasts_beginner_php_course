<?php

$_SESSION['name'] = 'Jacob';

view("index.view.php", [
    'heading' => 'Home',
]);