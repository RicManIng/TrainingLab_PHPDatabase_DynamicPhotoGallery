function checkRegistrationForm(nome, cognome, password, confirmPassword, birthDate, username){
    let invalidForm = false;
    if (!checkFieldLength(nome, 1, 50)){
        invalidForm = true;
    }
    if (!checkFieldLength(cognome, 1, 50)){
        invalidForm = true;
    }
    if (!checkFieldLength(username, 1, 50)){
        invalidForm = true;
    }
    if (checkPassword(password).includes(false)){
        invalidForm = true;
    }
    if (password != confirmPassword){
        invalidForm = true;
    }
    if (birthDate == ""){
        invalidForm = true;
    }

    if (!invalidForm){
        let submit = document.querySelector("form").submit();
        submit.disabled = false;
    } else {
        let submit = document.querySelector("form").submit();
        submit.disabled = true;
    }
}

function checkFieldLength(field, min = 0, max = 255){
    if (field.length < min || field.length > max){
        return false;
    }
    return true;
}

function checkPassword(password){
    let isLowerCasePresent = /(?=.*[a-z])/;
    let isUpperCasePresent = /(?=.*[A-Z])/;
    let isNumberPresent = /(?=.*\d)/;
    let isLongEnough = /^.{10,}$/;
    
    let resultsArray = [
        isLowerCasePresent.test(password),
        isUpperCasePresent.test(password),
        isNumberPresent.test(password),
        isLongEnough.test(password)
    ];
    
    console.log(resultsArray);
    return resultsArray;
}

function addErrorMessage(element, message){
    // Check if the immediate next sibling is an error message
    let nextSibling = element.nextElementSibling;
    if (!nextSibling || !nextSibling.classList.contains("error-message")){
        let p = document.createElement("p");
        p.classList.add("error-message");
        p.innerText = message;
        element.insertAdjacentElement('afterend', p);
    }
}

function removeErrorMessage(element){
    let nextSibling = element.nextElementSibling;
    if (nextSibling && nextSibling.classList.contains("error-message")){
        nextSibling.remove();
    }
}

function addErrorChecklist(element, checklist){
    let ul = document.createElement("ul");
    ul.classList.add("error-checklist");
    ul.innerHTML = 'La password deve contenere:';
    checklist.forEach(item => {
        if (!item.valore){
            let li = document.createElement("li");
            li.innerText = item.messaggio;
            li.classList.add("error-message");
            ul.appendChild(li);
        } else {
            let li = document.createElement("li");
            li.innerText = item.messaggio;
            li.classList.add("ok-message");
            ul.appendChild(li);
        }
    });
    element.insertAdjacentElement('afterend', ul);
}

function removeErrorChecklist(element){
    let nextSibling = element.nextElementSibling;
    if (nextSibling && nextSibling.classList.contains("error-checklist")){
        nextSibling.remove();
    }
}

window.onload = function(){
    flatpickr("#birth-date", {
        dateFormat: "Y-m-d",
        allowInput: true
    });

    let inputs = document.querySelectorAll("input");
    let labels = document.querySelectorAll("label");
    
    inputs.forEach((input, index) => {
        input.addEventListener("focus", function(){
            labels[index].classList.add("focused");
        });
        input.addEventListener("blur", function(){
            if(input.value == ""){
                labels[index].classList.remove("focused");
            }
        });
    }); 

    if (page_status == 'register'){
        let nome = document.getElementById("name");
        let cognome = document.getElementById("surname");
        let username = document.getElementById("username");
        let password = document.getElementById("password");
        let confirmPassword = document.getElementById("confirm-password");
        let birthDate = document.getElementById("birth-date");

        nome.addEventListener("blur", function(){
            if (!checkFieldLength(nome.value, 1, 50)){
                addErrorMessage(nome, "Il nome deve essere compreso tra 1 e 50 caratteri.");
                console.log("Nome non valido");
            } else {
                removeErrorMessage(nome);
            }
        });

        cognome.addEventListener("blur", function(){
            if (!checkFieldLength(cognome.value, 1, 50)){
                addErrorMessage(cognome, "Il cognome deve essere compreso tra 1 e 50 caratteri.");
            } else {
                removeErrorMessage(cognome);
            }
        });

        username.addEventListener("blur", function(){
            if (!checkFieldLength(username.value, 1, 50)){
                addErrorMessage(username, "Lo username deve essere compreso tra 1 e 50 caratteri.");
            } else {
                removeErrorMessage(username);
            }
        });

        birthDate.addEventListener("blur", function(){
            if (birthDate.value == ""){
                addErrorMessage(birthDate, "La data di nascita è obbligatoria.");
            } else {
                removeErrorMessage(birthDate);
            }
        });

        confirmPassword.addEventListener("blur", function(){
            if (password.value != confirmPassword.value){
                addErrorMessage(confirmPassword, "Le password non coincidono.");
            } else {
                removeErrorMessage(confirmPassword);
            }
        });

        password.addEventListener("blur", function(){
            let checklist = checkPassword(password.value);
            if (checklist.includes(false)){
                let checklistObjects = [
                    {
                        valore: checklist[0],
                        messaggio: "La password deve contenere almeno una lettera minuscola."
                    },
                    {
                        valore: checklist[1],
                        messaggio: "La password deve contenere almeno una lettera maiuscola."
                    },
                    {
                        valore: checklist[2],
                        messaggio: "La password deve contenere almeno un numero."
                    },
                    {
                        valore: checklist[3],
                        messaggio: "La password deve essere lunga almeno 10 caratteri."
                    }
                ];
                removeErrorChecklist(password);
                addErrorChecklist(password, checklistObjects);
            } else {
                removeErrorChecklist(password);
            }
        });
    }
}