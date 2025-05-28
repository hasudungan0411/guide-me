<?php

namespace App\Http\Controllers\Wisatawan;

use App\Http\Controllers\Controller;
use App\Models\Wisatawan;
use Illuminate\Http\Request;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function chatbot()
    {
        return view('wisatawan.chatbot');
    }

    public function sendChat(Request $request)
    {
        $response = OpenAI::chat()->create([
            'model' => 'gpt-3.5-turbo',
            'messages' => [
                [
                    'role' => 'user',
                    'content' => $request->input,
                ],
            ],
            'max_tokens' => 100,
        ]);

        return $response->choices[0]->message->content;
    }
}
