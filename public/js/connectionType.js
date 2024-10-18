let field1 = null;
let label = null;
let neqButton = null;

function initialize() {
    field1 = document.getElementById('email'); 
    label = document.getElementById('emailLabel'); 
    neqButton = document.getElementById('btNEQPage'); 
}

function NeqOrEmail() {
    if (field1.id === 'email') {
        field1.id = 'NEQ';
        field1.name = 'NEQ';
        label.innerText = 'NEQ:'; 
        neqButton.innerText = 'Se connecter avec un Email';
        console.log("Changed to NEQ:", field1.value);
    } else {
        field1.id = 'email';
        field1.name = 'email';
        label.innerText = 'Email:'; 
        neqButton.innerText = 'Se connecter avec un NEQ'; 
        console.log("Changed back to Email:", field1.value);
    }
}

window.onload = function() {
    initialize();
};