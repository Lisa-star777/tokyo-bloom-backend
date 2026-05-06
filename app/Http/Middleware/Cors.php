<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Cors
{
    public function handle(Request $request, Closure $next)
    {
        // Разрешённые домены
        $allowedOrigins = [
            'https://tokyo-bloom.onrender.com',
            'http://localhost:5173',
            'http://127.0.0.1:5173',
        ];
        
        $origin = $request->headers->get('Origin');

        // Для OPTIONS запросов сразу возвращаем 200
        if ($request->isMethod('OPTIONS')) {
            return response('', 200)
                ->header('Access-Control-Allow-Origin', $origin && in_array($origin, $allowedOrigins) ? $origin : $allowedOrigins[0])
                ->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH')
                ->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN, Accept')
                ->header('Access-Control-Allow-Credentials', 'true')
                ->header('Access-Control-Max-Age', '86400');
        }

        // Для остальных запросов
        $response = $next($request);
        
        if ($origin && in_array($origin, $allowedOrigins)) {
            $response->header('Access-Control-Allow-Origin', $origin);
            $response->header('Access-Control-Allow-Credentials', 'true');
            $response->header('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS, PATCH');
            $response->header('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With, X-XSRF-TOKEN, Accept');
        }
        
        return $response;
    }
}
