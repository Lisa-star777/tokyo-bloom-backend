<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderBy('created_at', 'desc')->get();
        return response()->json($certificates);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'value' => 'required|integer|in:3000,5000,10000',
            'ownerEmail' => 'nullable|email',
        ]);
        
        $code = 'TOKYO-' . strtoupper(substr(md5(uniqid()), 0, 8));
        $expiresAt = now()->addMonths(6);
        
        $certificate = Certificate::create([
            'code' => $code,
            'value' => $validated['value'],
            'status' => 'active',
            'owner_email' => $validated['ownerEmail'] ?? null,
            'expires_at' => $expiresAt,
        ]);
        
        return response()->json($certificate, 201);
    }
    
    public function destroy(Certificate $certificate)
    {
        $certificate->update(['status' => 'used']);
        return response()->json(['message' => 'Сертификат деактивирован']);
    }
}