//copier de chat gpt, mais je vais le modifier pour ce que j'ai besoin

let numberOfPhones = 1;

function addPhoneNumber() {
    numberOfPhones++;
    console.log(numberOfPhones);
    const phoneNumbersDiv = document.getElementById('telephone');//nom de la grande div avec toute la section dynamic
    
    // Create a new row for the new set of fields
    const newRow = document.createElement('div');
    newRow.className = 'row phone-number-group';//nom de la div qui va être une section
    
    // Create the phone type dropdown
    const phoneTypeCol = document.createElement('div');
    phoneTypeCol.className = 'col-md-3';
    const phoneTypeLabel = document.createElement('label');
    phoneTypeLabel.setAttribute('for', `type_tel${numberOfPhones}`);
    phoneTypeLabel.textContent = `Type de téléphone: ${numberOfPhones}:`;//peut-être enlever la partie ${numberOfPhones} après avoir tester
    const phoneTypeSelect = document.createElement('select');
    phoneTypeSelect.id = `type_tel${numberOfPhones}`;
    phoneTypeSelect.name = 'type_tels[fournisseur][]';
    phoneTypeSelect.className = 'form-select';
    phoneTypeSelect.required = true;
    phoneTypeSelect.innerHTML = `
        <option value="bureau">Bureau</option>
        <option value="cellulaire">Célulaire</option>
        <option value="fax">Fax</option>
    `;
    phoneTypeCol.appendChild(phoneTypeLabel);
    phoneTypeCol.appendChild(phoneTypeSelect);

    // Create the phone number input
    const phoneCol = document.createElement('div');
    phoneCol.className = 'col-md-6';
    const phoneLabel = document.createElement('label');
    phoneLabel.setAttribute('for', `no_tel${numberOfPhones}`);
    phoneLabel.className = 'form-label';
    phoneLabel.textContent = `Téléphone: ${numberOfPhones}:`;
    const phoneInput = document.createElement('input');
    phoneInput.type = 'text';
    phoneInput.id = `no_tel${numberOfPhones}`;
    phoneInput.name = 'no_tel[fournisseur][]';
    phoneInput.className = 'form-control';
    phoneInput.required = true;
    phoneCol.appendChild(phoneLabel);
    phoneCol.appendChild(phoneInput);


    // Create the phone purpose input
    const phonePurposeCol = document.createElement('div');
    phonePurposeCol.className = 'col-md-3';
    const phonePurposeLabel = document.createElement('label');
    phonePurposeLabel.setAttribute('for', `poste_tel${numberOfPhones}`);
    phonePurposeLabel.className = 'form-label';
    phonePurposeLabel.textContent = `Phone Purpose ${numberOfPhones}:`;
    const phonePurposeInput = document.createElement('input');
    phonePurposeInput.type = 'text';
    phonePurposeInput.id = `poste_tel${numberOfPhones}`;
    phonePurposeInput.name = 'poste_tel[fournisseur][]';
    phonePurposeInput.className = 'form-control';
    phonePurposeInput.required = false;
    phonePurposeCol.appendChild(phonePurposeLabel);
    phonePurposeCol.appendChild(phonePurposeInput);

    // Append the new columns to the row
    newRow.appendChild(phoneTypeCol);
    newRow.appendChild(phoneCol);
    newRow.appendChild(phonePurposeCol);

    // Append the new row to the phoneNumbers div
    phoneNumbersDiv.appendChild(newRow);
}

//-------------------------------------------------------------------------------------------

//-------------------------------------------------------------------------------------------

//ajout pour personne contact (copier de ce qu'il y a dessus et adapté)

//fini, pour l'ajout de choses.

let numberOfContacts = 1;

function addContactPerson() {
    numberOfContacts++;
    console.log(numberOfContacts);
    const contactDiv = document.getElementById('contact');//nom de la grande div avec toute la section dynamic
    
    // Create a new row for the new set of fields
    const newRow1 = document.createElement('div');
    newRow1.className = 'row contact-group';//nom de la div qui va être une section

    const newContainer = document.createElement('div');
    newContainer.className = 'container-xxl';//nom de la div qui va être une section

    const newRow2 = document.createElement('div');
    newRow2.className = 'row contact-group-tel';//nom de la div qui va être une section


    // crée un input et label pour le prénom
    const prenomCol = document.createElement('div');
    prenomCol.className = 'col-lg-12';
    const prenomLabel = document.createElement('label');
    prenomLabel.setAttribute('for', `prenom_contact${numberOfContacts}`);
    prenomLabel.textContent = `Prénom :`;
    const PrenomInput = document.createElement('input');
    PrenomInput.type = 'text';
    PrenomInput.id = `prenom_contact${numberOfContacts}`;
    PrenomInput.name = 'prenom[personne_ressource][]';
    PrenomInput.className = 'form-control';
    PrenomInput.required = true;
    prenomCol.appendChild(prenomLabel);
    prenomCol.appendChild(PrenomInput);

    // crée un input et label pour le nom
    const nomCol = document.createElement('div');
    nomCol.className = 'col-lg-12';
    const nomLabel = document.createElement('label');
    nomLabel.setAttribute('for', `nom_contact${numberOfContacts}`);
    nomLabel.className = 'form-label';
    nomLabel.textContent = `Nom :`;
    const nomInput = document.createElement('input');
    nomInput.type = 'text';
    nomInput.id = `nom_contact${numberOfContacts}`;
    nomInput.name = 'nom[personne_ressource][]';
    nomInput.className = 'form-control';
    nomInput.required = true;
    nomCol.appendChild(nomLabel);
    nomCol.appendChild(nomInput);

    // crée un input et label pour la fonction
    const fonctionCol = document.createElement('div');
    fonctionCol.className = 'col-lg-12';
    const fonctionLabel = document.createElement('label');
    fonctionLabel.setAttribute('for', `fonction${numberOfContacts}`);
    fonctionLabel.className = 'form-label';
    fonctionLabel.textContent = `Fonction :`;
    const fonctionInput = document.createElement('input');
    fonctionInput.type = 'text';
    fonctionInput.id = `fonction${numberOfContacts}`;
    fonctionInput.name = 'fonction[personne_ressource][]';
    fonctionInput.className = 'form-control';
    fonctionInput.required = true;
    fonctionCol.appendChild(fonctionLabel);
    fonctionCol.appendChild(fonctionInput);


    // crée un input et label pour l'adresse courriel
    const emailContactCol = document.createElement('div');
    emailContactCol.className = 'col-lg-12';
    const emailContactLabel = document.createElement('label');
    emailContactLabel.setAttribute('for', `email_contact${numberOfContacts}`);
    emailContactLabel.className = 'form-label';
    emailContactLabel.textContent = `Adresse courriel :`;
    const emailContactInput = document.createElement('input');
    emailContactInput.type = 'text';
    emailContactInput.id = `email_contact${numberOfContacts}`;
    emailContactInput.name = 'email_contact[personne_ressource][]';
    emailContactInput.className = 'form-control';
    emailContactInput.required = true;
    emailContactCol.appendChild(emailContactLabel);
    emailContactCol.appendChild(emailContactInput);

    // Append the new columns to the row
    newRow1.appendChild(prenomCol);
    newRow1.appendChild(nomCol);
    newRow1.appendChild(fonctionCol);
    newRow1.appendChild(emailContactCol);

    //-------------------------------------------------------------------------------------------
    // partie pour téléphone (copie conforme de la fontion au dessus)

    // Create the phone type dropdown
    const phoneTypeCol = document.createElement('div');
    phoneTypeCol.className = 'col-md-3';
    const phoneTypeLabel = document.createElement('label');
    phoneTypeLabel.setAttribute('for', `type_tels_contact${numberOfPhones}`);
    phoneTypeLabel.className = 'form-label';
    phoneTypeLabel.textContent = `Type de téléphone :`;//peut-être enlever la partie ${numberOfPhones} après avoir tester
    const phoneTypeSelect = document.createElement('select');
    phoneTypeSelect.id = `type_tels_contact${numberOfPhones}`;
    phoneTypeSelect.name = 'type_tels[personne_ressource][]';
    phoneTypeSelect.className = 'form-select';
    phoneTypeSelect.required = true;
    phoneTypeSelect.innerHTML = `
        <option value="bureau">Bureau</option>
        <option value="cellulaire">Célulaire</option>
        <option value="fax">Fax</option>
    `;
    phoneTypeCol.appendChild(phoneTypeLabel);
    phoneTypeCol.appendChild(phoneTypeSelect);

    // Create the phone number input
    const phoneCol = document.createElement('div');
    phoneCol.className = 'col-md-6';
    const phoneLabel = document.createElement('label');
    phoneLabel.setAttribute('for', `no_tels_contact${numberOfPhones}`);
    phoneLabel.className = 'form-label';
    phoneLabel.textContent = `Téléphone :`;
    const phoneInput = document.createElement('input');
    phoneInput.type = 'text';
    phoneInput.id = `no_tels_contact${numberOfPhones}`;
    phoneInput.name = 'no_tel[personne_ressource][]';
    phoneInput.className = 'form-control';
    phoneInput.required = true;
    phoneCol.appendChild(phoneLabel);
    phoneCol.appendChild(phoneInput);


    // Create the phone purpose input
    const phonePurposeCol = document.createElement('div');
    phonePurposeCol.className = 'col-md-3';
    const phonePurposeLabel = document.createElement('label');
    phonePurposeLabel.setAttribute('for', `poste_tel_contact${numberOfPhones}`);
    phonePurposeLabel.className = 'form-label';
    phonePurposeLabel.textContent = `Poste :`;
    const phonePurposeInput = document.createElement('input');
    phonePurposeInput.type = 'text';
    phonePurposeInput.id = `poste_tel_contact${numberOfPhones}`;
    phonePurposeInput.name = 'poste_tel[personne_ressource][]';
    phonePurposeInput.className = 'form-control';
    phonePurposeInput.required = false;
    phonePurposeCol.appendChild(phonePurposeLabel);
    phonePurposeCol.appendChild(phonePurposeInput);

    // Append the new columns to the row
    newRow2.appendChild(phoneTypeCol);
    newRow2.appendChild(phoneCol);
    newRow2.appendChild(phonePurposeCol);

    // Append the new row to the phoneNumbers div
    contactDiv.appendChild(newRow1);
    newContainer.appendChild(newRow2);
    contactDiv.appendChild(newContainer);
}    
//-------------------------------------------------------------------------------------------
        //Partie pour le rechercher avec AJAX
//-------------------------------------------------------------------------------------------


    $('#search').on('keyup', function() {
        $.ajax({
            url: '/Inscription', // Ensure this matches your route
            data: { search: $(this).val() },
            success: function(data) {
                $('#licence-list').html(data);
                console.log(data); // Log the returned data
            },
            error: function(xhr, status, error) {
                console.log(xhr.responseText); // Log errors if any
            }
        });
    });
    
