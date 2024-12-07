function submitLists() {

    $('#listsForm').off('submit',).on('submit', function(e) {
        e.preventDefault();
        let query = $(this).val();

        $.ajax({
            url: searchUrl,
            method: "get",
            data: { fournisseur: $('#rechercheFournisseur').val() }, 
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






