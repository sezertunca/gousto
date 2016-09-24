<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class ApiController extends Controller
{
    protected $statusCode = 200;

    /**
     * Gets the value of statusCode.
     *
     * @return mixed
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * Sets the value of statusCode.
     *
     * @param mixed $statusCode the status code
     *
     * @return self
     */
    protected function setStatusCode($statusCode)
    {
        $this->statusCode = $statusCode;

        return $this;
    }

    public function respondNotFound($message = 'Not found')
    {
    	return $this->setStatusCode(404)->responseWithError($message);
    }

    public function response($data, $headers = [])
    {
    	return response()->json($data, $this->getStatusCode(), $headers);
    }

    public function responseWithError($message)
    {
    	return $this->response([
				"error" => [ 
					"message" => $message,
					'status_code' => $this->statusCode]]);
    }

}








