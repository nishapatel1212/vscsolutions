@extends('layouts.app')

@section('title', 'AI Chatbot')

@section('content_header')
<div>
    <h1 class="page-title">AI Chatbot</h1>
</div>
@endsection

@section('content')

<div class="panel">
    <div class="p-4">
        <div id="chat-box" style="border:1px solid #ccc; height:300px; overflow:auto; padding:10px;"></div>

        <form id="chatForm" data-chat-url="{{ route('chatbot.talk') }}" class="d-flex gap-2 mt-3" onsubmit="sendMessage(); return false;">
            <input type="text" id="message" class="form-control" placeholder="Type your issue...">
            <button type="submit" class="btn btn-gold">Send</button>
        </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="{{ asset('js/pages/chat.js') }}"></script>
@endpush
