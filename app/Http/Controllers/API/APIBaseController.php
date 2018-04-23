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
    public function sendError($error, $errorMessages = [], $code = 404)
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
    // function stripUnicode($str){
    //     if(!$str) return false;
    //      $unicode = array(
    //         'a'=>'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
    //         'd'=>'đ',
    //         'e'=>'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
    //         'i'=>'í|ì|ỉ|ĩ|ị',
    //         'o'=>'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
    //         'u'=>'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
    //         'y'=>'ý|ỳ|ỷ|ỹ|ỵ',
    //      );
    //   foreach($unicode as $nonUnicode=>$uni) $str = preg_replace("/($uni)/i",$nonUnicode,$str);
    //   return $str;
    //   }
}
