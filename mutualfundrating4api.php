<?php include 'db.php';
$strsql = "select fundoverview.FundName, Category, FundFamily, Inception, NetAssets, YTD_Return, Yield, Rating, Share_Price, Change_USD, Change_Perc from fundoverview join priceandperformance on fundoverview.FundName = priceandperformance.FundName where Rating > 3 and Rating < 5;";
$result = $mysqli->query($strsql);
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
