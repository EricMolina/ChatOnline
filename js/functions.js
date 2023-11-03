var urlWindow = "contacts";
document.addEventListener("DOMContentLoaded", function(event) { 
    urlParams = new URLSearchParams(window.location.search);
    var selectedOption = null;
    if (document.getElementsByClassName("chatonline-contacts-toggler-div-contacts") != null) { //we are on index.php
        selectedOption = document.getElementsByClassName("chatonline-contacts-toggler-div-contacts")[0];
        if (urlParams.get("window") != null) {
            urlWindow = urlParams.get("window");
            if (urlWindow == "requests") {
                selectedOption = document.getElementsByClassName("chatonline-contacts-toggler-div-requests")[0];
            }
        }
        selectedOption.style.backgroundColor = '#777777';
        selectedOption.style.boxShadow = "inset 0px 0px 10px rgba(0, 0, 0, 0.5)";

        if (document.getElementById("contact_id") != null) {
            document.getElementsByClassName("chatonline-chat-chat")[0].style.display = "flex";
            document.getElementsByClassName("chatonline-chat-nochat")[0].style.display = "none";
        } else {
            document.getElementsByClassName("chatonline-chat-chat")[0].style.display = "none";
            document.getElementsByClassName("chatonline-chat-nochat")[0].style.display = "flex";
        }
    }
});

function ChangeToggler(data) {
    window.location.href = 'index.php' + "?window=" + data;
}

function ChangeContact(id) {
    document.getElementById("contact_field").value = id;
    document.getElementById('form_contact_field').submit();
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