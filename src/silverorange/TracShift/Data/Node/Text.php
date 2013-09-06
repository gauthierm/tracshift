<?php

namespace silverorange\TracShift\Data;

class Node_Text extends Node
{
	protected $text = '';

	public function __construct($name, $text)
	{
		parent::__construct($name);
		$this->text = $text;
	}

	public function getText()
	{
		return $this->text;
	}
}
