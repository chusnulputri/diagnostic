<?php

namespace App\Helpers;

use Illuminate\Http\Response;

class CatchErrorResponse
{

    public function responses($code, $message,$data = [])
    {
        return response()->json([
            'status' => $code == 200 ? 'success' :'error',
            'message' => $message,
            'data' => $data
        ], $code);
    }
    public function simpleCatch($exception, $additional = [])
    {
        $code = $exception->getCode();
        $message = $exception->getMessage();
        switch ($code) {
            case 400:
                return $this->responses(Response::HTTP_BAD_REQUEST, $message);
                break;
            case 401:
                return $this->responses(Response::HTTP_UNAUTHORIZED, $message);
                break;
            case 404:
                return $this->responses(Response::HTTP_NOT_FOUND, $message);
                break;
            case 409:
                return $this->responses(Response::HTTP_CONFLICT, $message);
                break;
            case 422:
                return $this->responses(Response::HTTP_UNPROCESSABLE_ENTITY, $message);
                break;
            case 403:
                return $this->responses(Response::HTTP_FORBIDDEN, $message);
                break;
            case 402:
                return $this->responses(Response::HTTP_PAYMENT_REQUIRED, $message);
                break;
            default:
                return $this->responses(Response::HTTP_INTERNAL_SERVER_ERROR, $message);
                break;
        }
    }

    public function success($message = 'Data berhasil disimpan',$data = [])
    {
        return $this->responses(Response::HTTP_OK, $message,$data);
    }
}
