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
    
    $formFields     = $_POST;
    $isSubmitted    = empty($formFields);
    $memberCount    = 1;
    $addTeam        = false;
    $addMember      = false;
    $formIsValid    = false;
    $validFields    = array('teamName', 'captainName', 'captainNumber', 'captainEmail');
    $errorFields    = array();
    $memberNames    = array();

    if (!$isSubmitted){
        $teamName       = check_input($_POST['teamName']);
        $captainName    = check_input($_POST['captainName']);
        $captainNumber  = check_input($_POST['captainNumber']);
        $captainEmail   = check_input($_POST['captainEmail']);
        $charity        = check_input($_POST['charity']);
        $addTeam        = check_input($_POST['addTeam']);
        $addMember      = check_input($_POST['addMember']);   
    } else {
        $teamName       = '';
        $captainName    = '';
        $captainNumber  = '';
        $captainEmail   = '';
        $charity   = '';
        $addTeam        = 'false';
        $addMember      = 'false';
        $memberName_1   = '';
        $memberEmail_1  = '';
        $memberPhoneNumber_1 = '';
    }

    // Adding a team member, so bump up the field count
    if ($addMember === 'true'){
        $memberCount = check_input($_POST['memberCount']) + 1;
    }
    
    // Adding a team, so form needs validating
    if ($addTeam === 'true'){
        $memberCount = check_input($_POST['memberCount']);
        $x = 1;
        
        // Add the dynamically created member fields to be validated
        while ($x <= $memberCount){
            array_push($validFields, 'memberName_' . $x, 'memberEmail_' . $x);
            array_push($memberNames, check_input($_POST['memberName_' . $x]));
            $x ++;
        }
        
        // Loop through all fields and validating where needed
        foreach ($formFields as $field => $value){  
            if (in_array($field, $validFields)){
                if ($value === ""){
                    array_push($errorFields, $field);    
                }

                if (strpos($field, "Email") > 0){
                    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
                        array_push($errorFields, $field);
                    }
                }
            }

            if (strpos($field, "Number") > 0 && $value !== ""){
                $phonePattern = "/^(((\+44\s?\d{4}|\(?0\d{4}\)?)\s?\d{3}\s?\d{3})|((\+44\s?\d{3}|\(?0\d{3}\)?)\s?\d{3}\s?\d{4})|((\+44\s?\d{2}|\(?0\d{2}\)?)\s?\d{4}\s?\d{4}))(\s?\#(\d{4}|\d{3}))?$/";
                if (!preg_match($phonePattern, $value)) {
                    array_push($errorFields, $field);
                }
            }            
        }

        if (count($errorFields) === 0){
            $formIsValid = true;
        }
        
        $memberCount = check_input($_POST['memberCount']);
    }
    
    // Adding team and form is valid, so commit to DB
    if ($addTeam === 'true' && $formIsValid === true):

        //Database Connect
        include 'db-connect.php';
 
        //declare the SQL statement that will query the database for teams
        $teamQuery = "INSERT INTO teams (teamname, captainname, captainphone, captainemail, charity) ";
        $teamQuery .= "VALUES ('" . check_input($_POST['teamName']) . "', '" . check_input($_POST['captainName']) . "', '" . check_input($_POST['captainNumber']) . "', '" . check_input($_POST['captainEmail']) . "', '" . check_input($_POST['charity']) . "')";
        
        
        //execute the SQL query
        $q = mysql_query($teamQuery)
            or die(mysql_error());

        //declare the SQL statement that will query the database for members
        $membersQuery = "INSERT INTO members (membername, memberphone, memberemail, teamnumber) ";
        $membersQuery .= "VALUES ";

        $x = 1;
        while ($x <= $memberCount){
            $membersQuery .= "('" . check_input($_POST['memberName_' . $x]) . "', '" . check_input($_POST['memberPhoneNumber_' . $x]) . "', '" . check_input($_POST['memberEmail_' . $x]) . "', LAST_INSERT_ID())";
            if ($x < $memberCount){
                $membersQuery .= ",";
            }
            $x ++;
        }

        //execute the SQL query
        $q = mysql_query($membersQuery)
            or die(mysql_error());
        
        //echo('<p>Submitted</p>');
        //echo('<p>' . $teamQuery . '</p>');
        //echo('<p>' . $membersQuery . '</p>');

        include 'confirmation.php';
        include 'email-confirmation.php';
        
    else:
?>

<p>Please enter the details of your team below.</p>
<p>Fields marked * are required and need to be filled in.</p>

<form id="registration" action="enter.php" method="post">
    
    <fieldset id="team">
        <h3>Your Team</h3>
        <div class="element<?php echo(in_array('teamName', $errorFields) ? ' error' : '') ?>">
            <label for="teamName">
                Team name *
            </label>
            <input type="text" maxlength="100" name="teamName" id="teamName" value="<?php echo($teamName) ?>" />
            <div class="error-message">Please enter a team name</div>
        </div>
        <div class="element<?php echo(in_array('captainName', $errorFields) ? ' error' : '') ?>">
            <label for="captainName">
                Captain's name *
            </label>
            <input type="text" name="captainName" id="captainName" value="<?php echo($captainName) ?>" />
            <div class="error-message">Please enter the team captain's name</div>
        </div>
        <div class="element<?php echo(in_array('captainEmail', $errorFields) ? ' error' : '') ?>">
            <label for="captainEmail">
                Captain's email address *
            </label>
            <input type="email" name="captainEmail" id="captainEmail" value="<?php echo($captainEmail) ?>" />
            <div class="error-message">Please enter a valid email address</div>
        </div>
        <div class="element<?php echo(in_array('captainNumber', $errorFields) ? ' error' : '') ?>">
            <label for="captainPhoneNumber">
                Captain's mobile number *
            </label>
            <input type="text" maxlength="11" name="captainNumber" id="captainNumber" value="<?php echo($captainNumber) ?>" />
            <div class="error-message">Please enter a valid phone number</div>
        </div>
        <div class="element">
            <label for="charity">
                Charity name
            </label>
            <input type="text" maxlength="100" name="charity" id="charity" value="<?php echo($charity) ?>" />
        </div>
    </fieldset>
    
    <fieldset id="members">
        <h3>Your Team Members</h3>

        <?php 
            $i = 1;
            while ($i <= $memberCount) : ;
        ?>
        <div class="team-member">
            <h4>Team Member <?php echo($i) ?></h4>
            <div class="element<?php echo(in_array('memberName_' . $i, $errorFields) ? ' error' : '') ?>">
                <label for="memberName_<?php echo($i) ?>">
                    Name *
                </label>
                <input type="text" name="memberName_<?php echo($i) ?>" id="memberName_<?php echo($i) ?>" value="<?php echo(check_input($_POST['memberName_' . $i])) ?>" />
                <div class="error-message">Please enter the team member's name</div>
            </div>
            <div class="element<?php echo(in_array('memberEmail_' . $i, $errorFields) ? ' error' : '') ?>">
                <label for="memberEmail_<?php echo($i) ?>">
                    Email address *
                </label>
                <input type="text" name="memberEmail_<?php echo($i) ?>" id="memberEmail_<?php echo($i) ?>" value="<?php echo(check_input($_POST['memberEmail_' . $i])) ?>" />
                <div class="error-message">Please enter a valid email address</div>
            </div>
            <div class="element<?php echo(in_array('memberPhoneNumber_' . $i, $errorFields) ? ' error' : '') ?>">
                <label for="memberPhoneNumber_<?php echo($i) ?>">
                    Mobile number
                </label>
                <input type="text" maxlength="11" name="memberPhoneNumber_<?php echo($i) ?>" id="memberPhoneNumber_<?php echo($i) ?>" value="<?php echo(check_input($_POST['memberPhoneNumber_' . $i])) ?>" />
                <div class="error-message">Please enter a valid phone number</div>
            </div>
        </div>
        
        <?php 
            $i ++;
            endwhile; 
        ?>
        
        <input type="hidden" name="memberCount" value="<?php echo($memberCount) ?>" />

        <?php 
            if ($memberCount < 5):
        ?>
        <button name="addMember" value="true">Add more team members</button>
        <?php endif; ?>

    </fieldset>
    
    <button name="addTeam" value="true">Add your team</button>
</form>

<?php
    endif;
?>