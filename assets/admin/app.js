$(".del-btn").on('click', function(e){
    e.preventDefault();
    $id = $(this).attr('data-form');
    if (confirm("Press a button!")){
        $("#del-form-"+$id).submit();
    }
})