<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Feedback;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\FeedbackReply;

class FeedbackController extends Controller
{
    public function index()
    {
        $feedback = Feedback::orderBy('created_at', 'desc')->get();
        return response()->json($feedback);
    }
    
    public function markAsRead(Feedback $feedback)
    {
        $feedback->update(['status' => 'read']);
        return response()->json(['message' => 'Сообщение отмечено как прочитанное']);
    }
    
    public function sendReply(Request $request, Feedback $feedback)
    {
        $validated = $request->validate([
            'reply_text' => 'required|string|min:1',
        ]);
        
        try {
            Mail::to($feedback->email)->send(new FeedbackReply($feedback->name, $validated['reply_text']));
            $feedback->update(['status' => 'read']);
            return response()->json(['message' => 'Ответ отправлен успешно']);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}