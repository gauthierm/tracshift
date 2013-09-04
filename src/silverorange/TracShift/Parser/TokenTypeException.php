<?php

namespace silverorange\TracShift\Parser;

class TokenTypeException extends InvalidArgumentException implements Exception
{
	protected $type = 0;

	public function __construct($message, $code, $type)
	{
		parent::__construct($message, $code);
		$this->type = $type;
	}

	public function getType()
	{
		return clone $this->type;
	}
}
