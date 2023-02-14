<?php
    session_start();

    require '../classess/User.php';

    # Instantiate object
    $user_obj = new User;

    # Call the method
    $user = $user_obj->getUser();
    //$user = ['id'=> '1', 'first_name'=> 'john', 'last_name'=> 'doe', 'username' => 'john.doe', 'photo'=>'null'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap Link -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">

    <!-- Fontawesome Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Edit User</title>
</head>
<body>
    
    <nav class="navbar navbar-expand navbar-dark bg-dark" style="margin-bottom: 80px;">
        <div class="container">
            <a href="dashboard.php" class="navbar-brand">
                <h1 class="h3">The Company</h1>
            </a>
            <div class="navbar-nav">
                <span class="navbar-text"><?= $_SESSION['fullname'] ?></span>
                <form action="../actions/logout.php" method="post" class="d-flex ms-2">
                    <button type="submit" class="text-danger bg-transparent border-0">Logout</button>
                </form>
            </div>
        </div>
    </nav>

    <main class="row justify-content-center gx-0">
        <div class="col-6">
            <h1 class="h3 text-center mb-3">Edit User</h1>

            <form action="../actions/edit-user-action.php" method="post" enctype="multipart/form-data">
                <div class="row justify-content-center mb-3">
                    <div class="col-6">
                        <?php
                            if ($user['photo']) {
                        ?>
                            <img src="../assets/images/<?=$user['photo']?>" alt="<?=$user['photo']?>" class="d-block mx-auto edit-photo">

                        <?php
                            }else {
                        ?>
                            <i class="fa-solid fa-user text-secondary d-clock  text-center edit-icon"></i>
                            
                        <?php
                            }
                        ?>

                        <input type="file" name="photo" class="form-control mt-2" accept="image/*">

                        <div class="mb-3">
                            <label for="first-name" class="form-label">First Name</label>
                            <input type="text" name="first_name" id="first-name" class="form-control" value="<?= $user['first_name'] ?>" required autofocus>
                        </div>
                        <div class="mb-3">
                            <label for="last-name" class="form-label">Last Name</label>
                            <input type="text" name="last_name" id="last-name" class="form-control" value="<?= $user['last_name']?>" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" name="username" id="username" class="form-control fw-bold" maxlength="15" value="<?= $user['username'] ?>" required>
                        </div>

                        <div class="text-end">
                            <a href="dashboard.php" class="btn btn-secondary btn-sm">Cancel</a>
                            <button type="submit" class="btn btn-warning btn-sm px-5">Save</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</body>
</html>