<?php

require_once ("DBController.php");

$db_handle_deux = new DBController;

$query = "SELECT DISTINCT location FROM `ibb_cardetails_tracker";


$result = $db_handle_deux->runQuery($query);




?>

<html>

    <head></head>

    <body>
        <div class="row">
                <label>Location:</label><br /> 
                    <select
                    id="location-list" name="location-list" 
                    class="demotwoInputBox"
                     multiple size=4>

                        <option value="">Select Location</option>
                            <?php
                                foreach ($result as $country) {
                            ?>
                        <option value="<?php echo $country["location"]; ?>"><?php echo $country["location"]; ?></option>
                            <?php
                                }
                            ?>
                    </select>
        </div>



    </body>

</html>