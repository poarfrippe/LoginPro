
window.onload = () =>  {
    console.log("hallo seppl")
    document.getElementById("loginform").addEventListener("submit", formsubmit);
}

function formsubmit (e) {
    e.preventDefault()
    
    console.log("imsubmitjs")

    let username = e.target.username.value
    let plainpassword = e.target.password.value

    //do iatz verschlüsseln und so...

    //mit jQuerry viel cooler...
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "dbCon/login.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            let response = this.responseText;
            console.log(response)
        }
    };

    let data = {username: username, password: plainpassword};
    xhttp.send(JSON.stringify(data));

}