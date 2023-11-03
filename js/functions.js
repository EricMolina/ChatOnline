var urlWindow = "_";
var urlContact = "_";
document.addEventListener("DOMContentLoaded", function(event) { 
    urlParams = new URLSearchParams(window.location.search);
    var selectedOption = null;
    if (document.getElementsByClassName("chatonline-contacts-toggler-div-contacts") != null) {
        if (urlParams.get("window") != null) {
            urlWindow = urlParams.get("window");
            if (urlWindow == "requests") {
                selectedOption = document.getElementsByClassName("chatonline-contacts-toggler-div-requests")[0];
            }
            else {
                selectedOption = document.getElementsByClassName("chatonline-contacts-toggler-div-contacts")[0];
            }
        }
        selectedOption.style.backgroundColor = '#777777';
    }
}); //FALTA HACER EL urlContact - FALTA HACER EL urlContact - FALTA HACER EL urlContact

function ChangeToggler(page, data) {
    window.location.href = page + "?window=" + data + "&contact=" + urlContact;
}

function ChangeContact(page, data) {
    window.location.href = page + "?window=" + data + "&contact=" + urlContact;
}

function ValidateLogin() {
    var final = true;
    if (!CheckText("username"))
        final = false;
    if (!CheckText("pwd"))
        final = false;
    
    return final;
}

function ValidateRegister() {
    var final = true;
    if (!CheckText("username"))
        final = false;
    if (!CheckText("name"))
        final = false;
    if (!CheckText("pwd1"))
        final = false;
    if (!CheckText("pwd2"))
        final = false;
    if (!CheckPassword("pwd1", "pwd2"))
        final = false;
    
    return final;
}

function CheckText(id) { 
    valor = document.getElementById(id).value;
    if( valor == null || valor.length == 0 || /^\s+$/.test(valor) ) {
        document.getElementById(id + "_e").style.display = "inline";
        return false;
    }
    document.getElementById(id + "_e").style.display = "none";
    return true;
}

function CheckPassword(id1, id2) {
    if (document.getElementById(id1).value != document.getElementById(id2).value) {
        document.getElementById("pwdcheck_e").style.display = "inline";
        return false;
    }
    document.getElementById("pwdcheck_e").style.display = "none";
    return true;
}