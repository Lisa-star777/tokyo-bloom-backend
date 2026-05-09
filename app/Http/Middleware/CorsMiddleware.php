<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CorsMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $allowedOrigins = [
            'https://tokyo-bloom.onrender.com',
            'http://localhost:5173',
        ];

        $origin = $request->header('Origin');

        if (in_array($origin, $allowedOrigins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
            header('Access-Control-Allow-Credentials: true');
        }

        if ($request->isMethod('OPTIONS')) {
            header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS, PATCH');
            header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With, Accept, X-XSRF-TOKEN');
            header('Access-Control-Max-Age: 86400');
            return response('', 204);
        }

        return $next($request);
    }
}
