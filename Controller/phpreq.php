<?php
include '../model/dbcon.php';
require_once '../model/User.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Credentials: true");
header("Access-Control-Max-Age: 31536000");



if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $jsonData = file_get_contents('php://input');
    $data = json_decode($jsonData, true);
    if(isset($data['action']) && $data['action'] == 'checkUser'){
        if(isset($data['id'])){
            $id = sanitizeString($data['id']);
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $user = new User($pdo);
            $result = $user->findUser($id);
            echo ($result['username']);
        }
    }
    if(isset($data['action']) && $data['action'] == 'delete'){
        $id = $data['id'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user = new User($pdo);
        $result =$user->updateDelete($id);
        if($result){
            echo $result;
        } else {
            echo "something went is wrong";
        }
    }
    if(isset($data['action']) && $data['action'] == 'update'){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $user = new User($pdo);
        $result = $user->userRequests();
        echo ($result);
    }
}
function sanitizeString($inputSanitizeData)
{
    $inputSanitizeData = trim($inputSanitizeData);
    $inputSanitizeData = stripslashes($inputSanitizeData);
    $inputSanitizeData = htmlspecialchars($inputSanitizeData);
    return $inputSanitizeData;
}
?>