<?php


namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

class BaseController extends Controller
{

    public function sendResponse(array $result, $message = null)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => (isset($message) ? $message : 'message'),
        ];

        return response()->json($response, 200);
    }


    public function sendError($error, $errorMessages = [])
    {
        $response = [
            'success' => false,
            'message' => $error,
        ];

        if (!empty($errorMessages)) {
            $response['data'] = $errorMessages;
        }
        return response()->json($response);

    }

}
