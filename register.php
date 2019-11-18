<!DOCTYPE HTML>  
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="css/edit.css" rel="stylesheet" type="text/css">
    </head>

    <body>
    
    
        
    <?php
        // define variables and set to empty values
        $nameErr = $emailErr = $genderErr = $npErr = $passwordErr = "";
        $name = $email = $gender = $np = $password = "";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (empty($_POST["name"])) {
            $nameErr = "Name is required";
        }   
        else {
            $name = test_input($_POST["name"]);
        }
        
        if (empty($_POST["email"])) {
            $emailErr = "Email is required";
        } 
        else {
            $email = test_input($_POST["email"]);
        }
    
        if (empty($_POST["np"])) {
            $npErr = "Number Phone is required";
        } 
        else {
            $np = test_input($_POST["np"]);
        }
    
        if (empty($_POST["password"])) {
            $passwordErr = "password is required";
        } 
        else {
            $password = test_input($_POST["password"]);
        }

        if (empty($_POST["gender"])) {
            $genderErr = "Gender is required";
        } 
        else {
            $gender = test_input($_POST["gender"]);
        }
    }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

        <h2 style="color:goldenrod">Registration member ShoLine(Shorum Online)</h2>
        <p><span class="error">* required field</span></p>

    <div class="center">
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"> 
    
            <p style="color: white">Name:</p>
                <input type="text" name="name" required>
                <span class="error">* <?php echo $nameErr;?></span>
                <br><br>
            <p style="color: white">E-mail:</p> 
                <input type="text" name="email" required>
                <span class="error">* <?php echo $emailErr;?></span>
                <br><br>
            <p style="color: white">NP:</p>
                <input type="text" name="np" required>
                <span class="error">*<?php echo $npErr;?></span>
                <br><br>
            <p style="color: white">Password:</p>
                <input type="text" name="password" required>
                <span class="error">*<?php echo $passwordErr;?></span>
                <br><br>
            <p style="color: white">Gender:</p>
                <input type="radio" name="gender" value="female" required>Female
                <input type="radio" name="gender" value="male" required>Male
                <span class="error">* <?php echo $genderErr;?></span>
                <br><br>
            
            <input type="submit" name="submit" value="Submit">  
        </form>
        
        <br>
        <p><a  href="system.php" target="_self">Login</a></p>
        </div>

        
        <?php
        if(!empty($name) || !empty($email) || !empty($np) || !empty($password) || !empty($gender)){
            $host = "localhost";
            $dbUsername = "root";
            $dbPassword = "";
            $dbName = "membersholine";
            
            //create connection
            $conn = new mysqli($host, $dbUsername, $dbPassword, $dbName);
            
            if(mysqli_connect_error()){
                die('connect Error('. mysqli_connect_errno().')'. mysqli_connect_error());
            } else{
                $SELECT = "SELECT email From member Where email = ? Limit 1";
                $INSERT = "INSERT Into member (name, email, np, password, gender) values(?, ?, ?, ?, ?)";    
                
                //prepare statement
                $stmt = $conn->prepare($SELECT);
                $stmt->bind_param("s", $email);
                $stmt->execute();
                $stmt->bind_result($email);
                $stmt->store_result();
                $rnum = $stmt->num_rows;
                
                if($rnum==0){
                    $stmt->close();
                    
                    $stmt = $conn->prepare($INSERT);
                    $stmt->bind_param("ssiss", $name, $email, $np, $password, $gender);
                    $stmt->execute();
                    echo "New record inserted succesfully";
                } else{
                    echo "Someone already register  using this email";
                }
                $stmt->close();
                $conn->close();
            }
        } else{
            echo "All field are required";
            die();
        }
    ?>
        
        <?php
            echo "<h2>Your Input:</h2>";    
            echo $name;
            echo "<br>";
            echo $email;
            echo "<br>";
            echo $np;
            echo "<br>";
            echo $password;
            echo "<br>";
            echo $gender;
        ?>
        
        
        
    </body>
</html>