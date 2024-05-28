$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('#sidebar').toggleClass('active');
    });
});

$(function() {
                
    $('.list-group-item').on('click', function() {
    $('.fas', this)
        .toggleClass('fas fa-angle-right')
        .toggleClass('fas fa-angle-down');
    });

});