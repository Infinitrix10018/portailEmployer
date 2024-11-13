function makeEditable(iconElement) {
    const fieldKey = iconElement.getAttribute('data-field');  
    const textElement = document.getElementById(`text-${fieldKey}`); 

    if (!textElement) {
        console.error(`Element with id "text-${fieldKey}" not found.`);
        return;
    }

    const currentValue = textElement.textContent.split(': ')[1].trim();  

    textElement.innerHTML = `
        <label>${textElement.textContent.split(': ')[0]}:</label> 
        <input type="text" id="input-${fieldKey}" value="${currentValue}">
    `;
}