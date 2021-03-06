<?php

namespace App\Http\Controllers\Api;

use Response;
use \Illuminate\Http\Response as Res;

/**
 * Class ApiController
 * @package App\Modules\Api\Lesson\Controllers
 */
class ResponseController extends \App\Http\Controllers\Controller
{
	/**
	 * @var int
	 */
	protected $statusCode = Res::HTTP_OK;
	/**
	 * @return mixed
	 */
	public function getStatusCode()
	{
		return $this->statusCode;
	}
	/**
	 * @param $message
	 * @return json response
	 */
	public function setStatusCode($statusCode)
	{
		$this->statusCode = $statusCode;

		return $this;
	}

	public function respondCreated($message, $data = null)
	{
		return $this->respond([
			'status' => 'success',
			'status_code' => Res::HTTP_CREATED,
			'message' => $message,
			'data' => $data
		]);
	}

	public function respondWithSuccess($data = [], $message = 'Success!')
	{
		return $this->respond([
			'status' => 'success',
			'status_code' => Res::HTTP_OK,
			'message' => $message,
			'data' => $data
		]);
	}

	public function respondNotFound($message = 'Not Found!')
	{
		return $this->respond([
			'status' => 'error',
			'status_code' => Res::HTTP_NOT_FOUND,
			'message' => $message,
		]);
	}

	public function respondInternalError($message)
	{
		return $this->respond([
			'status' => 'error',
			'status_code' => Res::HTTP_INTERNAL_SERVER_ERROR,
			'message' => $message,
		]);
	}

	public function respondValidationError($errors)
	{
		return $this->respond([
			'status' => 'error',
			'status_code' => Res::HTTP_UNPROCESSABLE_ENTITY,
			'message' => 'validation',
			'data' => $errors
		]);
	}

	public function respond($data, $headers = [])
	{
		return Response::json($data, $this->getStatusCode(), $headers);
	}

	public function respondWithError($message)
	{
		return $this->respond([
			'status' => 'error',
			'status_code' => Res::HTTP_UNAUTHORIZED,
			'message' => $message,
		]);
	}
}