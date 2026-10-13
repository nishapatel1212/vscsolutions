<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public function index(Request $request)
    {
        return view('admin_panel.chat.chat');
    }

    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . env('OPENAI_API_KEY'),
                'Content-Type' => 'application/json',
            ])->timeout(15)->post('https://api.openai.com/v1/chat/completions', [
                'model' => 'gpt-4o-mini',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->systemPrompt(),
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message,
                    ],
                ],
            ]);
        } catch (\Throwable $e) {
            Log::error('Chatbot: could not reach OpenAI', ['error' => $e->getMessage()]);

            return $this->unavailableReply();
        }

        if ($response->failed()) {
            Log::error('Chatbot: OpenAI request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return $this->unavailableReply();
        }

        $reply = $response->json('choices.0.message.content');

        return response()->json([
            'reply' => $reply ?? "I didn't quite catch that — could you rephrase?",
        ]);
    }

    private function unavailableReply()
    {
        return response()->json([
            'reply' => "Sorry, I'm unable to respond right now. Please call us on "
                . config('latin.phone') . ' or email ' . config('latin.email') . '.',
        ], 200);
    }

    /**
     * Grounds the chatbot in real business facts and the actual price list
     * (shared with quote_ai.py) instead of letting the model guess prices.
     */
    private function systemPrompt(): string
    {
        $priceList = $this->loadPriceList();

        $catalog = collect($priceList)
            ->map(fn($item, $keyword) => "- {$item['description']}: approx \${$item['amount']} AUD")
            ->implode("\n");

        return <<<PROMPT
        You are the customer service assistant for Latin Electrical, a licensed
        electrical contractor in Officer, Victoria (REC {$this->rec()}).

        Business facts (use these, don't invent anything else):
        - Service area: {$this->serviceArea()}.
        - Phone: {$this->phones()}
        - Email: {$this->email()}
        - Insured for \$20M public liability (NECA member).

        Approximate price guide (AUD, GST not included unless stated):
        {$catalog}

        Instructions:
        - Classify the customer's message as one of: Electrical, Billing, General.
        - If they ask about pricing, only quote figures from the price guide above. If their job isn't listed, say you'll need a technician to assess it and suggest booking a quote rather than guessing a number.
        - If the job is outside the service area listed above, say so politely and suggest they contact a local electrician instead.
        - Keep responses short and practical. Never give electrical safety advice that could encourage someone to do their own electrical work — always point to booking a licensed electrician.
        PROMPT;
    }

    private function loadPriceList(): array
    {
        return Cache::remember('chatbot.price_list', now()->addHour(), function () {
            $pythonPath = config('latin.python_path');
            $scriptPath = config('latin.scripts_path') . '/quote_ai.py';

            $output = shell_exec("\"$pythonPath\" \"$scriptPath\" --dump-price-list");
            $data = json_decode($output, true);

            return is_array($data) ? $data : [];
        });
    }

    private function rec(): string
    {
        return config('latin.rec_number');
    }

    private function serviceArea(): string
    {
        return config('latin.service_area');
    }

    private function phones(): string
    {
        return config('latin.phone');
    }

    private function email(): string
    {
        return config('latin.email');
    }
}
