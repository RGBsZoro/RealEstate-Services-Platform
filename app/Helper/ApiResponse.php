<?php

function successResponse($data = [], $message = 'success')
{
    return response()->json([
        'message' => $message,
        'data' => $data
    ]);
}

function errorResponse($message, $data = [], $code = 400)
{
    return response()->json([
        'message' => $message,
        'data' => $data
    ], $code);
}
