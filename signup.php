<?php include("./header.inc.php") ?>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include("./connect.inc.php");
    $user_email = $_POST["email"];
    $user_password = $_POST["password"];
    $file = $_FILES["image"];
    echo $file["tmp_name"];
    $type = $_POST["type"];

    $sql = "select * from users where email = '$user_email'";
    $result = mysqli_query($con, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 0) {
        $file_name = $file["name"];
        $arr = ['jpg', 'jpeg', 'png'];
        $file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (in_array($file_ext, $arr)) {
            //now we have valid user to register
            $upload_dir = "image/" . basename($file_name);

            if (move_uploaded_file($file["tmp_name"], $upload_dir)) {
                $sql = "insert into users (email,password,image,is_voted,type) values ('$user_email','$user_password','$upload_dir',0,'$type')";

                $result = mysqli_query($con, $sql);
                if ($result) {
                    echo "user created succesful";
                    header("location:login.php");
                } else {
                    echo "unable to register user";
                }
            } else {
                echo "unable to upload file";
            }
        } else {
            echo "file ext not supported";
        }
    } else {
        echo "email already registered";
    }
}


?>




<form class="container" action="./signup.php" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="email">Email address:</label>
        <input name="email" type="email" class="form-control" id="email">
    </div>
    <div class="form-group">
        <label for="pwd">Password:</label>
        <input name="password" type="password" class="form-control" id="pwd">
    </div>
    <label for="type">Select Type</label>
    <select id="type" name="type" class="form-select" aria-label="Default select example">
        <option selected>Choose</option>
        <option value="voter">Voter</option>
        <option value="party">Party</option>
    </select>
    <div class="mb-3">
        <label for="formFile" class="form-label">Default file input example</label>
        <input name="image" class="form-control" type="file" id="formFile">
    </div>
    <button type="submit" class="btn btn-default">Submit</button>
</form>








<?php include("./footer.inc.php") ?>