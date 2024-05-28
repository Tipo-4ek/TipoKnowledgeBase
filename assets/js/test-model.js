$(document).ready(function() {
    $('form').on('submit', function(event) {
        event.preventDefault();

        var question = $('#question').val();
        
        $.ajax({
            url: '/assets/php/f-openai-api.php',
            type: 'POST',
            data: {
                question: question
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error(error);
            }
        });
    });
});