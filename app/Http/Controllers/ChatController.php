<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        return view('admin_panel.chat.chat');
    }

    public function chat(Request $request)
    {
        $userMessage = $request->message;

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.openai.com/v1/chat/completions', [
            'model' => 'gpt-4o-mini',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an electrical service assistant for Latin Electrical. Classify issue (Electrical, Billing, General) and give response with pricing estimate.'
                ],
                [
                    'role' => 'user',
                    'content' => $userMessage
                ]
            ],
        ]);

        return response()->json([
            'reply' => $response['choices'][0]['message']['content']
        ]);
    }
}
