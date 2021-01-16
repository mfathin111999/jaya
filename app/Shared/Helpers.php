<?php
/**
 * Response API for apps is need array format, so this is the builder
 *
 * @param int $statusCode
 * @param array $data
 *
 * @return \Illuminate\Http\JsonResponse
 */

function apiResponseBuilder($statusCode = 500, $data = [], $msg = "Oke")
{
    return response()->json([
        'status_code' 	=> $statusCode,
        'data' 			=> $data,
        'message' 		=> $msg,
    ], $statusCode);
}

?>