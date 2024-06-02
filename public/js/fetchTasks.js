$(document).ready(function() {
    let allTasks = [];
 
    function fetchTasks() {
        $('#tasks-container').addClass('hidden'); // Hide table
        $('#loading-spinner').show(); // Show spinner

        $.ajax({
            url: '/tasks/update',
            method: 'GET',
            success: function(data) {
                allTasks = data; 
                updateTable(allTasks);
            },
            error: function() {
                console.error('Failed to fetch tasks.');
            },
            complete: function() {
                $('#loading-spinner').hide();
                $('#tasks-container').removeClass('hidden');
            }
        });
    }
    setInterval(fetchTasks, 3600000); // Repeat fetch every 60 minutes

});