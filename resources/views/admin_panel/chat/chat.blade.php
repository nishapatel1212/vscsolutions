@extends('adminlte::page')

@section('title', 'Create Safety Report')

@section('content_header')
<h1>Create Safety Check Report</h1>
@endsection

@section('content')

<h2>⚡ Latin Electrical AI Chatbot</h2>

<div id="chat-box" style="border:1px solid #ccc; height:300px; overflow:auto; padding:10px;"></div>

<input type="text" id="message" placeholder="Type your issue..." style="width:80%;">
<button onclick="sendMessage()">Send</button>

@endsection

@section('js')
<script>
function sendMessage() {
    let message = $('#message').val();

    // Show user message
    $('#chat-box').append("<p><b>You:</b> " + message + "</p>");

    $.ajax({
        url: "{{route('chatbot.talk')}}",
        method: 'POST',
        contentType: 'application/json',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        data: JSON.stringify({ message: message }),

        success: function(data) {
            $('#chat-box').append("<p><b>Bot:</b> " + data.reply + "</p>");
        },

        error: function(xhr) {
            $('#chat-box').append("<p style='color:red;'><b>Error:</b> Something went wrong</p>");
        }
    });

    // Clear input
    $('#message').val('');
}
</script>
@endsection
