<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index(Request $request)
    {
        $certificates = Certificate::where('owner_email', $request->user()->email)
            ->orWhere('buyer_name', $request->user()->name)
            ->orderBy('created_at', 'desc')
            ->get();
        
        return response()->json($certificates);
    }
    
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'value' => 'required|integer|in:3000,5000,10000',
                'ownerEmail' => 'nullable|email',
                'buyerName' => 'nullable|string',
            ]);
            
            $code = 'TOKYO-' . strtoupper(substr(md5(uniqid()), 0, 8));
            $expiresAt = now()->addMonths(6);
            
            $certificate = Certificate::create([
                'code' => $code,
                'value' => $validated['value'],
                'status' => 'active',
                'owner_email' => $validated['ownerEmail'] ?? $request->user()?->email,
                'buyer_name' => $validated['buyerName'] ?? $request->user()?->name,
                'expires_at' => $expiresAt,
            ]);
            
            return response()->json($certificate, 201);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
    
    // Переименовали метод с validate на checkValidity
    public function checkValidity(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string',
        ]);
        
        $certificate = Certificate::where('code', $validated['code'])->first();
        
        if (!$certificate) {
            return response()->json([
                'valid' => false,
                'error' => 'Сертификат не найден'
            ]);
        }
        
        if ($certificate->status !== 'active') {
            return response()->json([
                'valid' => false,
                'error' => 'Сертификат уже использован'
            ]);
        }
        
        if ($certificate->expires_at < now()) {
            return response()->json([
                'valid' => false,
                'error' => 'Срок действия сертификата истек'
            ]);
        }
        
        return response()->json([
            'valid' => true,
            'certificate' => $certificate
        ]);
    }
}