
const tranHis = document.getElementById("transactionHistory");

const toshow = document.querySelectorAll('.toShow');
let userDescription = document.querySelector('.userDescription').children;


for(let i = 3; i < 8; i++){
    userDescription[i].addEventListener('click',function () {
        toshow.forEach(function (row){
            row.classList.remove('show');
            row.classList.add('hide');
        })
        toshow[i-3].classList.remove('hide');
        toshow[i-3].classList.add('show');
    })
}
function reqData(id, action, callback){
    const xhr = new XMLHttpRequest();
    const url = 'http://127.0.0.1:8000/Controller/phpreq.php';
    xhr.open('POST',url);
    xhr.onreadystatechange = function (){
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // console.log("xhr.responseText");
                // console.log(xhr.responseText);
                callback(xhr.responseText);
                // callback(JSON.parse(xhr.responseText));
                // callback = JSON.parse(xhr.responseText);
            } else {
                console.error("request fail: " + xhr.status);
                callback(null, "request fail : " + xhr.status)
            }
        }
    }
    let jsonData = JSON.stringify({
        id: id,
        action: action
    })
    // console.log(jsonData);
    xhr.send(jsonData);
}
const btn = document.getElementById('checkUserbtn');
btn.addEventListener('click',()=>{
    const input = document.getElementById('anotherUserId');
    reqData(input.value,'checkUser',(data)=>{
        document.getElementById('anotherUserName').innerText = data;
    })
})
window.onload = function(){
    reqData(0,'update',function(data){
        data = JSON.parse(data);
        console.log(data);
        userRequestList(data);
        addlisten();
    })
}