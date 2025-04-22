<?php

namespace Cyaxaress\Common\Responses;

use Illuminate\Http\Response;

class AjaxResponses
{
    public static function SuccessResponse()
    {
        return response()->json(['message' => 'Operation completed successfully.'], Response::HTTP_OK);
    }

    public static function FailedResponse()
    {
        return response()->json(['message' => 'The operation was not successful!'], Response::HTTP_INTERNAL_SERVER_ERROR);
    }
}
