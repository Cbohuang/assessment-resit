<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add_data</title>
</head>

<body>
<?php
    if ($_SERVER['REQUEST_METHOD']== "POST"){
        $id = filter_input(INPUT_POST, "id");
        $name = filter_input(INPUT_POST, "name");
        $phonenumber = filter_input(INPUT_POST, "phonenumber");
        $account = filter_input(INPUT_POST, "account");
        $password = filter_input(INPUT_POST, "password");
        $errorflag = false;
        $errors = array();

        if(empty($id)){
            $errors[] = "please type your ID";
            $errorflag = true;
        }
        if(empty($name)){
            $errors[] = "please fill in your name";
            $errorflag = true;
        }
        if(empty($phonenumber)){
            $errors[] = "please type your phonenumber";
            $errorflag = true;
        }
        if(empty($account)){
            $errors[] = "please type your account";
            $errorflag = true;
        }
        if(empty($password)){
            $errors[] = "please fill in your password";
            $errorflag = true;
        }
        if ($errorflag === true){
            foreach($errors as $error){
                echo"<p>" .$error."</p>";
            }
        }
        else{ echo "<h1>Congrats you success</h1>";}
     
    

    try {
        $db_handler = new PDO("mysql:host=mysql;dbname=M3T.com;charset=utf8", "root", "qwerty");
    } catch (Exception $ex) {
        printError($ex);
    }

    function printerror(String $err){
        echo "<h1>the following error occured</h1>
            <p>$err</p>";
    }
    if($db_handler){
        try{
            $stmt = $db_handler->prepare("INSERT INTO `userdata` (`ID`, `Name`,`Phone number`, `Account`, `Password`) 
            VALUES (:id, :name, :phonenumber, :account, :password)");
            $stmt->bindParam(":id", $id, PDO::PARAM_STR);
            $stmt->bindParam(":name", $name, PDO::PARAM_INT);
            $stmt->bindParam(":phonenumber", $phonenumber, PDO::PARAM_STR);
            $stmt->bindParam(":account", $account, PDO::PARAM_STR);
            $stmt->bindParam(":password", $password, PDO::PARAM_STR);
            $stmt->execute(); 
            echo "Your query executed! {$stmt->rowCount()} row(s) affected<br>";
            $stmt->closeCursor();
        }   catch(Exception $ex) {
            printError($ex);
        }
    }
}
?>
    <form action="" method="post">
       <p>
            <h2>Add New Data:</h2> 
            <label for="id">ID</label>
            <input type="text" name="id" id="id" required placeholder="Please type your id">
       </p>

       <p>
            <label for="name">Name</label>
            <input type="text" name="name" id="name" requered placeholder="Please type your name"> 
       </p>

       <p>
            <label for="phonenumber">Phonenumber</label>
            <input type="text" name="phonenumber" id="phonenumber" required placeholder="Please type your phonenumber">
       </p>

       <p>
            <label for="account">Account</label>
            <input type="text" name="account" id="account" required placeholder="Please type your account">
       </p>

       <p>
            <label for="password">Password</label>
            <input type="text" name="password" id="password" required placeholder="Please fill in your password">
       </p>       
       <input type="submit">
       <input type="reset">
    </form>
</body>
</html>