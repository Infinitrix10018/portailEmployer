function submitLists() {

    $('#rechercheFournisseur').off('submit',).on('submit', function(e) {
        e.preventDefault();
        let query = $(this).val();

        $.ajax({
            url: searchUrl,
            method: "get",
            data: { fournisseur: query }, 
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






