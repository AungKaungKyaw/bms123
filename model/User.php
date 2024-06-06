<?php
class User{
    private $email;
    private $username;
    private $password;
    private $balance;
    private $id;
    private $amount;
    private $pdo;
    private $transfer;
    private $withdraw;
    public function __construct($pdo){
        $this->pdo = $pdo;
    }
    public function loginUser($email, $password){
        $query = "SELECT * FROM useraccount WHERE username = :username and password = :password";
        $statement = $this->pdo->prepare($query);
//        email in statement represent $email
//        it will replace 'email' with $email
        $statement->execute([
            'username' => $email,
            'password' => $password
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result){
            $this->username = $result['username'];
            $this->email = $result['email'];
            $this->balance = $result['balance'];
            $_SESSION['username'] = $this->username;
            $_SESSION['email'] = $this->email;
            $_SESSION['login'] = true;
            $_SESSION['balance'] = $result['balance'];
            $_SESSION['userId'] = $result['userId'];
            $this->transUserHis($result['userId']);
            return "user";
        }else{
            $query = "SELECT * FROM admin WHERE name = :admin";
            $statement = $this->pdo->prepare($query);
//        email in statement represent $email
//        it will replace 'email' with $email
            $statement->execute([
                'admin' => $email
            ]);
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            if($result){
                $this->username = $result['name'];
                $_SESSION['admin'] = $result['name'];
                $_SESSION['login'] = true;
                $this->transUserHis('admin');
                return 'admin';
            }
        }
    }
    public function updateValue($id,$balance,$amount,$category){
        $this->id = $id;
        $this->amount = $amount;
        $date = date("Y-m-d H:i:s");
        try {
            $query = "UPDATE useraccount SET balance = :balance WHERE userId = :id";
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'balance' => $balance,
                'id' => $id
            ]);
            $this->history($id,$amount,$category,$date);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function updateValue2($id,$balance){
        try {
            $query = "UPDATE useraccount SET balance = :balance WHERE userId = :id";
            $_SESSION['msg5'] = "<br><br><br>UPDATE useraccount SET balance = $balance WHERE userId = $id";
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'balance' => $balance,
                'id' => $id
            ]);
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function history($id, $amount, $category, $date)
    {
        $_SESSION['msg'] = "inside history";
        $query = "INSERT INTO `withdrawdeposit` (`transHisId`, `category`, `amount`, `userid`, `date`) VALUES (NULL, :category, :amount, :userid, :date);";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'userid' => $id,
            'amount' => $amount,
            'category' => $category,
            'date' => $date
        ]);
        return true;
    }

    public function updateUserData($id){
        // inorder to update user data
        $query = "SELECT * FROM useraccount WHERE userId = :id";
        $statement = $this->pdo->prepare($query);
//        email in statement represent $email
//        it will replace 'email' with $email
        $statement->execute([
            'id' => $id,
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        if($result){
            $this->balance = $result['balance'];
            $_SESSION['balance'] = $result['balance'];
            return true;
        }
    }
    public function findUser($id){
        $query = "SELECT * FROM useraccount WHERE userId = :id";
        $statement = $this->pdo->prepare($query);
//        email in statement represent $email
//        it will replace 'email' with $email
        $statement->execute([
            'id' => $id,
        ]);
        $result = $statement->fetch(PDO::FETCH_ASSOC);
        return $result;
    }
    public function transfer($anotherUser, $currentUser, $amount){
        $_SESSION['msg3'] = "anotherUser : $anotherUser currentUser : $currentUser amount : $amount";
        $query = "SELECT userId, username, balance FROM useraccount WHERE userId in (:anotherUser,:currentUser);";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'anotherUser' => $anotherUser,
            'currentUser' => $currentUser
        ]);
        $result = $statement->fetchall(PDO::FETCH_ASSOC);
//        0 is for current user
//        1 is for another user
        $_SESSION['msg4'] = "first user : " . $result[0]['userId'] . " second user : " . $result[1]['userId'];
        if((int)$result[0]['balance'] < (int)$amount){
            return false;
        }else{
            $currentUserNewBalance = (int)$result[0]['balance'] - (int)$amount;
            $anotherUserNewBalance = (int)$result[1]['balance'] + (int)$amount;
            $this->updateValue2($result[0]['userId'],$currentUserNewBalance);
            $this->updateValue2($result[1]['userId'],$anotherUserNewBalance);
            $this->transferHistory($anotherUser, $amount, $currentUser, date("Y-m-d H:i:s"));
            return true;
        }
//        return $return;
    }
    public function transferHistory($receiverUserId, $amount, $currentUserId, $date){
        $query = "INSERT INTO `transferhistory` (`transferId`, `currentUserId`, `receiverUserId`, `amount`, `date`) VALUES (NULL, :currentUserId, :receiverUserId, :amount, :date);";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'currentUserId' => $currentUserId,
            'receiverUserId' => $receiverUserId,
            'amount' => $amount,
            'date' => $date
        ]);

        $_SESSION['msg2'] = "<br><br><br>transhisoty :INSERT INTO `transferhistory` (`transferId`, `currentUserId`, `receiverUserId`, `amount`, `date`) VALUES (NULL, $currentUserId, $receiverUserId, $amount, :date)<br><br><br>";
    }
    public function updateTransactionHistory($desc,$id){
        if($desc == "depositOrWithdraw"){
            $query = "INSERT INTO `transactionhistory` (`id`, `withdrawOrDepositId`, `transferId`) VALUES (NULL, :id, NULL);";
        }else if($desc == "transfer"){
            $query = "INSERT INTO `transactionhistory` (`id`, `withdrawOrDepositId`, `transferId`) VALUES (NULL, NULL, :id );";
        }
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'id' => $id
        ]);
    }
    public function joinUserAndTransaction($userId, $transactionId){
        $query = "INSERT INTO `userandtransaction` (`id`, `userId`, `transactionId`) VALUES (NULL, :userId, :transactionId);";
        $statement = $this->pdo->prepare($query);
        $statement->execute([
            'userId' => $userId,
            'transactionId' => $transactionId
        ]);
    }

/*select
    uat.transactionId,
th.id,
th.withdrawOrDepositId,
th.transferId,
t.amount,
t.receiverUserId,
ua.username,
wd.category
from userandtransaction as uat
left join transactionhistory as th on uat.transactionId = th.id
left join transferhistory as t on th.transferId = t.transferId
left join useraccount as ua on t.receiverUserId = ua.userId
left join withdrawdeposit as wd on th.withdrawOrDepositId = wd.transHisId
where uat.userId = :currentUser*/
    public function transUserHis($currentUser){
        if($currentUser == 'admin'){
            $query = "select
uat.transactionId,
t.amount as transferAmount,
wd.amount as withdrawOrDepositAmount,
uat.userId,
uac2.username,
ua.username as receiverUser,
wd.category as withdrawOrDeposit,
t.date as transferDate,
wd.date as wdDate
from userandtransaction as uat
         left join transactionhistory as th on uat.transactionId = th.id
         left join transferhistory as t on th.transferId = t.transferId
         left join useraccount as ua on t.receiverUserId = ua.userId
         left join useraccount uac on t.currentUserId = uac.userId
         left join useraccount uac2 on uat.userId = uac2.userId
         left join withdrawdeposit as wd on th.withdrawOrDepositId = wd.transHisId
order by uat.id desc limit 10";
            $statement = $this->pdo->prepare($query);
            $statement->execute();
            $result = $statement->fetchall(PDO::FETCH_ASSOC);
        }
        else {
            $query = "select
    t.amount as transferAmount,
    ua.username as username,
    t.date as transferDate,
    wd.amount as withdrawOrDepositAmount,
    wd.category as withdrawOrDeposit,
    wd.date as wdDate
from userandtransaction as uat
    left join transactionhistory as th on uat.transactionId = th.id
    left join transferhistory as t on th.transferId = t.transferId
    left join useraccount as ua on t.receiverUserId = ua.userId
    left join withdrawdeposit as wd on th.withdrawOrDepositId = wd.transHisId
where uat.userId = :currentUser;";
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'currentUser' => $currentUser
            ]);
            $result = $statement->fetchall(PDO::FETCH_ASSOC);
            /*if(!empty($result)){
                foreach ($result as $row){
                    if($row['transferAmount'] != null){
                        array_push($this->transfer, $row['transferAmount']);
                        array_push($this->transfer, $row['username']);
                    }
                    if($row['withdrawOrDepositAmount'] != null){
                        array_push($this->transfer, $row['withdrawOrDepositAmount']);
                        array_push($this->transfer, $row['withdrawOrDeposit']);
                    }
                }
            }
            $json_date = json_encode($this->transfer);
            $_SESSION['msg4'] = $json_date;*/

//        $_SESSION['msg4'] = json_encode($result);
            /**
             * array_filter
             * https://stackoverflow.com/questions/3654295/remove-empty-array-elements
             */
//        $data = array_filter($result, fn($value) => !is_null($value) && $value !=='');
            /*$data = array_filter($result, function($value){
                return $value == null;
            });*/

        }
        foreach ($result as &$item) {
            $item = array_filter($item, function ($value) {
                return $value !== null;
            });
        }

        $_SESSION['msg1'] = "something went is wrong";
        $_SESSION['msg2'] = json_encode($result);
    }
    public function retrieveUserData($userId,$startDate,$endDate){
//        fetch user data only startdate and enddate not include
        if($startDate == null && $endDate == null){
            $query = "select * from useraccount where userId = :currentUser";
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'currentUser' => $userId
            ]);
            $result = $statement->fetchall(PDO::FETCH_ASSOC);
            foreach ($result as &$item) {
                $item = array_filter($item, function ($value) {
                    return $value !== null;
                });
            }
            $_SESSION['msg6'] = json_encode($result);
        }else if(!empty($userId) && !empty($startDate) && !empty($endDate)){
//            fetch user's transaction from startDate to End date
            $query = "select
    th.id,
    t.amount as transferAmount,
    wd.amount as withdrawOrDepositAmount,
    ua2.userId,
    ua2.username as username,
    ua.username as receiverUser,
    wd.category as withdrawOrDeposit,
    t.date as transferDate,
    wd.date as wdDate
from userandtransaction as uat
         left join transactionhistory as th on uat.transactionId = th.id
         left join transferhistory as t on th.transferId = t.transferId
         left join useraccount as ua on t.receiverUserId = ua.userId
         left join useraccount as ua2 on uat.userId = ua2.userId
         left join withdrawdeposit as wd on th.withdrawOrDepositId = wd.transHisId where uat.userId = :userId and ( (t.date between :startDate and :endDate) or (wd.date between :startDate and :endDate) )";
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'userId' => $userId,
                'startDate' => $startDate,
                'endDate' => $endDate
            ]);
            $result = $statement->fetchall(PDO::FETCH_ASSOC);
            foreach ($result as &$item) {
                $item = array_filter($item, function ($value) {
                    return $value !== null;
                });
            }
            $_SESSION['msg4'] = json_encode($result);
        }
    }
    public function updateUserinfo($userId, $username, $password, $email, $phone, $balance, $isDelete, $isDeactivate, $StateCode, $TownshipCode){
        $query = "update useraccount
set username = :username ,password = :password, email = :email, phone = :phone,
    balance = :balance,isDelete = :isDelete,isDeactivate = :isDeactivate,
    StateCode = :StateCode,TownshipCode = :TownshipCode
where userId = :userId";
        try{
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'userId' => $userId,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'phone' => $phone,
                'balance' => $balance,
                'isDelete' => $isDelete,
                'isDeactivate' => $isDeactivate,
                'StateCode' => $StateCode,
                'TownshipCode' => $TownshipCode
            ]);
            return true;
        }catch(PDOException $e){
            echo "Error : updating user information : ".$e->getMessage();
        }
    }
    public function registerUser($username, $password, $email, $phone, $balance, $StateCode, $TownshipCode){
        $query = "insert into useraccount (username, password, email, phone, balance, isDelete, isDeactivate, StateCode, TownshipCode) values (:username, :password, :email, :phone, :balance, :isDelete, :isDeactivate, :StateCode, :TownshipCode)";
        try{
            $statement = $this->pdo->prepare($query);
            $statement->execute([
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'phone' => $phone,
                'balance' => $balance,
                'isDelete' => 0,
                'isDeactivate' => 0,
                'StateCode' => $StateCode,
                'TownshipCode' => $TownshipCode
            ]);
            return true;
        }catch(PDOException $e){
            echo "Error : registering user information : ".$e->getMessage();
        }
    }
}
