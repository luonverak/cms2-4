<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js" integrity="sha512-AA1Bzp5Q0K1KanKKmvN/4d3IRKVlv9PYgwFPvm32nPO6QS8yH1HO7LbgB1pgiOxPtfeg5zEn2ba64MUcqJx6CA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<?php
    $connection = new mysqli('localhost','root','','web_cms_5');
    function moveImage($thumbnail){
        $image = date('dmyhis').'-'.$_FILES[$thumbnail]['name'];
        $path = './assets/image/'.$image;
        move_uploaded_file($_FILES[$thumbnail]['tmp_name'],$path);
        return $image;
    }
    function register(){
        global $connection;
        if(isset($_POST['btn_register'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $password = md5($_POST['password']);
            $profile = moveImage('profile');
            // check username
            $username_sql = "SELECT * FROM `user` ";
            $username_rs = $connection->query($username_sql);
            while($row=mysqli_fetch_assoc($username_rs)){
                if($username==$row['user_name'])
                    $username=null;
                else
                    $username;
            }
            // validation username
            if(preg_match('/^[a-zA-Z][0-9a-zA-Z_]{2,23}[0-9a-zA-Z]$/',$username)){
                $username;
            }
            else{
                $username=null;
            }
            // validation password
            if (!preg_match_all('$\S*(?=\S{8,})(?=\S*[a-z])(?=\S*[A-Z])(?=\S*[\d])(?=\S*[\W])\S*$', $password))
            {
                $password=null;
            }else{
                $password;
            }
            if(!empty($username) && !empty($email) && !empty($password) && !empty($profile)){
                $sql = "INSERT INTO `user`(`user_name`, `email`, `password`, `profile`)
                        VALUES ('$username','$email','$password','$profile')";
                $rs = $connection->query($sql);
            }else{
                echo 'error';
            }
        }
    }
    register();
    session_start();
    function login(){
        global $connection;
        if(isset($_POST['btn_login'])){
            $name_email= $_POST['name_email'];
            $password = md5($_POST['password']);
            $sql = "SELECT user_id FROM `user` WHERE (`user_name`='$name_email' OR `email`='$name_email') AND `password`='$password'";
            $rs = $connection->query($sql);
            $row = mysqli_fetch_assoc($rs);
            if($row){
                $_SESSION['user'] = $row['user_id'];
                echo '
                <script>
                    $(document).ready(function(){
                        swal("Good job!", "You clicked the button!", "success").then((result) => {
                            if(result){
                                window.location.href="index.php";
                            }
                        }).catch((err) => {

                        });
                    })
                </script>
                ';
            }
        }
    }
    login();
    function logout(){
        if(isset($_POST['btnlogout'])){
            unset($_SESSION['user']);
            header('location: login.php');
        }
    }
    logout();
    function logoAddPost(){
        global $connection;
        if(isset($_POST['btnAddLogo'])){
            $status = $_POST['status'];
            $thumbnail =moveImage('thumbnail');
            if(!empty($status) && !empty($thumbnail)){
                $sql = "INSERT INTO `logo`(`thumbnail`, `status`) VALUES ('$thumbnail','$status')";
                $rs = $connection->query($sql);
                if($rs){
                    echo '';
                }
            }
       }
    }
    logoAddPost();
    function getLogo(){
        global $connection;
        $sql = "SELECT * FROM `logo` ORDER BY logo_id DESC LIMIT 2";
        $rs = $connection->query($sql);
        while($row = mysqli_fetch_assoc($rs)){
            echo
            '
            <tr>
                <td>'.$row['logo_id'].'</td>
                <td>'.$row['status'].'</td>
                <td><img width="130" src="assets/image/'.$row['thumbnail'].' "/></td>

                <td width="150px">
                    <a href="logo-update-post.php?id='.$row['logo_id'].'"class="btn btn-primary">Update</a>
                    <button type="button" remove-id="'.$row['logo_id'].'" class="btn btn-danger btn-remove" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        Remove
                    </button>
                </td>
            </tr>
            ';
        }
    }
    function logoEditPost(){
        global $connection;
        if(isset($_POST['btnEditLogo'])){
            $status = $_POST['status'];
            $thumbnail =$_FILES['thumbnail']['name'];
            $id = $_POST['logo_id'];
            if(empty($thumbnail)){
                $thumbnail=$_POST['old_thumbnail'];
            }else{
                $thumbnail=moveImage('thumbnail');
            }
            if(!empty($status) && !empty($thumbnail)){
                $sql = "UPDATE `logo` SET `thumbnail`='$thumbnail',`status`='$status' WHERE `logo_id`='$id'";
                $rs = $connection->query($sql);
                if($rs){
                    echo '';
                }
            }
        }
    }
    logoEditPost();
    function logoDelete(){
        global $connection;
        if(isset($_POST['acceptDeleteLogo'])){
            $id = $_POST['remove_id'];
            $sql = "DELETE FROM `logo` WHERE logo_id='$id'";
            $connection->query($sql);
        }
    }
    logoDelete();
?>