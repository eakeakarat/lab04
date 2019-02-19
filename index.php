<!DOCTYPE html>
<html>
<head>

  <title></title>
  
</head>
<body>
  <?php
  $name = $id = $university = $file = $text = "";
  $nameErr = $idErr = $fileErr = "";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Please enter your name";
    } else {
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Name much contains only letters and white space"; 
      }
    }
    
    if (empty($_POST["id"])) {
      $idErr = "Please enter your ID";
    } else {
      $id = test_input($_POST["id"]);
      if (!preg_match("/^[0-9]+$/",$id)) {
        $idErr = "ID much contains only numbers"; 
      }
    }

    if (empty($_POST["file"])) {
      $fileErr = "Please upload your ID";
    } else {
      $file = test_input($_POST["file"]);
      if (!preg_match("/^[a-zA-z0-9 ]*.csv$/",$file)) {
        $fileErr = "Only .csv file allowed"; 
      }else {
        $myFile = fopen($file,"r");
        $text = fread($myFile,filesize($file));
        fclose($myFile);
      }          
    }
    $university = test_input($_POST["university"]);
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
  ?>
  <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    Name: <input type="text" name="name" value="<?php echo $name;?>">
    <span class="error">* <?php echo $nameErr?> </span><br>
    ID:<input type="text" name="id" value="<?php echo $id;?>">
    <span class="error">* <?php echo $nameErr?> </span><br>
    University : <input type="text" name ="university" value="<?php echo $university;?>"><br>
    Please input your grade in this form, 
    <a href="data.csv">download here</a>  <br>
    Upload : <input type="file" name="file" value="<?php echo $file;?>"> <span class="error">* <?php echo $fileErr?> </span> <br>
    <input type="submit" name="submit" value = "save">
  </form>

  <?php
  echo $name; echo '<br>';
  echo $id; echo '<br>';
  echo $university; echo '<br>';
  echo $text; echo '<br>';
  ?>










</body>

</html>



