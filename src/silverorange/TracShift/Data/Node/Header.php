<?php

namespace silverorange\TracShift\Data;

class Node_Header extends Node
{
	protected $level = 1;

	public function __construct($name, $level = 1)
	{
		parent::__construct($name);
		$this->level = $level;
	}

	public function getLevel()
	{
		return $this->level;
	}
}
