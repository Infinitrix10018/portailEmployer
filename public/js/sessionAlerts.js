let Time = 5000;

setTimeout(function(){
    const errorAlert = document.getElementById('error');
    const successAlert = document.getElementById('success');

    if (errorAlert) {
        errorAlert.style.display = 'none';
    }

    if (successAlert) {
        successAlert.style.display = 'none';
    }

}, Time)