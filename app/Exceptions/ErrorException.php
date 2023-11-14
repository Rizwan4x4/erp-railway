<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class ErrorException extends Exception
{
    /**
     * Report or log the exception.
     *
     * @return void
     */
    public function report()
    {
        // Log the exception message
        Log::error('Custom Exception: ' . $this->getMessage());
    }

    /**
     * Render the exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function render($request)
    {
        // Return a custom response for the exception
        return response()->json([
            'error' => $this->getMessage()
        ], 500);
    }
}
