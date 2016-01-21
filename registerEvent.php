<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['ename']) && isset($_POST['edate']) && isset($_POST['location'])&& isset($_POST['description'])) {
 
    // receiving the post params
    $ename = $_POST['ename'];
    $edate = $_POST['edate'];
    $elocation = $_POST['location'];
    $edescription = $_POST['description'];
 

        // create a new event
        $event = $db->addEvent($ename, $edate, $elocation,$edescription);
        if ($event) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["eid"] = $event["eventID"];
            $response["event"]["ename"] = $event["ename"];
            $response["event"]["edate"] = $event["edate"];
            $response["event"]["location"] = $event["location"];
            $response["event"]["description"] = $event["description"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "Unknown error occurred in registration!";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name, email or password) is missing!";
    echo json_encode($response);
}
?>