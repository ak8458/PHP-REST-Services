<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
$result=$db->getAllEvents();
// json response array
$response = array("error" => FALSE);



if ($result) {
    // looping through all results
    // products node
    $response["events"] = array();

    foreach ($result as $row) {
        // temp user array
        $event = array();
        $event["eid"] = $row["eventID"];
        $event["ename"] = $row["ename"];
        $event["location"] = $row["location"];
        $event["description"] = $row["description"];
        $event["edate"] = $row["edate"];

        // push single product into final response array
        array_push($response["events"], $event);
    }
    // success
    $response["error"] = FALSE;

    // echoing JSON response
    echo json_encode($response);
}  else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name,age,email or password) is missing!";
    echo json_encode($response);
}
?>