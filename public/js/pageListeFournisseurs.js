function addToLists() {
    // Get the input values
    const rbq = document.getElementById("rechercheRbq").value.trim();
    const code = document.getElementById("rechercheCode").value.trim();
    const ville = document.getElementById("rechercheVille").value.trim();
    const region = document.getElementById("rechercheRegion").value.trim();

    // Arrays for storing lists
    const lists = [
        { value: rbq, listId: "listeRbq" },
        { value: code, listId: "listeCode" },
        { value: ville, listId: "listeVille" },
        { value: region, listId: "listeRegion" }
    ];

    // Loop through each field and add to list if not empty
    lists.forEach(item => {
        if (item.value) {
            const listElement = document.getElementById(item.listId);
            const listItem = document.createElement("li");
            listItem.textContent = item.value;
            listElement.appendChild(listItem);
        }
    });

    // Optionally, clear the input fields after adding to lists
    document.getElementById("rechercheRbq").value = "";
    document.getElementById("rechercheCode").value = "";
    document.getElementById("rechercheVille").value = "";
    document.getElementById("rechercheRegion").value = "";
}

function deleteItem(event) {
    if (event.target.tagName === "LI") {
        event.target.remove();
    }
}

function submitLists() {
    // Convert list items to comma-separated values
    const listeRbqValues = Array.from(document.getElementById("listeRbq").children).map(li => li.textContent);
    const listeCodeValues = Array.from(document.getElementById("listeCode").children).map(li => li.textContent);
    const listeVilleValues = Array.from(document.getElementById("listeVille").children).map(li => li.textContent);
    const listeRegionValues = Array.from(document.getElementById("listeRegion").children).map(li => li.textContent);

    // Set the values of hidden inputs
    document.getElementById("listeRbqCacher").value = listeRbqValues.join(",");
    document.getElementById("listeCodeCacher").value = listeCodeValues.join(",");
    document.getElementById("listeVilleCacher").value = listeVilleValues.join(",");
    document.getElementById("listeRegionCacher").value = listeRegionValues.join(",");


    $.ajax({
        url: "{{ route('VoirFiche.search') }}", // Same route, just handling it with AJAX
        method: "POST",
        data: $('#listsForm').serialize(), // Serialize the form data
        success: function (response) {
            // Update the results container with the partial view content
            $('#searchResultsContainer').html(response);
            console.log($('#listsForm').serialize());
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log('Error:', textStatus, errorThrown);
        }
    });
    // Submit the form
    document.getElementById("listsForm").submit();
}






