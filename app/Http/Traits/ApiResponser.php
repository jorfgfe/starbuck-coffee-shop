<?php 


namespace App\Http\Traits;

use Illuminate\Http\JsonResponse;
trait ApiResponser
{
    public function successResponse(array $message, int $code = 200): JsonResponse 
    {
        info('Response sent successfully: ', $message);

        return response()->json($message, $code);
    }

    public function errorResponse(array $error, int $code = 500): JsonResponse 
    {
        info('Error handled successfully: ', $error);
        return response()->json($error, $code);
    }
}
