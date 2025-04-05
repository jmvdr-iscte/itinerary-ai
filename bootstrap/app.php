<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware as CustomMiddleware;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Access\AuthorizationException;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        apiPrefix: '',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias( [
            'api_key' => CustomMiddleware\ApiKey::class,
        ]);
        $middleware->validateCsrfTokens(except: [
            '*',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {

        // Optional: Configure Reporting (Logging, Sentry, etc.)
        $exceptions->reportable(function (Throwable $e) {
            // Your reporting logic here...
            // Example: if (app()->bound('sentry') && $exceptions->shouldReport($e)) { ... }
        })->stop(); // Use stop() if your logic fully handles reporting


        // --- Force JSON Error Responses ---
        // The logic inside renderable is the same as before,
        // just placed within this configuration closure.

        // 1. Validation Exceptions (422)
        $exceptions->renderable(function (ValidationException $e, $request) {
             return response()->json([
                 'message' => $e->getMessage(),
                 'errors' => $e->errors(),
             ], $e->status); // $e->status is typically 422
        });

        // 2. Authentication Exceptions (401)
        $exceptions->renderable(function (AuthenticationException $e, $request) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        });

         // 3. Authorization Exceptions (403)
        $exceptions->renderable(function (AuthorizationException $e, $request) {
            return response()->json([
                'message' => $e->getMessage() ?: 'This action is unauthorized.',
            ], 403);
        });

        // 4. HTTP Exceptions (404, 405, etc.)
        $exceptions->renderable(function (HttpException $e, $request) {
            $statusCode = $e->getStatusCode();
            $message = $e->getMessage() ?: (Response::$statusTexts[$statusCode] ?? 'Http Error');
            return response()->json([
                'message' => $message,
            ], $statusCode, $e->getHeaders()); // Pass original headers
        });

        // 5. Catch-all for other Throwables (500 Errors)
        $exceptions->renderable(function (Throwable $e, $request) {
             // Determine status code: Use exception's code if HTTP, otherwise 500
             $statusCode = ($e instanceof HttpExceptionInterface)
                            ? $e->getStatusCode()
                            : 500;

             // Base response structure
             $response = [
                 'message' => ($statusCode == 500 && !config('app.debug'))
                                 ? 'Server Error' // Generic message in production
                                 : $e->getMessage(),
             ];

             // Add debug info if APP_DEBUG is true
             if (config('app.debug')) {
                 $response['exception'] = get_class($e);
                 $response['file'] = $e->getFile();
                 $response['line'] = $e->getLine();
                 // Optionally filter trace for brevity
                 $response['trace'] = collect($e->getTrace())->map(function ($trace) {
                    return \Illuminate\Support\Arr::except($trace, ['args']);
                 })->all();
             }

             // Get headers if available from the exception
             $headers = ($e instanceof HttpExceptionInterface) ? $e->getHeaders() : [];

             return response()->json($response, $statusCode, $headers);
        });
    })->create();
