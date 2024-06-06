<?php
require 'includes/__header.php';
require 'includes/sidebar.php';
/*if(isset($_SESSION['msg'])){
    echo $_SESSION['msg'];
    echo "<br>";
    unset($_SESSION['msg']);
    echo "<br>";
}*/
/*if(isset($_SESSION['msg1'])){
    echo $_SESSION['msg1'];
    echo "asdf<br>";
    unset($_SESSION['msg1']);
    echo "<br>";
}*/
/*if(isset($_SESSION['msg2'])){
    echo $_SESSION['msg2'];
    echo "asdf<br>";

}*/


?>
<div class="userRightbar">
    <div class="userDescription">
        <h1>Dashboard</h1>
        <p class="balanceCaption">balance</p>
        <p class="balance"><?php echo $_SESSION['balance'] ?></p>
        <p><button id="transaction">Transaction</button></p>
        <p><button id="deposit">Deposit</button></p>
        <p><button id="withdraw">Withdraw</button></p>
        <p><button id="transfer">Transfer</button></p>
        <p><button id="myAccount">MyAccount</button></p>
    </div>
    <div class="">
        <div class="transactionHistory">
            <div class="toShow show" id="transactionHistory">
                    <table>
                        <thead>
                        <tr>
                            <th>transferAmount</th>
                            <th>ReceiverName</th>
                            <th>Date</th>
                            <th>Category</th>
                        </tr>
                        </thead>
                        <tbody id="tbody">
                        <script>
                            var data = [];
                            console.log("hello");
                            data = <?php print_r($_SESSION['msg2']) ?>;
                            console.log(data.length);

                            data.forEach(function(rowData){
                                const row = document.createElement('tr');
                                for (let key in rowData) {
                                    console.log("key : " + key + " value : " + rowData[key]);
                                    const td = document.createElement('td');
                                    td.innerText = rowData[key];
                                    row.appendChild(td);
                                    if(key == 'transferDate'){
                                        const td = document.createElement('td');
                                        td.innerText = rowData[key];
                                        row.appendChild(td);
                                        td.innerText = "transfer";
                                        row.appendChild(td);
                                    }
                                    if(key == 'wdDate'){
                                        const td = document.createElement('td');
                                        td.innerText = rowData[key];
                                        row.appendChild(td);
                                        td.innerText = "DepositOrWithdraw";
                                        row.appendChild(td);
                                    }
                                }
                                document.getElementById('tbody').appendChild(row);
                                console.log("-----------");
                            })

                        </script>

                        </tbody>
                    </table>
            </div>
            <div  class="toShow hide">
                <form action="deposit" class="depositForm" method="post">
                    <input name="amount" type="number" placeholder="Amount to Deposit"><br>
                    <input type="text" placeholder="<?php echo $_SESSION['username']; ?>">
                    <button type="submit">click here</button>
                </form>
            </div>
            <div id="withdrawForm" class="toShow hide">
                <form action="withdraw" class="depositForm" method="post">
                    <input name="amountWithdraw" type="number" placeholder="Amount to withdraw"><br>
                    <input type="text" placeholder="<?php echo $_SESSION['username']; ?>">
                    <button type="submit">click here</button>
                </form>
            </div>
            <div id="transferForm" class="toShow hide">
                <form action="transfer" class="depositForm" method="post">
                    <input id="anotherUserId" type="number" name="anotheruser" placeholder="enter another user's id">
                    <input type="number" name="amount" placeholder="enter amount">
                    <p id="checkUserbtn">click here to check user</p>
                    <p id="anotherUserName">another user will apear herer</p>
                    <button type="submit">submit</button>
                </form>
            </div>
            <div id="transition" class="toShow hide">
                <br>
                <p>name - <?php echo $_SESSION['username'] ?></p><br>
                <p>email - <?php echo $_SESSION['email'] ?></p><br>
                <p>balance - <?php echo $_SESSION['balance'] ?></p><br>
            </div>
        </div>
    </div>
</div>
</div>

<?php
require 'includes/__footer.php';

?>
