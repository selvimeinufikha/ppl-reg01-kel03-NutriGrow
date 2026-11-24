<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // Daftarkan middleware alias untuk kontrol akses berdasarkan role
        // Digunakan di routes/web.php dengan sintaks: middleware('role:admin,nakes')
        $middleware->alias([
            'role' => \App\Http\Middleware\CheckRole::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->respond(function ($response, Throwable $exception, $request) {
            if ($response->getStatusCode() === 419) {
                return back()->with([
                    'login_error' => 'Sesi formulir kedaluwarsa (CSRF token refreshed). Silakan masukkan kembali kata sandi dan klik Masuk.',
                ])->withInput($request->except('password', '_token'));
            }
            return $response;
        });
    })->create();
