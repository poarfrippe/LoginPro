
let caesarkey = 3

window.onload = () =>  {
    document.getElementById("loginform").addEventListener("submit", formsubmit);
}

function formsubmit (e) {
    e.preventDefault()
    
    let username = e.target.username.value
    let plainpassword = e.target.password.value

    let encryptedPassword = verschluesseln(plainpassword)
    
    console.log("encrypted: \n" + encryptedPassword)

    //mit jQuerry viel cooler...
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "dbCon/login.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            let response = this.responseText;
            console.log("decrypted: " + response)
        }
    };

    let data = {username: username, password: encryptedPassword};
    xhttp.send(JSON.stringify(data));

}

function verschluesseln (password) {

    let encryptedPassword = ""
    
    for (let i = 0; i < password.length; ++i) {
        let encryptedChar = String.fromCharCode(password.charCodeAt(i) + caesarkey)
        encryptedPassword += encryptedChar
    }

    return encryptedPassword
}