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
</head>

<body>
    <div class="">
    <table id='notes' class='records'><tbody>
        
        <?php
            while ($property = mysqli_fetch_field($result)) {
                    $header[] = $property-> name;
            }

            mysqli_data_seek ( $result, 0 );
            if($result->num_rows == 0){ //nothing in the table
                        echo '<td>Empty!</td>';
            }
                
            while ( $row = mysqli_fetch_row ( $result ) ) {
                for($i = 0; $i < mysqli_num_fields ( $result ); $i ++) {
                    $data[] = $row[$i];
                }
            
            }

            foreach($result as $xrow ) {
                echo json_encode($xrow);
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
