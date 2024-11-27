function submitLists() {

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






