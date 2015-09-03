<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ExampleTest extends TestCase
{

	protected $baseUrl = 'http://caliente.dev';

	/**
	 * A basic functional test example.
	 *
	 * @test
	 *
	 * @return void
	 */
	public function basicExample()
	{
		$this->visit('/')
			->see('Staff Directory');
	}
}
