<?php
    require 'test.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="styles.css" />
    <title>CPS 510 Assignment 9</title>
</head>
<body>

    <div class = "input">
    <h1>Library Data Management System</h1>
    <h3 class='sub'>Developed by Mayank, AngeloJ, and Adam</h3>
    
    

    <div class = "input">
        <form class="bonusform" method="post">
            <input style="width:1200px;" type="text" id="insertstatement" class="textinput" name="insertstatement">
            <input type = "submit" name="updatedabase" class = "buttonB button2" value="Update Database"><br>

            <input style="width:1200px;" type="text" id="querystatement" class="textinput" name="querystatement">
            <input type = "submit" name="querydatabase" class = "buttonB button4" value="Custom Query Database"><br>
        </form>
    </div>

    <?php
        if(array_key_exists('updatedatabase',$_POST)){
            runQuery($_POST['insertstatement']);
        }
        else if(array_key_exists('querydatabase', $_POST)){
            printQuery($_POST['querystatement']);
        }
    ?>

    <form class='mainform' method="post">
            <input type = "submit" name="Query" class = "button button1" value="Query Tables">
            <input type = "submit" name="Advanced" class = "button button6" value="Advanced Query Tables">
            <input type = "submit" name="Create" class = "button button2" value="Create Tables">
            <input type = "submit" name="Populate" class = "button button3" value="Populate Tables">
            <input type = "submit" name="Drop" class = "button button5" value="Drop Tables">
    </form>
    <br />

    <?php 
        if(array_key_exists('Query', $_POST)){
            queryTables();
        }
        else if(array_key_exists('Create', $_POST)){
            createTables();
        }
        else if(array_key_exists('Populate', $_POST)){
            populateTables();
            populateTables();
        }
        else if(array_key_exists('Drop', $_POST)){
            dropTables();
        }
        else if(array_key_exists('Advanced', $_POST)){
            queryTablesB();
        }
        
    ?>


    <br><br>



    <?php
        #printQuery("SELECT * FROM EMPLOYEE");
        #queryTables();
    ?>

</body>
</html>
