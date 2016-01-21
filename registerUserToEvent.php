<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['eID']) && isset($_POST['uID'])) {
 
    // receiving the post params
    $userID = $_POST['uID'];
    $eventID = $_POST['eID'];
 

        // create a new event
        $confirm = $db->registerUserToEvent($userID, $eventID);
        if ($confirm) {
            // user registered to event
            $response["error"] = FALSE;
            $response["uid"] = $confirm["userID"];
            $response["eid"] = $confirm["eventID"];
            echo json_encode($response);
        } else {
            //user failed to register
            $response["error"] = TRUE;
            $response["error_msg"] = "User is already registered!";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name,age,email or password) is missing!";
    echo json_encode($response);
}
?>