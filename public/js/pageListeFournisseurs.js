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

    $('#listsForm').off('submit',).on('submit', function(e) {
        e.preventDefault();

        $.ajax({
            url: searchUrl,
            method: "get",
            data: $('#listsForm').serialize(), 
            success: function (response) {
                $('#searchResultsContainer').html(response);
                console.log('data send');
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log('Error:', textStatus, errorThrown);
            }
        });
    });
}






