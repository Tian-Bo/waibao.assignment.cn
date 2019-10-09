// 注册
function register() {
    let data = {
        name:"hanmeimei",
        age:88
    }
    var content = JSON.stringify(data);
    var blob = new Blob([content], {type: "text/plain;charset=utf-8"});
    saveAs(blob, "save.json");
}

// 登陆
function login(data) {
    alert('login')
}