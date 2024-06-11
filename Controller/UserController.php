<?php
ob_start();
include 'model/dbcon.php';
require_once 'model/User.php';
class UserController{
    private $db;
    public function login(){
        $email = $_POST['email'];
        $password = $_POST['password'];

        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);
        $res = $user->loginUser($email, $password);
        if($res == 'user'){
            $_SESSION['msg'] = 'Welcome, '. $_SESSION['email'];
            header('Location: userDashboard');
        }else if($res == 'admin'){
            $_SESSION['msg'] = "welcome : " . $_SESSION['admin'];
            header('Location: adminDashboard');
        }
        else {
            $_SESSION['msg'] = 'Invalid username or password';
            header('Location: login');
        }
    }
    public static function logout(){
        session_destroy();
        header('Location: home');
    }
    public function deposit(){
        $balance = $_POST['amount'] + $_SESSION['balance'];
        $id = $_SESSION['userId'];
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);
        if($user->updateValue($id, $balance, $_POST['amount'],"deposit")){
            $_SESSION['msg'] = "success";
            $lastId = $this->db->lastInsertId();
            $user->updateTransactionHistory("depositOrWithdraw", $lastId);
            $lastId = $this->db->lastInsertId();
            $user->joinUserAndTransaction($id,$lastId);
            $user->updateUserData($id);
            header('Location: userDashboard');
        } else {
            $_SESSION['msg'] = "failed";
            header('Location: userDashboard');
        }
    }
    public function withdraw(){
        if($_POST['amountWithdraw'] > $_SESSION['balance']){
            $_SESSION['msg'] = "failed";
            header('Location: userDashboard');
        }else if(isset($_POST['amountWithdraw']) && $_POST['amountWithdraw'] > 0){
            $balance = $_SESSION['balance'] - $_POST['amountWithdraw'];
            $_SESSION['newBalance'] = $_POST['amountWithdraw'];
            $id = $_SESSION['userId'];
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $pdo;
            $user = new User($this->db);
            if($user->updateValue($id,$balance,$_POST['amountWithdraw'],"withdraw")){
                $_SESSION['msg'] = "success";
                $lastId = $this->db->lastInsertId();
                $user->updateTransactionHistory("depositOrWithdraw", $lastId);
                $lastId = $this->db->lastInsertId();
                $user->joinUserAndTransaction($id,$lastId);
                $user->updateUserData($id);
                header('Location: userDashboard');
            } else {
                $_SESSION['msg'] = "failed";
                header('Location: userDashboard');
            }
        } else {
            $_SESSION['msg'] = "failed";
            header('Location: userDashboard');
        }

    }
    public function transfer(){
        $anotherUser = $_POST['anotheruser'];
        $amount = $_POST['amount'];
        $currentUserId = $_SESSION['userId'];
        if($currentUserId == $anotherUser){
            $_SESSION['msg'] = "failed";
            header('Location: userDashboard');
        }else{
            $pdo = Database::connect();
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->db = $pdo;
            $user = new User($this->db);
//        print_r($user->transfer($anotherUser,$currentUserId,$amount));
            if($user->transfer($anotherUser, $currentUserId, $amount)){
                $_SESSION['msg'] = "success";
                $lastId = $this->db->lastInsertId();
                $user->updateTransactionHistory("transfer", $lastId);
                $lastId = $this->db->lastInsertId();
                $user->joinUserAndTransaction($currentUserId,$lastId);
                $_SESSION['msg'] = "currentUs : " . $currentUserId . " anotherUser : " . $anotherUser . " amount : " . $amount;
                header('Location: userDashboard');
            } else {
                $_SESSION['msg'] = "failed";
                header('Location: userDashboard');
            }
        }

    }
    /*public function transferHis(){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);
        $currentUser = $_SESSION['userId'];
        $user->transUserHis($currentUser);
        header('Location: userDashboard');
    }*/
    public function retrieveData($userId,$startDate,$endDate){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);
        $user->retrieveUserData($userId,$startDate,$endDate);
        return true;
    }
    public function updateUser($userId, $username, $password, $email, $phone, $balance, $isDelete, $isDeactivate, $StateCode, $TownshipCode){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);

        if($user->updateUserinfo($userId, $username, $password, $email, $phone, $balance, $isDelete, $isDeactivate, $StateCode, $TownshipCode) == true){
            $_SESSION['msg'] = "success UpdateUserInfo : " . $userId;
            $user->retrieveUserData($userId,null,null);
            header('Location: adminDashboard');
        } else {
            $_SESSION['msg'] = "failed";
            header('Location: adminDashboard');
        }
    }
    public function register($username, $password, $email, $phone, $balance, $StateCode, $TownshipCode){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);
        if($user->registerUser($username, $password, $email, $phone, $balance, $StateCode, $TownshipCode)){
            $_SESSION['msg'] = "success";
            header('Location: adminDashboard');
            ob_flush();
        } else {
            $_SESSION['msg'] = "failed";
            header('Location: adminDashboard');
        }
    }
    public function contact($email,$phone){
        $pdo = Database::connect();
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->db = $pdo;
        $user = new User($this->db);
        if($user->userContact($email,$phone)){
            $_SESSION['msg'] = "success";
        } else {
            $_SESSION['msg'] = "failed";
        }
    }
}
