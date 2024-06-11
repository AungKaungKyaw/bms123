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
if(isset($_SESSION['error'])){
    echo $_SESSION['error'];
    unset($_SESSION['error']);
}
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    if(isset($_POST['submit'])){

        $userID = $_POST['userId'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $user = new UserController();
        $data = $user->retrieveData($userID, $startDate, $endDate);
        if($data){
            echo "<script>resetForm();</script>";
        }
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

        $user = new UserController();
        $user->updateUser($userId, $username, $password, $email, $phone, $balance, $isDelete, $isDeactivate, $StateCode, $TownshipCode);
    }
}
?>
<div class="userRightbar">
    <div class="adminFormDiv">
        <p class="note">Note : enter userid to see user's details</p>
        <p class="note">Note : enter userid, start date and end date to see user's transaction from start to end</p>
        <form method="post" class="adminForm" id="adminForm">
            <input type="number" placeholder="userid" name="userId">
            <label>start</label>
            <input type="date" name="startDate" id="sdate">
            <label>end</label>
            <input type="date" name="endDate" id="edate">
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
                    data = <?php print_r($_SESSION['msg2']) ?>;
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
    <div class="userRequest">
        <h2 style="padding: 20px 0px;margin:20px 0px;">User request list</h2>
        <p class="note">Note : where user request to contact them</p>
        <p class="note">Note : click delete after contact</p>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>email</th>
                <th>phone</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            </thead>
            <tbody id="userRequestTbody">

            </tbody>
        </table>

        <div id="something"></div>
    </div>

</div>
</div>
<script>

    function userRequestList(data){
        document.getElementById('userRequestTbody').innerHTML = '';
        data.forEach(function(item){
            const tr = document.createElement('tr');
            const button = document.createElement('button');
            button.classList.add('btn','delbtn');
            button.textContent = 'Delete';
            for (let key in item) {
                const td = document.createElement('td');
                td.textContent = item[key];
                tr.appendChild(td);
                tr.appendChild(button);
            }
            document.getElementById('userRequestTbody').appendChild(tr);
        });
    }
    function addlisten(){
        document.querySelectorAll('.delbtn').forEach(function(item){
            item.addEventListener('click',function(){
                let val = item.parentNode;
                let value = parseInt(val.childNodes[0].textContent);
                console.log(value);
                reqData(value, 'delete', function(data){
                    userRequestList(JSON.parse(data));
                })
            })
        })
    }

    function resetForm(){
        document.getElementById('sdate').value='';
        document.getElementById('edate').value='';
    }
    resetForm();
    // for user history
    var data2 = [];
    data2 = <?php if(isset($_SESSION['msg4'])){
        print_r($_SESSION['msg4']);
        unset($_SESSION['msg4']);
    }else{
        echo "null";
    } ?>;
    console.log(data2);
    if(data2 != null){
        console.log("inside msg 5");
        const tbody = document.getElementById('adminTbody');
        tbody.innerHTML='';
        console.log("tbody.innerHTML : ");
        console.log(tbody.innerHTML);
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
        });
    }
</script>
<script>
    // find userid and update user info
    var data3 = [];
    data3 = <?php if(isset($_SESSION['msg6'])){
        print_r($_SESSION['msg6']);
        unset($_SESSION['msg6']);
    }else{
        echo "null";
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
