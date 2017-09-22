<!--
/**
* Copyright 2015 IBM Corp. All Rights Reserved.
*
* Licensed under the Apache License, Version 2.0 (the “License”);
* you may not use this file except in compliance with the License.
* You may obtain a copy of the License at
*
* https://www.apache.org/licenses/LICENSE-2.0
*
* Unless required by applicable law or agreed to in writing, software
* distributed under the License is distributed on an “AS IS” BASIS,
* WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
* See the License for the specific language governing permissions and
* limitations under the License.
*/
->

<?php include 'db.php';?>
<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") { //if new message is being added
    $cleaned_message = preg_replace('/[^a-zA-Z0-9.\s]/', '', $_POST["message"]); //remove invalid chars from input.
    $strsq0 = "INSERT INTO MESSAGES_TABLE ( MESSAGE) VALUES ('" . $cleaned_message . "');"; //query to insert new message
    if ($mysqli->query($strsq0)) {
        //echo "Insert success!";
    } else {
        echo "Cannot insert into the data table; check whether the table is created, or the database is active. "  . mysqli_error();
    }
}

//Query the DB for messages
//$strsql = "select * from MESSAGES_TABLE ORDER BY ID DESC limit 100";
$strsql = "select fundoverview.FundName, Category, FundFamily, Inception, NetAssets, YTD_Return, Yield, Rating, Share_Price, Change_USD, Change_Perc from fundoverview join priceandperformance on fundoverview.FundName = priceandperformance.FundName;";
if ($result = $mysqli->query($strsql)) {
   // printf("<br>Select returned %d rows.\n", $result->num_rows);
} else {
        //Could be many reasons, but most likely the table isn't created yet. init.php will create the table.
        echo "<b>Can't query the database, did you <a href = init.php>Create the table</a> yet?</b>";
    }
?>


<!DOCTYPE html>
<html>

<head>
    <title>Cognitive Hub API</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,minimum-scale=1,user-scalable=no" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <div class="">
        <img class="newappIcon" src="images/newapp-icon.png" />
        <h1>
					Welcome to <span class="blue"> Cognitive Hub PHP MySQL Mutual Fund API</span> on Bluemix!
				</h1>
        <p class="description">This API allows you to pull mutual fund data from a MySQL database. <br>
            <input type="button" class = "mybutton" onclick="window.location = 'init.php';" class="btn" value="(Re-)Create table"></input>


        <form action="https://php-mysql-20170915171443054.mybluemix.net/mutualfunds.html">
             <input type="submit" value="See mutual fund info" />
        </form>
        <form action="https://php-mysql-20170915171443054.mybluemix.net/rating==5.php">
             <input type="submit" value="See 5 star mutual funds" />
        </form>
        <form action="https://php-mysql-20170915171443054.mybluemix.net/rating==4.php">
             <input type="submit" value="See 4 star mutual funds" />
        </form>
        <form action="https://php-mysql-20170915171443054.mybluemix.net/rating==3.php">
             <input type="submit" value="See 3 star mutual funds" />
        </form>
        <form action="https://php-mysql-20170915171443054.mybluemix.net/etf.php">
             <input type="submit" value="See ETF's" />
        </form>
        <form action="https://php-mysql-20170915171443054.mybluemix.net/etfinfo.html">
             <input type="submit" value="See etf info" />
        </form>
            </p>
            </br>

    
    <table id='notes' class='records'><tbody>
        
        <?php
            echo "<tr>\n";
            while ($property = mysqli_fetch_field($result)) {
                    echo '<th>' .  $property->name . "</th>\n"; //the headings

            }
            echo "</tr>\n";

            mysqli_data_seek ( $result, 0 );
            if($result->num_rows == 0){ //nothing in the table
                        echo '<td>Empty!</td>';
            }
                
            while ( $row = mysqli_fetch_row ( $result ) ) {
                echo "<tr>\n";
                for($i = 0; $i < mysqli_num_fields ( $result ); $i ++) {
                    echo '<td>' . "$row[$i]" . '</td>';
                }
                echo "</tr>\n";
            }

            $result->close();
            mysqli_close();
        ?>
        <tr>

        </tr>
        </tbody>
    </table>
    </div>
</body>

</html>
