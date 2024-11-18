function makeEditable(iconElement) {
    const fieldKey = iconElement.getAttribute('data-field');  
    const textElement = document.getElementById(`text-${fieldKey}`); 

    if (!textElement) {
        console.error(`Element with id "text-${fieldKey}" not found.`);
        return;
    }

    const inputElement = document.getElementById(`input-${fieldKey}`);
    if (inputElement) {
        const originalValue = inputElement.getAttribute('data-original-value');
        textElement.innerHTML = `Numéro d'entreprise du Québec: ${originalValue}`;
        return;
    }

    const currentValue = textElement.textContent.split(': ')[1].trim();

    textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <input type="text" id="input-${fieldKey}" value="${currentValue}" data-original-value="${currentValue}" name="Info">
        <button type="submit" value="${fieldKey}" name="TypeInfo">Save</button>
    `;
}