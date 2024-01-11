
function loadContacts() {
    let ajax = new XMLHttpRequest();
    ajax.open('GET', './proc/load_contacts.php');

    ajax.onload = () => {
        let contactsContainer = document.getElementById('chatonline-contacts-container');
        contactsContainer.innerHTML = '';

        let data = JSON.parse(ajax.responseText);

        data.forEach(contact => {
            if (contact.last_message_content) {
                lastMessageContent = contact.last_message_content.length <= 15 ?
                    contact.last_message_content : contact.last_message_content.substring(0, 15) + "...";
            } else {
                lastMessageContent = '';
            }

            contactsContainer.innerHTML += `
                <div onclick="changeCurrentContact(${contact.friend_ship_user_id})" class="column column-1 chatonline-contacts-contact">
                    <div class="row">
                        <div class="column column-30 chatonline-contacts-contact-hide-column">
                            <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                        </div>
                        <div class="column column-60">
                            <h1>${contact.friend_ship_username}</h1>
                            <p style="opacity: 60%">${lastMessageContent}</p>
                        </div>
                        <div class="column column-10 chatonline-contacts-contact-hide-column">
                            <h2>${(contact.last_message_date ? contact.last_message_date : '')}</h2>
                        </div>
                    </div>
                </div>`;
        });
    }

    ajax.send()
}


function loadSearchedUsers() {
    let searchedUser = document.getElementById('searched_user').value

    let ajax = new XMLHttpRequest();
    ajax.open('GET', `./proc/search_users.php?searched_user=${searchedUser}`);

    ajax.onload = () => {
        let contactsContainer = document.getElementById('chatonline-contacts-container');
        contactsContainer.innerHTML = '';

        let data = JSON.parse(ajax.responseText);

        data.forEach(user => {
            userContent = `
                <div class="column column-1 chatonline-contacts-contact" onclick="`;

            if (user.is_friend) {
                userContent += "removeFriend(" + user.id + ")";
            } else if (!user.has_request) {
                userContent += "sendFriendshipRequest(" + user.id + ")";
            }

            userContent += `"><div class="row">
                    <div class="column column-30 chatonline-contacts-contact-hide-column">
                        <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                    </div>
                    <div class="column column-2">
                        <h1>${user.username}</h1>
                        
            `;

            if (user.is_friend) {
                userContent += `
                    <p class="chatonline-contacts-contact-request-text">Remove contact</p>
                `
            } else if (user.has_request) {
                userContent += `
                    <p class="chatonline-contacts-contact-request-text">Pending request</p>
                `
            } else {
                userContent += `
                    <p class="chatonline-contacts-contact-request-text">Send request</p>
                `
            }

            userContent += `
                </div>
                    <div class="column column-5 chatonline-contacts-contact-hide-column">
            `;

            if (user.is_friend) {
                userContent += `
                    <img src="./img/user_del.png" alt="logo" class="chatonline-contacts-contact-request-button">
                `
            } else if (user.has_request) {
                userContent += `
                    <img src="./img/user_req.png" alt="logo" class="chatonline-contacts-contact-request-button">
                `
            } else {
                userContent += `
                    <img src="./img/user_add.png" alt="logo" class="chatonline-contacts-contact-request-button">
                `
            }

            userContent += `
                    </div>
                </div>
            </div>`;

            contactsContainer.innerHTML += userContent
        });
    }

    ajax.send()
}


function loadFriendshipRequests() {
    let ajax = new XMLHttpRequest();
    ajax.open('GET', './proc/load_friendship_requests.php');

    ajax.onload = () => {
        let contactsContainer = document.getElementById('chatonline-contacts-container');
        contactsContainer.innerHTML = '';

        let data = JSON.parse(ajax.responseText);

        data.forEach(request => {
            contactsContainer.innerHTML += `<div class="column column-1 chatonline-contacts-contact" style="cursor: default;">
                <div class="row">
                    <div class="column column-30 chatonline-contacts-contact-hide-column">
                        <img src="./img/user.png" alt="logo" class="chatonline-contacts-contact-icon chatonline-svg-white">
                    </div>
                    <div class="column column-2">
                        <h1>${request.user_sender}</h1>
                    </div>
                    <div class="" style="float: left; width: 110px; height: 100px;">
                        <img src="./img/check.png" onclick="respondFriendshipRequest(${request.request_id}, 'accept')"
                            alt="logo" class="chatonline-contacts-contact-requests-button" style="cursor: pointer;">
                        <img src="./img/cross.png" onclick="respondFriendshipRequest(${request.request_id}, 'reject')"
                            alt="logo" class="chatonline-contacts-contact-requests-button" style="cursor: pointer;">
                    </div>
                </div>
            </div>`;
        });
    }

    ajax.send()
}


function loadContactMessages(contactId) {
    let ajax = new XMLHttpRequest();
    ajax.open('GET', `./proc/load_contact_messages.php?contact=${contactId}`);

    ajax.onload = () => {
        let messagesContainer = document.getElementById('chatonline-messages-container');
        messagesContainer.innerHTML = '';

        let data = JSON.parse(ajax.responseText);
        let loggedUserId = data.logged_user_id;
        document.getElementById('current_contact_username').textContent = data.contact_username;
        document.getElementById('contact_friend_ship').value = data.contact_friendship_id;

        data.contact_messages.forEach(message => {
            let messageSender = message.id_user_sender == loggedUserId ? 'msg-sent' : 'msg-received';

            messageContent = `<div class="chatonline-chat-chat-content-message ${messageSender}">`;

            if (message.image && message.image != "") {
                let a = message.image.split('.');
                let extension = a[a.length - 1];
                if (['jpg', 'jpeg', 'png', 'gif'].includes(extension)) {
                    messageContent += `<img class="chatonline-chat-chat-content-image"
                        src="${message.image}" alt="image">`;
                } else {
                    messageContent += `<video class="chatonline-chat-chat-content-image" controls> 
                        <source src="${message.image}" type="video/mp4"> 
                    </video> `;
                }
            }

            messageContent += `
                <span class="chatonline-chat-chat-message-text">
                    ${message.content}
                </span>
                <span class="chatonline-chat-chat-timestamp">
                    ${message.message_datetime}
                </span>
            </div>`;

            messagesContainer.innerHTML += messageContent;

            lastMsgID = message.id;
        });

        actualFriendshipID = data.contact_friendship_id;
        actualContactID = contactId;

        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        CheckActualMessages();
    }

    ajax.send()
}

let lastMsgID = 0;
let actualFriendshipID = 0;
let actualContactID = 0;
let checkLastMessageLoop;
function CheckActualMessages() {
    clearInterval(checkLastMessageLoop);

    checkLastMessageLoop = setInterval(() => {
        var ajax = new XMLHttpRequest();
        var formData = new FormData();
        formData.append("id_friendship", actualFriendshipID)
        ajax.open("POST", "./proc/check_last_message.php");

        ajax.onload = function () {
            if (ajax.status == 200) {
                if (lastMsgID != parseInt(ajax.responseText)) {
                    console.log("mensaje diferente: " + lastMsgID + " - " + ajax.responseText + " - " + actualFriendshipID);
                    loadContactMessages(actualContactID);
                } else {
                    console.log("mensaje igual: " + lastMsgID + " - " + ajax.responseText + " - " + actualFriendshipID);
                }
            }
        }
        ajax.send(formData);
    }, 500);
}


function sendFriendshipRequest(userId) {
    let ajax = new XMLHttpRequest();
    ajax.open('GET', `./proc/send_friend_request.php?id_user=${userId}`);

    ajax.onload = () => {
        loadSearchedUsers();
    }

    ajax.send()
}


function removeFriend(userId) {
    let ajax = new XMLHttpRequest();
    ajax.open('GET', `./proc/remove_friend.php?id_user=${userId}`);

    ajax.onload = () => {
        loadSearchedUsers();
    }

    ajax.send()
}


function respondFriendshipRequest(requestId, response) {
    let ajax = new XMLHttpRequest();
    ajax.open('GET', `./proc/respond_friend_request.php?request_id=${requestId}&response=${response}`);

    ajax.onload = () => {
        loadFriendshipRequests();
    }

    ajax.send()
}


function sendMessage() {
    let ajax = new XMLHttpRequest();
    ajax.open('POST', `./proc/send_message.php`);

    var form = document.getElementById('message-form')
    var formdata = new FormData(form);

    ajax.onload = () => {
        loadContactMessages(formdata.get('contact'));
        loadContacts();
        document.getElementById('msg-content').value = '';
        document.getElementById('msg_file').value = '';
        document.getElementById("_chatonline-chat-chat-footer-images").innerHTML = '';
    }

    if (formdata.get('msg') != '') {
        ajax.send(formdata);
    }
}


function changeCurrentContact(contactId) {
    document.getElementById('contact_field_send_msg').value = contactId;
    displayChatLayout()
    loadContactMessages(contactId)
}


function toggleSelectedTab(e) {
    e.currentTarget.style.backgroundColor = '#777777';
    e.currentTarget.style.boxShadow = "inset 0px 0px 10px rgba(0, 0, 0, 0.5)";

    if (e.currentTarget.id == 'toggle_requests') {
        document.getElementById('toggle_contacts').style.backgroundColor = 'rgb(168, 168, 168)';
        document.getElementById('toggle_contacts').style.boxShadow = 'none';
    } else {
        document.getElementById('toggle_requests').style.backgroundColor = 'rgb(168, 168, 168)';
        document.getElementById('toggle_requests').style.boxShadow = 'none';
    }
}


function displayChatLayout() {
    document.getElementsByClassName("chatonline-chat-chat")[0].style.display = "flex";
    document.getElementsByClassName("chatonline-chat-nochat")[0].style.display = "none";
}


window.onload = () => {
    loadContacts()
    document.getElementById('toggle_contacts').style.backgroundColor = '#777777';
    document.getElementById('toggle_contacts').style.boxShadow = "inset 0px 0px 10px rgba(0, 0, 0, 0.5)";

    document.getElementById('searched_user_button').addEventListener('click', () => {
        loadSearchedUsers();
        document.getElementById('current_tab').textContent = 'ALL USERS';
    })

    document.getElementById('toggle_contacts').addEventListener('click', (e) => {
        loadContacts();
        document.getElementById('current_tab').textContent = 'CONTACTS';
        toggleSelectedTab(e)
    })

    document.getElementById('toggle_requests').addEventListener('click', (e) => {
        loadFriendshipRequests();
        document.getElementById('current_tab').textContent = 'REQUESTS';
        toggleSelectedTab(e)
    })

    document.getElementById('send-message').addEventListener('click', () => {
        sendMessage();
    })


    document.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            sendMessage();
        }
    })


    /*     setInterval(() => {
            loadContactMessages(22)
        }, 100) */
}

