<?php

class ExampleTest extends TestCase {

	/**
	 * A basic functional test example.
	 *
	 * @return void
	 */
	public function testBasicExample()
	{
		$response = $this->call('GET', '/');

		$this->assertEquals(302, $response->getStatusCode()); 
		// revisar este assert, en realidad devolvia 200
	}

}
