<?php

/**
* ApiController.php
* Gousto API Test
*
* Created by Sezer Tunca on 24/09/2016.
* Copyright © 2016 Sezer Tunca. All rights reserved.
* Created for Gousto.
*/

namespace App\Http\Controllers\v1;

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

    /**
     * @param  $message
     * @return mixed
     */
    public function respondNotFound($message = 'Not found')
    {
    	return $this->setStatusCode(404)->responseWithError($message);
    }

     /**
     * @param  $message
     * @return mixed
     */
    public function respondValidationError($message = 'Could not validate')
    {
        return $this->setStatusCode(403)->responseWithError($message);
    }

    /**
     * @param  [type]
     * @param  array
     * @return response JSON
     */
    public function respond($data, $headers = [])
    {
    	return response()->json($data, $this->getStatusCode(), $headers);
    }

    /**
     * @param  $message
     * @return mixed
     */
    public function responseWithError($message)
    {
    	return $this->respond([
			"error" => [ 
				"message" => $message,
				'status_code' => $this->statusCode]
		]);
    }

}








