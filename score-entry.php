<!DOCTYPE html>
<meta charset="UTF-8">
<html>
    <?php 
    	$titleTag = "Enter Your Team";
    	include("includes/html-head.php"); ?>
    <body>
        <?php include("includes/header.php"); ?>
        
        <section>
            <h2>Team Score Entry</h2>
            <form action="score-entry.php" method="post">
                <table id="score-table">
                    <thead>
                        <tr>
                            <td>&nbsp;</td>
                            <th colspan="10">Round</th>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <th>Bonuses</th>
                            <th>1</th>
                            <th>2</th>
                            <th>3</th>
                            <th>4</th>
                            <th>5</th>
                            <th>6</th>
                            <th class="total">Total</th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            function check_input($data)
                            {
                                $data = trim($data);
                                $data = stripslashes($data);
                                $data = mb_convert_encoding($data, 'ISO-8859-1', 'ISO-8859-1');
                                $data = htmlspecialchars($data, ENT_QUOTES, 'ISO-8859-1');
                                return $data;
                            }

                            function decode_input($data){
                                return htmlspecialchars_decode($data, ENT_QUOTES);
                            }
                            
                            $formFields  = $_POST;
                            $isSubmitted = empty($formFields);
                            $addScores   = false;
                            $formIsValid = false;
                            $validFields = array('bonus', 'round1', 'round2', 'round3', 'round4', 'round5', 'round6');
                            $errorFields = array();
                            $scores      = array();

                            //print_r($formFields);

                            //Database Connect
                            include 'includes/db-connect.php';

                            // Adding scores, so form needs validating
                            // if (!$isSubmitted){
                            //     $x = 1;
                                
                            //     // Loop through all fields and validating where needed
                            //     foreach ($formFields as $field => $value){  
                            //         if ($value === ""){
                            //             array_push($errorFields, $field);    
                            //         }
                            //         if (!ctype_digit($value)){
                            //             array_push($errorFields, $field);    
                            //         }          
                            //     }

                            //     if (count($errorFields) === 0){
                            //         $formIsValid = true;
                            //     }
                            // }

                            // Adding scores and form is valid, so commit to DB
                            if (!$isSubmitted){
                                //declare the SQL statement that will query the database for scores

                                $x = 0;
                                while ($x < count($_POST['teamNumber'])){
                                    $teamnumber = check_input($_POST['teamNumber'][$x]);
                                    $bonus     = check_input($_POST['bonus'][$x]);
                                    $round1     = check_input($_POST['round1'][$x]);
                                    $round2     = check_input($_POST['round2'][$x]);
                                    $round3     = check_input($_POST['round3'][$x]);
                                    $round4     = check_input($_POST['round4'][$x]);
                                    $round5     = check_input($_POST['round5'][$x]);
                                    $round6     = check_input($_POST['round6'][$x]);
                                    $total      = $bonus + $round1 + $round2 + $round3 + $round4 + $round5 + $round6;

                                    $updateQuery = "UPDATE scores SET bonus = '$bonus', round1 = '$round1', round2 = '$round2', round3 = '$round3', round4 = '$round4', round5 = '$round5', round6 = '$round6', total = '$total' WHERE teamnumber = $teamnumber;";

                                    $q = mysql_query($updateQuery)
                                        or die(mysql_error());

                                    $x ++;
                                }
                            }
                            
                            //declare the SQL statement that will query the database for scores
                            $scoresQuery = "SELECT teams.teamname, teams.teamnumber, scores.bonus, scores.round1, scores.round2, scores.round3, scores.round4, scores.round5, scores.round6, scores.total ";
                            $scoresQuery .= "FROM teams, scores ";
                            $scoresQuery .= "WHERE teams.teamnumber = scores.teamnumber AND teams.paid = true ";
                            $scoresQuery .= "GROUP BY teams.teamnumber";
                            
                            //execute the SQL query and return records
                            $scoresResult = mysql_query($scoresQuery)
                                or die(mysql_error());
                            
                            $numRows = mysql_num_rows($scoresResult);
                            
                            //display the results 
                            while($row = mysql_fetch_array($scoresResult)):
                                $teamname   = $row["teamname"];
                                $teamnumber = $row["teamnumber"];
                                $bonus      = $row["bonus"];
                                $round1     = $row["round1"];
                                $round2     = $row["round2"];
                                $round3     = $row["round3"];
                                $round4     = $row["round4"];
                                $round5     = $row["round5"];
                                $round6     = $row["round6"];
                                $total      = $row["total"];
                        ?>

                        <tr>
                            <th><?php echo($teamname) ?></th>
                            <td><input type="text" maxlength="10" name="bonus[]" id="bonus_<?php echo($bonus) ?>" value="<?php echo($bonus) ?>" /></td>
                            <td><input type="text" maxlength="10" name="round1[]" id="round1_<?php echo($teamnumber) ?>" value="<?php echo($round1) ?>" /></td>
                            <td><input type="text" maxlength="10" name="round2[]" id="round2_<?php echo($teamnumber) ?>" value="<?php echo($round2) ?>" /></td>
                            <td><input type="text" maxlength="10" name="round3[]" id="round3_<?php echo($teamnumber) ?>" value="<?php echo($round3) ?>" /></td>
                            <td><input type="text" maxlength="10" name="round4[]" id="round4_<?php echo($teamnumber) ?>" value="<?php echo($round4) ?>" /></td>
                            <td><input type="text" maxlength="10" name="round5[]" id="round5_<?php echo($teamnumber) ?>" value="<?php echo($round5) ?>" /></td>
                            <td><input type="text" maxlength="10" name="round6[]" id="round6_<?php echo($teamnumber) ?>" value="<?php echo($round6) ?>" /></td>
                            <td class="total"><?php echo($total) ?><input type="hidden" name="teamNumber[]" value="<?php echo($teamnumber) ?>" /></td>
                        </tr>

                        <?php
                            endwhile;

                            //close the connection
                            mysql_close($dbhandle);
                        ?>
                    </tbody>    
                </table>
                <button name="updateScores" value="true" type="submit">Update scores</button>
            </form>

            <h3>Round names</h3>
            <ol>
                  <li>Early Entry (100)</li>
                  <li>Bonus 1 (250)</li>
                  <li>Bonus 2 (250)</li>
                  <li>Bonus 3 (250)</li>
                  <li>Bonus 4 (250)</li>
                  <li>Scavenger Hunt (3600)</li>
                  <li>Challenge 1 (500)</li>
                  <li>Challenge 2 (500)</li>
                  <li>Challenge 3 (500)</li>
                  <li>Challenge 4 (500)</li>
                  <li>Photo Challenge (8300)</li>
                  <li>Total Max Points Available (15000)</li>
            </ol>
        </section>
    </body>
</html>