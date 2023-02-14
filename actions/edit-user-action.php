<?php
    include '../classess/User.php';

    # Instantiate object
    $user = new User;

    # Call the method
    $user->update($_POST, $_FILES);
?>