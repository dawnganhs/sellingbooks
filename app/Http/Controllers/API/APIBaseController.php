<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller as Controller;

class APIBaseController extends Controller
{
    public function sendData($result)
    {
        $response = [
            'data' => $result,
        ];
        return response()->json($response, 200);
    }

    public function sendResponse($result, $message)
    {
        $response = [
            'success' => true,
            'data' => $result,
            'message' => $message,
        ];
        return response()->json($response, 200);
    }
    public function sendError($error, $errorMessages = [], $code = 401)
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
    public function sendMessage($message)
    {
        $response = [
            'message' => $message,
        ];

        return response()->json($response, 200);
    }
}
