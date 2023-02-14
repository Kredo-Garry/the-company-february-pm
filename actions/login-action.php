<?php
    include '../classess/User.php';

    # Instantiate an object
    $user = new User;

    # Call the method
    $user->login($_POST);
?>