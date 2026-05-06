<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = [
            'https://tokyo-bloom.onrender.com',
            'http://localhost:5173',
            'http://127.0.0.1:5173',
        ];
        
        $origin = $request->headers->get('Origin');
        
        if (in_array($origin, $allowedOrigins)) {
            header("Access-Control-Allow-Origin: $origin");
            header('Access-Control-Allow-Credentials: true');
        }
        
        if ($request->isMethod('OPTIONS')) {
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN');
            header('Access-Control-Max-Age: 86400');
            return response('', 200);
        }

        return $next($request);
    }
}
