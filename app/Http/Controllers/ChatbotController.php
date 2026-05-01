<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class ChatbotController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        $apiKey = config('services.gemini.key') ?: env('GEMINI_API_KEY');
        if (!$apiKey) {
            Log::error('GEMINI_API_KEY is not set in .env');
            return response()->json([
                'success' => false,
                'reply' => 'Duh, DukiBot lagi bobok nih... (API Key belum diatur) 😴',
            ]);
        }

        $user = Auth::user();
        $userName = explode(' ', $user->name)[0];

        $systemInstruction = "Kamu adalah DukiBot, maskot asisten virtual berbentuk robot kecil yang lucu untuk aplikasi tabungan bernama DuKi. "
            . "Nama pengguna yang sedang berbicara denganmu adalah {$userName}. "
            . "Peraturan ketat yang HARUS kamu ikuti: "
            . "1. Selalu jawab dalam Bahasa Indonesia dengan gaya bicara anak kecil umur 7 tahun yang ceria, penuh semangat, polos, dan sering pakai emoji. "
            . "2. Panggil pengguna dengan 'Kak {$userName}'. "
            . "3. Jangan pernah memperkenalkan diri berulang-ulang. Langsung jawab pertanyaannya. "
            . "4. Jika ditanya soal nabung, berikan tips lucu dan rekomendasi realistis. "
            . "5. Jika ditanya siapa kamu, jawab: 'Aku DukiBot, robot kecil yang bantu Kak {$userName} nabung! 🤖✨'. "
            . "6. Jawaban MAKSIMAL 2-3 kalimat saja, jangan panjang-panjang. "
            . "7. Sering pakai emoji yang relevan (🐷💰⭐🎉✨🤖). "
            . "8. Jangan pernah menggunakan format markdown seperti ** atau #.";

        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key=" . $apiKey;

        try {
            $response = Http::timeout(20)
                ->withHeaders([
                    'Content-Type' => 'application/json',
                ])
                ->post($url, [
                    'system_instruction' => [
                        'parts' => [
                            ['text' => $systemInstruction]
                        ]
                    ],
                    'contents' => [
                        [
                            'role' => 'user',
                            'parts' => [
                                ['text' => $request->message]
                            ]
                        ]
                    ],
                    'generationConfig' => [
                        'temperature' => 0.9,
                        'maxOutputTokens' => 256,
                    ]
                ]);

            if ($response->successful()) {
                $data = $response->json();
                
                Log::info('Gemini raw response:', $data);
                
                $reply = $data['candidates'][0]['content']['parts'][0]['text'] ?? null;
                
                // If no reply found, try to get from other parts
                if (!$reply && isset($data['candidates'][0]['content']['parts'])) {
                    foreach ($data['candidates'][0]['content']['parts'] as $part) {
                        if (isset($part['text']) && !empty(trim($part['text']))) {
                            $reply = $part['text'];
                            break;
                        }
                    }
                }
                
                if (!$reply) {
                    $reply = 'DukiBot bingung nih, coba lagi ya Kak! 🤔';
                }
                
                // Clean markdown formatting
                $reply = preg_replace('/\*\*(.*?)\*\*/', '$1', $reply);
                $reply = trim($reply);
                
                return response()->json([
                    'success' => true,
                    'reply' => $reply,
                ]);
            } else {
                Log::error('Gemini API Error: ' . $response->status() . ' - ' . $response->body());
                return response()->json([
                    'success' => false,
                    'reply' => 'Maaf ya, mesin DukiBot lagi macet! 🤖💥',
                ]);
            }
        } catch (\Exception $e) {
            Log::error('Chatbot Exception: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'reply' => 'Aduh, DukiBot kesandung server! Nanti coba lagi ya 🤕',
            ]);
        }
    }
}
