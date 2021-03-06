<!DOCTYPE html>
<html>
<head>
  <title>Grade Calculator</title>
  <link rel="stylesheet" href="bulma-0.7.2/css/bulma.css">
  <link rel="stylesheet" href="style.css">
  
</head>
<body>
<?php
  $name = $id = $university = $file =  "";
  $fileReady = $nameOK = $idOK = false ;
  $nameErr = $idErr = $fileErr = "";
  $t = $s = "none";

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["name"])) {
      $nameErr = "Please enter your name";
    } else {
      $name = test_input($_POST["name"]);
      if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
        $nameErr = "Name much contains only letters and white space"; 
      }else {
        $nameErr = "";
        $nameOK = true;
      }
    }
    
    if (empty($_POST["id"])) {
      $idErr = "Please enter your ID";
    } else {
      $id = test_input($_POST["id"]);
      if (!preg_match("/^[0-9]+$/",$id)) {
        $idErr = "ID much contains only numbers"; 
      }else {
        $idErr = "";
        $idOK = true;
      }
    }

    if (empty($_POST["file"])) {
      $fileErr = "Please upload your ID";
    } else {
      $file = test_input($_POST["file"]);
      if (!preg_match("/^[a-zA-z0-9 ]*.csv$/",$file)) {
        $fileErr = "Only .csv file allowed"; 
      }else {
        $fileErr = "";
        $fileReady = true;
      }         
    }
    $university = test_input($_POST["university"]);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if ($fileReady && $idOK && $nameOK){
        $t = "" ;
      }else {
        $t = "none";
      }
    }
  }

  function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
  }
?>

  <section class="hero">
    <h1>Grade Calculator</h1>
      <div class="container" id="first-box">
        <form class="box container" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">   
          <p>Name: <span class="require">*<?php echo $nameErr?></span></p>
          <div><input id="name" class="input is-rounded is-info" type="text" placeholder="Name" name="name" value="<?php echo $name;?>"></div> 

          <p>ID: <span class="require">*<?php echo $idErr?></span></p>
          <div><input id="id" class="input is-rounded is-info" type="text" placeholder="ID" name="id" value="<?php echo $id;?>"></div>

          <p>University : </p>
          <div><input id="univer" class="input is-rounded is-info" type="text" placeholder="university" name ="university" value="<?php echo $university;?>"><br></div>

          <p style="text-align: center; text-indent: 0px;">Please input your grade in this form, <a href="data.csv">download here</a></p>

          <p>Upload your complete form : <span class="require">* <?php echo $fileErr?></span></p> 
          <div>
            <input id="file" type="file" name="file" value="<?php echo $file;?>" style="display:none" 
            onchange=uploaded(this)>
            <label for="file" class="button" id="select-file" > Select a file... </label> <br>
            <label class='box' id="return-file" style="box-shadow:0 0px 0px; width:50%"></label>
          </div>
        
          <div>
            <input id="submit-btn" class="button is-rounded" type="submit" name="submit" value = "Submit">
          </div>
        </form>
     
      <div id="result" class="box container result" style="display:<?php echo $t ?>">
        <?php
          if ($fileReady && $idOK && $nameOK){
            echo "Name: " . $name . '<br>';
            echo "ID: " . $id . '<br>';
            if ($university != ''){
              echo "University: " . $university . "<br>";
            }
            echo "<br>";
            $totalCredit = $totalScore = 0.00;
            $myFile = fopen($file,"r");
            while (!feof($myFile)){
              $text = explode(",",fgets($myFile));

              $grade = floatval($text[1]);
              $cr = intval($text[2]);

              if ($text[1] == 'A' || $text[1] == 'a' || $grade == 4.00 ){
                $grade = 4.00;
                $text[1] = '4.00';
              } elseif ($text[1] == 'B+' || $text[1] == 'b+' || $grade == 3.50 ){
                $grade = 3.50;
                $text[1] = '3.50';
              } elseif ($text[1] == 'B' || $text[1] == 'b' || $grade == 3.00 ){
                $grade = 3.00;
                $text[1] = '3.00';
              } elseif ($text[1] == 'C+' || $text[1] == 'c+' || $grade == 2.50 ){
                $grade = 2.50;
                $text[1] = '2.50';
              } elseif ($text[1] == 'C' || $text[1] == 'c' || $grade == 2.00 ){
                $grade = 2.00;
                $text[1] = '2.00';
              } elseif ($text[1] == 'D+' || $text[1] == 'd+' || $grade == 1.50 ){
                $grade = 1.50;
                $text[1] = '1.50';
              } elseif ($text[1] == 'D' || $text[1] == 'd' || $grade == 1.00 ){
                $grade = 1.00;
                $text[1] = '1.00';
              }else { // P=pass or NP=notpass both are not accept
                $grade = '-1';
                $text[1] = 'Wrong format';
              }
              
              
              if ($grade != -1) {
                $totalCredit += $cr;
                $totalScore += ($grade * $cr);
              }
              echo "&nbsp" . $text[0] . "<br>" . "Credit: "  . $text[2] . " Grade: " .  $text[1] . "<br>" ;

            }
            fclose($myFile);
            echo "<br>" . "Your GPA: " . number_format(($totalScore / $totalCredit),2);
          }
        ?>
      </div>
    </div>
  </section>

  <script>
    function uploaded(dir){
      var file = "selected file:" + '<br>' + dir.files[0].name ;
      document.getElementById('return-file').innerHTML = file;
    }
  </script>

</body>

</html>



