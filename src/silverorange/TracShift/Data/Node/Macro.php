<?php

namespace silverorange\TracShift\Data;

class Node_Macro extends Node
{
	protected $function = '';
	protected $arguments = '';

	public function __construct($name, $function, $arguments = '')
	{
		parent::__construct($name);
		$this->function = $function;
		$this->arguments = $arguments;
	}

	public function getFunction()
	{
		return $this->function;
	}

	public function getArguments()
	{
		return $this->arguments;
	}
}
