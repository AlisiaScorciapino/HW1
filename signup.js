function jsonCheckUsername(json) {
    // Controllo il campo exists ritornato dal JSON
    if (formStatus.username = !json.exists) {//dubbio
        document.querySelector('.username').classList.remove('error');
    } else {
        document.querySelector('.username span').textContent = "Nome utente già utilizzato";
        document.querySelector('.username').classList.add('error');
    }

}

function jsonCheckEmail(json) {
    // Controllo il campo exists ritornato dal JSON
    if (formStatus.email = !json.exists) {//dubbio
        document.querySelector('.email').classList.remove('error');
    } else {
        document.querySelector('.email span').textContent = "Email già utilizzata";
        document.querySelector('.email').classList.add('error');
    }

}

function fetchResponse(response) {
    if (!response.ok) return null;//proprietà di response che indica se la risposta ha avuto successo o no
    return response.json();
}


function checkUsername(event) {
    const input = document.querySelector('.username input');

    if(!/^[a-zA-Z0-9_]{3,15}$/.test(input.value)) {// stesso pattern di php????
        input.parentNode.querySelector('span').textContent = "L'username deve avere minimo 3 lettere";//cambiare testo?
        input.parentNode.classList.add('error');
        formStatus.username = false;
    } else {
        fetch("check_username.php?q="+encodeURIComponent(input.value)).then(fetchResponse).then(jsonCheckUsername);
    }    
}


function checkEmail(event) {
    const emailInput = document.querySelector('.email input');
    if(!/^[A-z0-9\.\+_-]+@[A-z0-9\._-]+\.[A-z]{2,6}$/.test(String(emailInput.value).toLowerCase())) {//toLowerCase converte una stringa in minuscolo
        document.querySelector('.email span').textContent = "Email non valida";//Modifica il testo con textContent
        document.querySelector('.email').classList.add('error');//Aggiunge la classe error
        formStatus.email = false;//dubbio
    }else {
        fetch("check_email.php?q="+encodeURIComponent(String(emailInput.value).toLowerCase())).then(fetchResponse).then(jsonCheckEmail);
        //serve a codificare i caratteri speciali
    }
}


function checkPassword(event) {
    const passwordInput = document.querySelector('.password input');
    if (formStatus.password = passwordInput.value.length >= 8) {
        document.querySelector('.password').classList.remove('error');
    } else {
        document.querySelector('.password span').textContent = "Password non valida";//dubbio
        document.querySelector('.password').classList.add('error');
    }

}

function checkConfirmPassword(event) {
    const confirmPasswordInput = document.querySelector('.confirm_password input');
    if (formStatus.confirmPassord = confirmPasswordInput.value === document.querySelector('.password input').value) {
        document.querySelector('.confirm_password').classList.remove('error');
    } else {
        document.querySelector('.confirm_password span').textContent = "La password non corrisponde";
        document.querySelector('.confirm_password').classList.add('error');
    }
}

/*modificare???non lo so
function checkUpload(event) {
    const upload_original = document.getElementById('upload_original');
    document.querySelector('#upload .file_name').textContent = upload_original.files[0].name;
    const o_size = upload_original.files[0].size;
    const mb_size = o_size / 1000000;
    document.querySelector('#upload .file_size').textContent = mb_size.toFixed(2)+" MB";
    const ext = upload_original.files[0].name.split('.').pop();

    if (o_size >= 7000000) {
        document.querySelector('.fileupload span').textContent = "Le dimensioni del file superano 7 MB";
        document.querySelector('.fileupload').classList.add('errorj');
        formStatus.upload = false;
    } else if (!['jpeg', 'jpg', 'png', 'gif'].includes(ext))  {
        document.querySelector('.fileupload span').textContent = "Le estensioni consentite sono .jpeg, .jpg, .png e .gif";
        document.querySelector('.fileupload').classList.add('error');
        formStatus.upload = false;
    } else {
        document.querySelector('.fileupload').classList.remove('error');
        formStatus.upload = true;
    }
}*/

function checkSignup(event) {
    const checkbox = document.querySelector('.allow input');//termini e conizioni
    formStatus[checkbox.name] = checkbox.checked;
    if (Object.keys(formStatus).length !== 8 || Object.values(formStatus).includes(false)) {
        event.preventDefault();
    }
}


function clickSelectFile(event) {
    upload_original.click();
}


//const formStatus = {'upload': true};//dubbio
document.querySelector('.username input').addEventListener('blur', checkUsername);
document.querySelector('.email input').addEventListener('blur', checkEmail);
document.querySelector('.password input').addEventListener('blur', checkPassword);
document.querySelector('.confirm_password input').addEventListener('blur', checkConfirmPassword);
document.getElementById('upload').addEventListener('click', clickSelectFile);
document.getElementById('upload_original').addEventListener('change', checkUpload);
document.querySelector('.submit submit').addEventListener('submit',checkSignup);