<?php
 
require_once 'include/DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
 
if (isset($_POST['uname']) && isset($_POST['uage']) && isset($_POST['uemailID'])&& isset($_POST['upwd'])) {
 
    // receiving the post params
    $fullName = $_POST['uname'];
    $age = $_POST['uage'];
    $emailID = $_POST['uemailID'];
    $pwd = $_POST['upwd'];
 

        // create a new event
        $user = $db->addUser($fullName, $age, $emailID,$pwd);
        if ($user) {
            // user stored successfully
            $response["error"] = FALSE;
            $response["uid"] = $user["userID"];
            $response["user"]["fullName"] = $user["fullName"];
            $response["user"]["age"] = $user["age"];
            $response["user"]["emailID"] = $user["emailID"];
            $response["user"]["pwd"] = $user["pwd"];
            echo json_encode($response);
        } else {
            // user failed to store
            $response["error"] = TRUE;
            $response["error_msg"] = "User is already registered";
            echo json_encode($response);
        }

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Required parameters (name,age,email or password) is missing!";
    echo json_encode($response);
}
?>