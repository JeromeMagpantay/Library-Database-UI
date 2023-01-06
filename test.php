<?php
    function printQuery($q){
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        // Create connection to Oracle
        $conn = oci_connect('m4kainth', '05290561',   '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))');
        $query = $q;
        $stid = oci_parse($conn, $query);
        $r = oci_execute($stid);
        echo str_repeat('&nbsp;', 47);
        echo "<h4>Query: $query</h4>";
        if($r){
            echo "<table border='1'>";
            $ncols = oci_num_fields($stid);
            echo "<tr>\n";
            for ($i = 1; $i <= $ncols; ++$i) {
                $colname = oci_field_name($stid, $i);
                echo "  <th><b>".htmlentities($colname, ENT_QUOTES)."</b></th>\n";
            }
            echo "</tr>\n";
        // Fetch each row in an associative array
            while ($row = oci_fetch_array($stid, OCI_RETURN_NULLS+OCI_ASSOC)) {
                echo "<tr>";
                foreach ($row as $item) {
                    echo "<td>".$item."</td>";
                }
                echo "</tr>";     
            }   
            echo "</table>";
            echo "<br />";
        }
    }
    function runQuery($q){
        error_reporting(E_ALL);
        ini_set('display_errors', 'On');
        // Create connection to Oracle
        $conn = oci_connect('m4kainth', '05290561',   '(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(Host=oracle12c.scs.ryerson.ca)(Port=1521))(CONNECT_DATA=(SID=orcl12c)))');
        $query = $q;
        $stid = oci_parse($conn, $query);
        $r = oci_execute($stid);
    }


    function queryTables(){
        $queries = array("SELECT * FROM ITEM ORDER BY ITEM_ID",
                        "SELECT * FROM BRANCHES ORDER BY BRANCH_ID",
                        "SELECT * FROM EMPLOYEE ORDER BY EMPLOYEE_ID",
                        "SELECT * FROM MEMBERS ORDER BY MEMBER_ID",

                        "SELECT * FROM BOOKS ORDER BY ITEM_ID",
                        "SELECT * FROM ALBUMS ORDER BY ITEM_ID",  
                        "SELECT * FROM MOVIES ORDER BY ITEM_ID",                       
                        
                        "SELECT * FROM COMPUTER",
                        "SELECT * FROM ROOM",

                        "SELECT * FROM CATALOG",

                        "SELECT * FROM OFFERSROOM ORDER BY ROOM_ID",
                        "SELECT * FROM RESERVEDCOMPUTER ORDER BY COMPUTERID",
                        "SELECT * FROM RESERVEDROOM ORDER BY ROOMID",
                        "SELECT * FROM SUPERVISES ORDER BY SUPERVISEE",
                        "SELECT * FROM WORKS_FOR ORDER BY BRANCH_ID");

        foreach ($queries as $query){
            printQuery($query);
        }
    }

    function queryTablesB(){
        $queries = array(
                    "SELECT ALBUMS.ITEM_ID, ALBUMS.ARTIST, ITEM.TITLE, ITEM.RELEASEDATE FROM ALBUMS LEFT JOIN ITEM ON ALBUMS.ITEM_ID = ITEM.ITEM_ID",
                    "SELECT MOVIES.ITEM_ID, MOVIES.DIRECTOR, ITEM.TITLE, ITEM.RELEASEDATE FROM MOVIES LEFT JOIN ITEM ON MOVIES.ITEM_ID = ITEM.ITEM_ID",
                    "SELECT BOOKS.ITEM_ID, BOOKS.AUTHOR, ITEM.TITLE, ITEM.RELEASEDATE FROM BOOKS LEFT JOIN ITEM ON BOOKS.ITEM_ID = ITEM.ITEM_ID",
                    "SELECT RESERVEDROOM.ROOMID, MEMBERS.MEMBER_ID, MEMBERS.FNAME, MEMBERS.LNAME FROM RESERVEDROOM LEFT JOIN MEMBERS ON MEMBERS.MEMBER_ID = RESERVEDROOM.MEMBER_ID",
                    "SELECT OFFERSROOM.BRANCH_ID, OFFERSROOM.ROOM_ID,BRANCHES.LOCATION FROM OFFERSROOM
                    LEFT JOIN BRANCHES ON OFFERSROOM.BRANCH_ID = BRANCHES.BRANCH_ID",
                    "SELECT SUPERVISES.SUPERVISOR, SUPERVISES.SUPERVISEE, E1.FNAME AS SUPERVISOR_FNAME, E1.LNAME AS SUPERVISOR_LNAME, E2.FNAME as SUPERVISEE_FNAME, E2.LNAME AS SUPERVISEE_LNAME
                    FROM SUPERVISES
                        LEFT JOIN (SELECT * FROM EMPLOYEE) E1 on E1.EMPLOYEE_ID = SUPERVISES.SUPERVISOR
                        LEFT JOIN (SELECT * FROM EMPLOYEE) E2 ON E2.EMPLOYEE_ID = SUPERVISES.SUPERVISEE
                    ORDER BY SUPERVISES.SUPERVISOR",

                    "SELECT * FROM BRANCHES WHERE CITY = 'Toronto'"

        );

        foreach ($queries as $query){
            printQuery($query);
        }
    }

    function createTables(){
        $file = file_get_contents("create.txt");
        #echo $file
        $array = explode(";", $file);
        foreach($array as $q){
            runQuery($q);
            echo $q.'<br><br><br>';
        }
        echo "Done Creating Tables";
    }

    function dropTables(){
        if ($file = fopen("drop.txt", "r")) {
            while(!feof($file)) {
                $line = fgets($file);
                runQuery($line);
                echo $line.'<br>';
                
            }
            fclose($file);
        }
        echo "Done Dropping Tables";
    }

    function populateTables(){
        if ($file = fopen("populate.txt", "r")) {
            while(!feof($file)) {
                runQuery($line);
                $line = fgets($file);         
            }
            fclose($file);
        }
    
        echo "Done Populating Tables";
    }
?>