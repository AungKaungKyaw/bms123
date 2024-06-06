<?php
require 'includes/__header.php';
require 'includes/sidebar.php';
include 'Controller/UserController.php';
/*if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    unset($_SESSION['msg']);
}*/
/*if(isset($_SESSION['msg6'])){
    echo $_SESSION['msg6'];
    unset($_SESSION['msg6']);
}*/
/*if(isset($_SESSION['msg4'])){
    echo $_SESSION['msg4'];
    unset($_SESSION['msg4']);
}*/
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])){

        $userID = $_POST['userId'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];

        $user = new UserController();
        $data = $user->retrieveData($userID, $startDate, $endDate);
    }
    if(isset($_POST['update'])){
        echo "asdf";
        $userId = $_POST['userId'];
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $phone = $_POST['phone'];
        $balance = $_POST['balance'];
        $isDelete = $_POST['isDelete'];
        $isDeactivate = $_POST['isDeactivate'];
        $StateCode = $_POST['StateCode'];
        $TownshipCode = $_POST['TownshipCode'];

        echo "userid : " . $userId;
        $user = new UserController();
        $user->updateUser($userId, $username, $password, $email, $phone, $balance, $isDelete, $isDeactivate, $StateCode, $TownshipCode);
    }

}

?>
<div class="userRightbar">
    <div class="adminFormDiv">
        <form method="post" class="adminForm">
            <input type="number" placeholder="userid" name="userId">
            <label>start</label>
            <input type="date" name="startDate">
            <label>end</label>
            <input type="date" name="endDate">
            <button type="submit" name="submit" value="submit">submit</button>
        </form>
    </div>
    <div class="tableDiv">
        <form method="post" action="">
            <table class="adminTable">
                <thead id="adminThead">
                <tr>
                    <th>transactionId</th>
                    <th>Amount</th>
                    <th>UserId</th>
                    <th>Username</th>
                    <th>Category</th>
                    <th>receiverName</th>
                    <th>Date</th>
                </tr>
                </thead>
                <tbody id="adminTbody">

                    <script>
                        var data = [];
                        data = <?php print_r($_SESSION['msg4']) ?>;
                        if(data != null){
                            document.getElementById('adminTbody').innerHTML='';
                            data.forEach(function(rowData){
                                const row = document.createElement('tr');
                                console.log("asdfasdfasfsdafsdfsdf");
                                for (let key in rowData) {
                                    const td = document.createElement('td');
                                    if(key == 'receiverUser'){
                                        const td2 = document.createElement('td');
                                        td2.innerText = 'transfer';
                                        row.appendChild(td2);
                                        td.innerText = rowData[key];
                                        row.appendChild(td);
                                    }else if(key == 'wdDate'){
                                        const td2 = document.createElement('td');
                                        td2.innerText = ' - ';
                                        row.appendChild(td2);
                                        td.innerText = rowData[key];
                                        row.appendChild(td);
                                    }
                                    else{
                                        td.innerText = rowData[key];
                                        row.appendChild(td);
                                    }
                                }
                                document.getElementById('adminTbody').appendChild(row);
                            })
                        }
                    </script>
                </tbody>
            </table>
            <button type="submit" name="update" value="update" id="submitButton" class="hide">submit</button>
        </form>
    </div>
</div>
</div>
<script>

    // for user history
    var data2 = [];
    data2 = <?php if(isset($_SESSION['msg5'])){
        print_r($_SESSION['msg5']);
    }else{
        echo "null";
    } ?>;
    console.log(data2);
    if(data2 != null){
        console.log("inside msg 5");
        const tbody = document.getElementById('adminTbody');
        tbody.innerHTML='';
        data2.forEach(function(rowData){
            const row = document.createElement('tr');
            console.log('inside data 2');
            console.log(rowData);
            for (let key in rowData) {
                const td = document.createElement('td');
                if(key == 'receiverUser'){
                    const td2 = document.createElement('td');
                    td2.innerText = 'transfer';
                    row.appendChild(td2);
                    td.innerText = rowData[key];
                    row.appendChild(td);
                }else if(key == 'wdDate'){
                    const td2 = document.createElement('td');
                    td2.innerText = ' - ';
                    row.appendChild(td2);
                    td.innerText = rowData[key];
                    row.appendChild(td);
                }
                else{
                    td.innerText = rowData[key];
                    row.appendChild(td);
                }
            }
            document.getElementById('adminTbody').appendChild(row);
        })
    }

    // find userid and update user info
    var data3 = [];
    data3 = <?php if(isset($_SESSION['msg6'])){
        print_r($_SESSION['msg6']);
    } ?>;
    console.log("data3 : ");
    function updateInputDataInjs(){
        const tbody = document.getElementById('adminTbody');
        const thead = document.getElementById('adminThead');
        thead.innerHTML = '';
        tbody.innerHTML = '';
        /*const form = document.createElement('form');
        form.setAttribute('method', 'post');
        document.getElementById('adminTbody').appendChild(form);*/
        data3.forEach(function (rowData) {
            const row = document.createElement('tr');
            const rowbody = document.createElement('tr');
            for(let key in rowData){
                const th = document.createElement('th');
                th.innerText = key;
                row.appendChild(th);
            }
            for(let key in rowData){
                const td = document.createElement('td');
                const input = document.createElement('input');
                rowbody.appendChild(td);
                if(key == 'userId'){
                    input.setAttribute('type','number');
                    input.setAttribute('name',key);
                    input.setAttribute('value',rowData[key]);
                    input.setAttribute('readonly','true');
                    input.classList.add('inputWidth');
                    td.appendChild(input);
                    continue;
                }
                td.innerText = '';
                input.setAttribute('type','text');
                input.setAttribute('name',key);
                input.setAttribute('value',rowData[key]);
                input.classList.add('inputWidth');
                td.appendChild(input);
            }
            document.getElementById('adminThead').appendChild(row);
            document.getElementById('adminTbody').appendChild(rowbody);
        });

    }
    if(data3 != null) {
        document.getElementById('submitButton').classList.remove('hide');
        document.getElementById('submitButton').classList.add('show');
        updateInputDataInjs();
    }
</script>

<?php
require 'includes/__footer.php';

?>
