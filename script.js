
let caesarkey = 3
let diffieKey

window.onload = () =>  {
    document.getElementById("loginform").addEventListener("submit", formsubmit);
}

function formsubmit (e) {
    e.preventDefault()
    
    let username = e.target.username.value
    let plainpassword = e.target.password.value

    rsa(plainpassword, username)
    //diffieHellman(plainpassword, username)
    //sendcaesar(plainpassword, username)

}

function verschluesseln (password) {

    let encryptedPassword = ""
    
    for (let i = 0; i < password.length; ++i) {
        let encryptedChar = String.fromCharCode(password.charCodeAt(i) + caesarkey)
        encryptedPassword += encryptedChar
    }

    return encryptedPassword
}

function sendcaesar(toencrypt, username) {
    let encryptedPassword = verschluesseln(toencrypt)

    console.log("encrypted: \n" + encryptedPassword)

    //mit jQuerry viel cooler...
    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "backend/login.php", true);
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

function diffieHellman(toencrypt, username) {
    /** 
     * p = prime, g < p                  -> public
     * a und b < p                       -> private
     * A=g^a mod p und B=g^b mod p       -> Ergebniss senden
     * key=B^a mod p und key=A^b mod p   -> beide Keys jetzt gleich und es kann los gehen!!!
    */

    //des tuat bled zio flitze
    let p = generatePrime(5000)                     //public
    let g = generatePrime(500)                      //public
    let a = Math.round((Math.random() * 100) + 2)     //private     //darf ahnscheindend nicht ueber 10 sonst faxen

    //let resToSend = (Math.pow(g, a))%p        //manchmahl villeicht NaN weil g^a = infinity....
    let resToSend = powMod(g, a, p)            //gonz wilde!!!


    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "backend/keyexchange.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            let response = this.responseText.split(" ")
            let B = parseInt(response[0]);
            diffieKey = powMod(B, a, p)
            //console.log("key von hier: " + key)
            //console.log("key von Server: " + response[1])

            sendMessage(toencrypt, username)
        }
    };

    let data = {p: p, g: g, A: resToSend};
    xhttp.send(JSON.stringify(data));

}

function powMod(x, y, p)
{
    // Initialize result
    let res = 1;
 
    // Update x if it is more
    // than or equal to p
    x = x % p;
 
    if (x == 0)
        return 0;
 
    while (y > 0)
    {
        // If y is odd, multiply
        // x with result
        if (y & 1)
            res = (res * x) % p;
 
        // y must be even now
         
        // y = $y/2
        y = y >> 1;
        x = (x * x) % p;
    }
    return res;
}

function generatePrime(howbig) {
    let obgefunden = false
    let p
    while(!obgefunden) {
        p = Math.round((Math.random() * howbig) + howbig/10);
        if (checkIfPrime(p)) {
            obgefunden = true
        }
    }
    return p
}

function checkIfPrime(tocheck) {
    let a = false;
    for (let i = 2; i < tocheck; i++) {
        if (tocheck%i===0) {
           a = true;
        }
    }

    return !a
}

function sendMessage(toencrypt, username) {

    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "backend/symetricLogin.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            let response = this.responseText
            console.log("Response: " + response)
        }
    };

    let data = {username: username, password: diffieencrypt(toencrypt)};
    xhttp.send(JSON.stringify(data));
}

function diffieencrypt(toencrypt) {
    let encrypted = toencrypt ^ diffieKey
    console.log("encrypted Password: " + encrypted)
    return encrypted
}

function rsa(toencrypt, username) {

    let xhttp = new XMLHttpRequest();
    xhttp.open('GET', 'backend/asymetricLogin.php?get=publicKey');
    xhttp.onload = function() {
        if (xhttp.status === 200) {
            let response = xhttp.responseText.split(" ")
            let e = response[0]
            let N = response[1]

            //console.log("Response: " + response)
            rsaSend(toencrypt, username, e, N)
        }
        else {
            console.log('Request failed.  Returned status of ' + xhttp.status);
        }
    };
    xhttp.send();

}

function rsaSend(toencrypt, username, e, N) {
    let rsaArray = []
    for (let i = 0; i < toencrypt.length; ++i) {
        let charCode = toencrypt.charCodeAt(i)
        let rsaed = powMod(charCode, e, N)
        rsaArray.push(rsaed)
    }
    //console.log(rsaArray) 


    let xhttp = new XMLHttpRequest();
    xhttp.open("POST", "backend/asymetricLogin2.php", true);
    xhttp.setRequestHeader("Content-Type", "application/json");
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Response
            let response = this.responseText
            console.log("Response: " + response)
        } else if (this.status != 200) {
            console.log("Post failed with status " + this.status)
        }
    };

    let data = {rsaArray: rsaArray, username: username};
    xhttp.send(JSON.stringify(data));
}