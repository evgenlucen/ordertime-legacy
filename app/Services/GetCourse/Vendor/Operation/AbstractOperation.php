<?php

namespace App\Services\GetCourse\Vendor\Operation;


use App\Services\GetCourse\Vendor\GetcourseClient;
use App\Services\GetCourse\Vendor\Response;


class AbstractOperation
{
	/**
	 * @var GetcourseClient
	 */
	private $client;

	public function __construct(GetcourseClient $client)
	{
		$this->client = $client;
	}

	protected function call(string $endpoint, string $action = null, array $params = [], string $method = 'POST'): Response
	{
		return $this->client->request($endpoint, $action, $params, $method);
	}
}
