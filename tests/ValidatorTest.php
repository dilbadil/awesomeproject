<?php
require_once "vendor/autoload.php";

use Core\Validator;

class ValidatorTest extends PHPUnit_Framework_TestCase
{

	protected $input = [
		"name" => "Abdillah Abdi",
		"birthdate" => "2010-07-08",
		"email" => "v@gmail.com",
	];

	protected $rules = [
		"name" => "string|length:4,25|notEmpty",
		"birthdate" => "date|length:2|notEmpty|noWhitespace",
		"email" => "email|length:20|notEmpty|noWhitespace",
	];

	protected $validator;

	function __construct()
	{
		$messages = array(
			"email" => "{{input}} harus berupa valid email",
			"length" => "{{input}} kurang panjang"
		);
		$this->validator = new Validator($this->input, $this->rules, $messages);
	}

	// public function test_return_input_mustbe_array()
	// {
	// 	$this->assertInternalType('array', $this->validator->getInput());
	// }

	// public function test_do_validate()
	// {
	// 	$this->assertTrue($this->validator->validate());
	// }

	public function test_get_errors()
	{
		// $this->validator->setAttributeInput("email", "yap");
		$this->validator->setAttributeInput("name", "jox");
		$this->assertFalse($this->validator->validate());
		$messages = $this->validator->messages();
		$this->assertFalse($this->validator->success());
		$this->assertTrue($this->validator->fails());
		$this->assertInternalType('array', $messages);
		$this->assertEquals(6, count($messages));
		echo "messages<pre>" . print_r($messages, 1) . "</pre>";
	}

	// public function test_get_merged_rules()
	// {	
	// 	$testMergedValues = array("string", "length", "notEmpty", "email", "date", "noWhitespace");
	// 	$mergedRules = $this->validator->getMergedRules();
	// 	$this->assertSame(array_diff($mergedRules, $testMergedValues), array_diff($testMergedValues, $mergedRules));
	// 	$this->assertInternalType('array', $mergedRules);
	// 	$this->assertEquals(6, count($mergedRules));
	// }
}