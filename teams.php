<!DOCTYPE html>
<meta charset="UTF-8">
<html>
    <?php 
        $titleTag = "Teams";
        include("includes/html-head.php"); ?>
    <body>
        <?php include("includes/header.php"); ?>
        <section>
            <h2>Teams</h2>
            <?php
                //Database Connect
                include 'includes/db-connect.php';
                
                //declare the SQL statement that will query the database for teams
                $teamQuery = "SELECT teams.teamname, teams.captainname, ";
                $teamQuery .= "GROUP_CONCAT(members.membername SEPARATOR ',') AS members ";
                $teamQuery .= "FROM teams, members ";
                $teamQuery .= "WHERE teams.teamnumber = members.teamnumber AND teams.paid = true ";
                $teamQuery .= "GROUP BY teams.teamnumber";
                
                //execute the SQL query and return records
                $teamResult = mysql_query($teamQuery)
                    or die(mysql_error());
                
                $numRows = mysql_num_rows($teamResult); 
                echo "<h2>" . $numRows . " team" . ($numRows == 1 ? "" : "s") . " ha" . ($numRows == 1 ? "s" : "ve") . " already entered! </h2>"; 
                
                //display the results 
                while($row = mysql_fetch_array($teamResult)):
            ?>
                <article>
                    <h3><?php echo($row["teamname"]) ?></h3>
                    <p>Captained by <strong><?php echo($row["captainname"]) ?></strong></p>
                    <ul>
                        <?php 
                            $members = explode(",", $row["members"]);
                            foreach ($members as $member):
                        ?>
                            <li><?php echo($member) ?></li>
                        <?php endforeach; ?>
                    </ul>
                </article>
            <?php
                endwhile;
                
                //close the connection
                mysql_close($dbhandle);
            ?>
            
        </section>
    </body>
</html>