<?php
    require_once "Database.php";
    //CRUD Application C - reate, R - ead, U-pdate, D-elete
    class User extends Database{

         public function store($request){
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
            $password = $request['password'];

            # Apply hashing to the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            
            # Query string
            $sql = "INSERT INTO users(first_name, last_name, username, user_password) VALUES('$first_name', '$last_name', '$username', '$hashed_password')";

            if ($this->conn->query($sql)) {
                header("location: ../views"); //index.php
                exit;
            }else {
                die("Error in creating user:" . $this->conn->error);
            }
         }

         public function login($request){
            # received the username and password from the login form (index.php)
            $username = $request['username'];
            $password = $request['password'];

            # Check if username is available in the database
            $sql = "SELECT * FROM users WHERE username='$username'";

            #execute the query string and put the result in $result
            $result = $this->conn->query($sql);

            # check num_rows if equal to 1
            if ($result->num_rows == 1) { // if true, then the USERNAME is available in the database
                # Check for the password provided by the user if matched with
                # the password already in the database
                $user = $result->fetch_assoc();
                # $user = ['id' => 1, 'first_name' => 'John', 'last_name'=>'doe', 'username'=> 'john.doe', 'password' => 'john123456']

                if (password_verify($password, $user['user_password'])) { //if matched, it will return, else false
                    # create session variables
                    session_start();
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['username'] = $user['username'];
                    $_SESSION['fullname'] = $user['first_name'] . " " .$user['last_name'];

                    header('location: ../views/dashboard.php');
                    exit;
                }else {
                    die("Password is incorrect or do not matched.");
                }
            }else {
                die("Username not found.");
            }
         }

         public function logout(){
             session_start();
             session_unset();
             session_destroy();

             header('location: ../views/'); // index.php
             exit;
         }

         public function getAllUsers(){
             # Query string
             $sql = "SELECT id, first_name, last_name, username, photo FROM users";

             if ($result = $this->conn->query($sql)) {
                 return $result;
             }else {
                 die("Error in retrieving users: " . $this->conn->error);
             }
         }

         public function getUser(){
            // session_start();
            $id = $_SESSION['id'];

            #query string
            $sql = "SELECT first_name, last_name, username, photo FROM users WHERE id='$id'";

            if ($result = $this->conn->query($sql)) {
                return $result->fetch_assoc();
            }else {
                die("Error in retrieving user: " . $this->conn->error);
            }
         }

         public function update($request, $files){
            session_start();

            $id = $_SESSION['id'];
            $first_name = $request['first_name'];
            $last_name = $request['last_name'];
            $username = $request['username'];
            $photo = $files['photo']['name'];
            $tmp_photo = $files['photo']['tmp_name'];

            # Query string
            $sql = "UPDATE users SET first_name = '$first_name', last_name = '$last_name', username = '$username' WHERE id = '$id'";

            # Execute the query
            if ($this->conn->query($sql)) {
                $_SESSION['username'] = $username;
                $_SESSION['fullname'] = "$first_name $last_name";

                # Check if the user uploaded an image/photo,
                # If there is an uploaded photo, save it into the images folder
                if ($photo) { //true if there is photo, false if otherwise
                    # Query the user table to update the photo field
                    $sql = "UPDATE users SET photo = '$photo' WHERE id = '$id'";
                    $destination = "../assets/images/$photo";


                    # Save the image to the destination folder
                    if ($this->conn->query($sql)) {
                        if (move_uploaded_file($tmp_photo, $destination)) {
                            header('location: ../views/dashboard.php');
                            exit;
                        }else {
                            die("Error in moving the photo.");
                        }
                    }else {
                        die("Error in uploading the photo. " . $this->conn->error);
                    }
                }

                header('location: ../views/dashboard.php');
                exit;
            }else {
                die("Error in updating the user " . $this->conn->error);
            }

         }


         public function delete(){
             session_start();
             $id = $_SESSION['id'];

             $sql = "DELETE FROM users WHERE id='$id'";

             if ($this->conn->query($sql)) {
                 $this->logout();
             }else {
                 die("Erorr in deleting the account. " . $this->conn->error);
             }
         }
    }
?>