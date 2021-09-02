<?php 
    if(isset($_POST['signup']))
    {
        include "config.php";
        $fname = mysqli_real_escape_string($conn,$_POST['fname']);
        $lname = mysqli_real_escape_string($conn,$_POST['lname']);
        $username = mysqli_real_escape_string($conn,$_POST['user']);
        $password = mysqli_real_escape_string($conn,md5($_POST['password']));
        $role = mysqli_real_escape_string($conn,$_POST['role']);

        //if username already exist 
        $sql = "SELECT username FROM  user WHERE username = '{$username}'";
        $result = mysqli_query($conn,$sql) or die("couldnt run query");

        if(mysqli_num_rows($result) > 0)
        {
            echo "<p style = 'color:red;font-size:150%;'> This  username already exist </p>";
        }
        else 
        {
            $sql1 = "INSERT INTO user(first_name,last_name,username,password,role) VALUE('{$fname}','{$lname}','{$username}','{$password}','{$role}')";
           
            if(mysqli_query($conn,$sql1))
            {
                echo "<div class='bg-success text-center' style='font-size:20px;'>You've successully signed up!</div>";
                mysqli_close($conn);
            }
        }
    }

?>

<!doctype html>
<html>
   <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>ADMIN | signup</title>
        <link rel="stylesheet" href="../css/bootstrap.min.css" />
        <link rel="stylesheet" href="font/font-awesome-4.7.0/css/font-awesome.css">
        <link rel="stylesheet" href="../css/style.css">
    </head>

    <body>
    <div id="admin-content">
      <div class="container">
          <div class="row">
          <div class="row">
                            <div class="col">
                                <a href="../" class="" style="font-size:30px;background:lightblue;border-bottom:2px solid red;"> >>News-Blog</a>
                                <a href="index.php" class="" style="font-size:30px;background:lightblue;border:2px solid skyblue;float:right;"> Log-in<<</a>
                            </div>
                        </div>
              <div class="col-md-4 col-md-offset-4" style="margin-bottom:100px;">
                        <img class="logo" src="images/news.jpg">
              </div>
              <div class="col-md-offset-3 col-md-6">
                  <!-- Form Start -->
                  <form  action="<?php $_SERVER['PHP_SELF']; ?>" method ="POST" autocomplete="off">
                      <div class="form-group">
                          <label>First Name</label>
                          <input type="text" name="fname" class="form-control" placeholder="First Name" required>
                      </div>
                          <div class="form-group">
                          <label>Last Name</label>
                          <input type="text" name="lname" class="form-control" placeholder="Last Name" required>
                      </div>
                      <div class="form-group">
                          <label>User Name</label>
                          <input type="text" name="user" class="form-control" placeholder="Username" required>
                      </div>

                      <div class="form-group">
                          <label>Password</label>
                          <input type="password" name="password" class="form-control" placeholder="Password" required>
                      </div>
                      <div class="form-group">
                                <label>Gender</label>
                                <input class="form-check-input" style="margin-left:5px;margin-right:5px;" style="cursor:pointer" id="a" type="radio" name="gender" class="form-control" placeholder="" ><lable for="a" style="cursor:pointer">Male</lable>                               
                                <input class="form-check-input" style="margin-left:5px;margin-right:5px;" style="cursor:pointer" id="b" type="radio" name="gender" class="form-control" placeholder="" ><lable for="b" style="cursor:pointer">Female</lable>
                    </div>
                    <div class="form-group">
                          <label>User Role</label>
                          <select class="form-control" name="role" >
                              <option value="0">Normal User</option>
                              <option value="1" disabled>Admin</option>
                          </select>
                      </div>
                            <input type="submit" name="signup" class="btn btn-primary"  value="signup" />
                       
                
                  </form>
                   <!-- Form End-->
               </div>
           </div>
       </div>
   </div>
    </body>
</html>



















