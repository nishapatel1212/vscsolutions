function sendMessage() {
    const form = document.getElementById('chatForm');
    const chatUrl = form.dataset.chatUrl;
    let message = $('#message').val();

    $('#chat-box').append("<p><b>You:</b> " + message + "</p>");

    $.ajax({
        url: chatUrl,
        method: 'POST',
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({ message: message }),

        success: function (data) {
            $('#chat-box').append("<p><b>Bot:</b> " + data.reply + "</p>");
        },

        error: function () {
            $('#chat-box').append("<p style='color:red;'><b>Error:</b> Something went wrong</p>");
        }
    });

    $('#message').val('');
}
