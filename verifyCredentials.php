<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['email'])) {
 
    // receiving the post params
    $email = $_POST['email'];
    
        // create a new event
        $user = $db->checkEmailAndPassword($email);
        if ($user) {
            // user found in database
            $response["error"] = FALSE;
            $response["uid"] = $user["userID"];
            $response["user"]["fullName"] = $user["fullName"];
            $response["user"]["age"] = $user["age"];
            $response["user"]["emailID"] = $user["emailID"];
            $response["user"]["pwd"] = $user["pwd"];
            echo json_encode($response);
        } else {
            // user not found
            $response["error"] = TRUE;
            $response["error_msg"] = "User not found";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "User not found!";
    echo json_encode($response);
}
?>