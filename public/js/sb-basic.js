//Add the following code if you want the name of the file appear on select
$("input[type='file']").on("change", function () {
    var fileName = $(this).get(0).files.length
    if (fileName < 4) {
        if (fileName == 1) {
            $('#submit-button').attr('disabled', false);
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        } else {
            $('#submit-button').attr('disabled', false);
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName + '&nbsp;File Selected');
        }
    } else {
        $('#submit-button').attr('disabled', true);
        $(this).siblings(".custom-file-label").addClass("selected").html('Maximum 3 File Select');
    }
});


