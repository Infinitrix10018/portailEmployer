let currentlyEditing = null;


function makeEditable(iconElement) {
    const fieldKey = iconElement.getAttribute('data-field');  
    const textElement = document.getElementById(`text-${fieldKey}`); 

    if (!textElement) {
        console.error(`Element with id "text-${fieldKey}" not found.`);
        return;
    }

    if (currentlyEditing && currentlyEditing !== textElement) {
        const previousInput = currentlyEditing.querySelector('input, select');
        if (previousInput) {
            const originalValue = previousInput.getAttribute('data-original-value');
            currentlyEditing.innerHTML = `${currentlyEditing.textContent.split(': ')[0]}: ${originalValue}`;
        }
    }

    currentlyEditing = textElement;

    const inputElement = document.getElementById(`input-${fieldKey}`);
    if (inputElement) {
        const originalValue = inputElement.getAttribute('data-original-value');
        textElement.innerHTML = `${textElement.textContent.split(': ')[0]}: ${originalValue}`;
        currentlyEditing = null; 
        return;
    }

    const currentValue = textElement.textContent.split(': ')[1].trim();

    if (fieldKey === "no_region_admin") {
        textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <select id="input-${fieldKey}" name="Info" value="${currentValue}" data-original-value="${currentValue}">
            <option value="00">Extérieur du Québec</option>
            <option value="01">01 - Bas-Saint-Laurent</option>
            <option value="02">02 - Saguenay-Lac-Saint-Jean</option>
            <option value="03">03 - Capitale-Nationale</option>
            <option value="04">04 - Mauricie</option>
            <option value="05">05 - Estrie</option>
            <option value="06">06 - Montréal</option>
            <option value="07">07 - Outaouais</option>
            <option value="08">08 - Abitibi-Témiscamingue</option>
            <option value="09">09 - Côte-Nord</option>
            <option value="10">10 - Nord-du-Québec</option>
            <option value="11">11 - Gaspésie-Îles-de-la-Madeleine</option>
            <option value="12">12 - Chaudière-Appalaches</option>
            <option value="13">13 - Laval</option>
            <option value="14">14 - Lanaudière</option>
            <option value="15">15 - Laurentides</option>
            <option value="16">16 - Montérégie</option>
            <option value="17">17 - Centre-du-Québec</option>
        </select>
        <button type="submit" value="${fieldKey}" name="TypeInfo">Save</button>
        `;
    } else if (fieldKey === "province") {
        textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <select id="input-${fieldKey}" name="Info" value="${currentValue}" data-original-value="${currentValue}">
            <option value="Quebec">Québec</option>
            <option value="Alberta">Alberta</option>
            <option value="Colombie-Britannique">Colombie-Britannique</option>
            <option value="Ile-du-Prince-Édouard">Île-du-Prince-Édouard</option>
            <option value="Manitoba">Manitoba</option>
            <option value="Nouveau-Brunswick">Nouveau-Brunswick</option>
            <option value="Nouvelle-Ecosse">Nouvelle-Écosse</option>
            <option value="Ontario">Ontario</option>
            <option value="Saskatchewan">Saskatchewan</option>
            <option value="Terre-Neuve-et-Labrador">Terre-Neuve-et-Labrador</option>
            <option value="Territoires du Nord-Ouest">Territoires du Nord-Ouest</option>
            <option value="Nunavut">Nunavut</option>
            <option value="Yukon">Yukon</option>
        </select>
        <button type="submit" value="${fieldKey}" name="TypeInfo">Save</button>
        `;
    } else {
        textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <input type="text" id="input-${fieldKey}" value="${currentValue}" data-original-value="${currentValue}" name="Info">
        <button type="submit" value="${fieldKey}" name="TypeInfo">Save</button>
        `;
    }

    const saveButton = textElement.querySelector('button[type="submit"]');
    saveButton.addEventListener('click', () => {
        currentlyEditing = null;
    });
}

    
function makeEditableContact(iconElement) {
    const fieldKey = iconElement.getAttribute('data-field');
    const contactId = iconElement.getAttribute('data-contact-id');
    const textElement = document.getElementById(`text-${fieldKey}-${contactId}`);

    if (!textElement) {
        console.error(`Element with id "text-${fieldKey}-${contactId}" not found.`);
        return;
    }

    if (currentlyEditing && currentlyEditing !== textElement) {
        const previousInput = currentlyEditing.querySelector('input');
        if (previousInput) {
            const originalValue = previousInput.getAttribute('data-original-value');
            currentlyEditing.innerHTML = `${currentlyEditing.textContent.split(': ')[0]}: ${originalValue}`;
        }
    }

    currentlyEditing = textElement;

    const inputElement = document.getElementById(`input-${fieldKey}-${contactId}`);
    if (inputElement) {
        const originalValue = inputElement.getAttribute('data-original-value');
        textElement.innerHTML = `${textElement.textContent.split(': ')[0]}: ${originalValue}`;
        currentlyEditing = null;
        return;
    }

    const currentValue = textElement.textContent.split(': ')[1].trim();


    if(fieldKey === "type_tel")
    {
        textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <select id="input-${fieldKey}-${contactId}" name="Info" value="${currentValue} data-original-value="${currentValue}">
            <option value="bureau">Bureau</option>
            <option value="cellulaire">Célulaire</option>
            <option value="fax">Fax</option>
        </select>
        <input type="hidden" name="contact_id" value="${contactId}">
        <button type="submit" value="${fieldKey}" name="TypeInfo">Save</button>
    `;
    }else
    {
        textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <input type="text" id="input-${fieldKey}-${contactId}" value="${currentValue}" data-original-value="${currentValue}" name="Info">
        <input type="hidden" name="contact_id" value="${contactId}">
        <button type="submit" value="${fieldKey}" name="TypeInfo">Save</button>
    `;
    }


}