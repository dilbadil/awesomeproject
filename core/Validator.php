<?php
namespace Core;

use Respect\Validation\Validator as v;

class Validator 
{

	/**
	 * @var array $messages
	 */
	protected $messages;

	/**
	 * @var bool $status
	 */
	protected $status;

	/**
	 * @var array $input
	 */
	protected $input;

	/**
	 * @var array $rules
	 */
	protected $rules;

	/**
	 * @var array $mergedRules
	 */
	protected $mergedRules;

	function __construct($input, $rules, $messages = array())
	{
		$this->input = convertArray($input);
		$this->rules = $rules;
		$this->mergeRules();
		$this->messages = $messages;
	}

	/**
	 * Do validate
	 * 
	 * @return bool
	 */
	public function validate()
	{
		$rules = $this->cleanRules();

		$keyForInput = 0;

		foreach ($this->input as $attribute => $inputVal)
		{
			if (! isset($rules[$attribute])) continue;

			$keyForRule = 0;

			foreach ($rules[$attribute] as $rule)
			{
				if ($keyForRule == 0)
					$methodObject = new v();
				else
					$methodObject = $methodExecution;

				$methodExecution = call_user_func_array(
					array($methodObject, $rule["method"]), 
					$rule["params"]
				);

				$keyForRule ++;
			}

			if ($keyForInput == 0)
				$validatorObject = new v();
			else
				$validatorObject = $validator;

			$validator = call_user_func_array(
				array($validatorObject, "key"), 
				array($attribute, $methodExecution)
			);

			$keyForInput ++;
		}

		$this->catchExecution($validator);	

		return $validator->validate($this->input);
	}

	protected function catchExecution($validator)
	{
		try {
		    $this->status = $validator->assert($this->input);
		}
		catch (\InvalidArgumentException $e) {
			$this->messages = $e->findMessages($this->getCustomMessages());
		}
	}

	/**
	 * Clean rules
	 * 
	 * @param array $rules
	 * @return array
	 */
	private function cleanRules()
	{
		$result = array();

		foreach ($this->rules as $ruleKey => $ruleVal)
		{
			$ruleExp = explode("|", $ruleVal);

			foreach ($ruleExp as $ruleSubKey => $ruleSub)
			{
				$params = array();
				$method = $ruleSub;

				if (contains($ruleSub, ":"))
				{
					$methodExp = explode(':', $ruleSub);
					$method = $methodExp[0];
					$params = explode(",", $methodExp[1]);
				}

				$result[$ruleKey][] = array(
					'method' => $method,
					'params' => $params,
				);
			}

		}

		return $result;
	}

	/**
	 * Merge rules
	 * 
	 * @return mixed
	 */
	protected function mergeRules()
	{
		$rules = $this->cleanRules();

		foreach ($rules as $attribute => $subRules)
		{
			$methods = array_map(function($element) {
				return $element['method'];
			}, $subRules);

			$merges = isset($merges) ? array_merge($merges, $methods) : $methods;
		}

		$mergedRules = array_keys(array_flip($merges));

		$messages = $this->messages;

		$this->mergedRules = $mergedRules;
	}

	/**
	 * Get custom merged rules
	 * 
	 * @return array
	 */
	public function getCustomMessages()
	{
		$mergedRules = $this->mergedRules;
		$messages = $this->messages;
		$result = array();
		
		foreach ($mergedRules as $key => $val)
		{
			if (isset($messages[$val]))
			{
				$key = $val;
				$val = $messages[$val];
			}

			$result[$key] = $val;
		}

		return $result;
	}

	/**
	 * Get merged rules
	 * 
	 * @return array
	 */
	public function getMergedRules()
	{
		return $this->mergedRules;
	}

	/**
	 * Get rules
	 * 
	 * @return array
	 */
	public function getRules()
	{
		return $this->rules;
	}

	/**
	 * Get input
	 * 
	 * @return array
	 */
	public function getInput()
	{
		return $this->input;
	}

	/**
	 * Set the attribute of rules
	 * 
	 * @param $Key
	 * @param $value
	 * @return mixed
	 */
	public function setAttributeRules($key, $value)
	{
		$this->rules[$key] = $value;

		return $this;
	}

	/**
	 * Set the attribute of input
	 * 
	 * @param $Key
	 * @param $value
	 * @return mixed
	 */
	public function setAttributeInput($key, $value)
	{
		$this->input[$key] = $value;

		return $this;
	}

	/**
	 * Get messages of validation
	 * 
	 * @return array
	 */
	public function messages()
	{
		return $this->messages;
	}

	/**
	 * Determine valdation error or not
	 * 
	 * @return bool
	 */
	public function fails()
	{
		return ($this->status == false ? true : false);
	}

	/**
	 * Determine valdation success or not
	 * 
	 * @return bool
	 */
	public function success()
	{
		return ($this->status == true ? true : false);
	}

}
