<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class SetDatabaseConnection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $client = env('CLIENT_NAME'); // 👈 from .env

        // Map client to DB
        if ($client === 'vsc') {
            $dbName = env('DB_VSC_DATABASE');
            $username = env('DB_VSC_USERNAME');
        } elseif ($client === 'latin') {
            $dbName = env('DB_LATIN_DATABASE');
            $username = env('DB_LATIN_USERNAME');
        } else {
            abort(500, 'Invalid client configuration');
        }

        Config::set('database.connections.mysql.database', $dbName);
        Config::set('database.connections.mysql.username', $username);

        DB::purge('mysql');
        DB::reconnect('mysql');

        return $next($request);
    }
}
