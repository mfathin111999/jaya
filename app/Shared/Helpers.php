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

function integerToRoman($integer)
    {
    	
		$integer = intval($integer);
		$result = '';

		$lookup = array(
			'X' 	=> 10,
			'IX' 	=> 9,
			'V' 	=> 5,
			'IV' 	=> 4,
			'I' 	=> 1
		);

		foreach($lookup as $roman => $value){

		$matches = intval($integer/$value);

		$result .= str_repeat($roman,$matches);

		$integer = $integer % $value;
		}

		return $result;
}

?>