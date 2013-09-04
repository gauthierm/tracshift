<?php

namespace silverorange\TracShift\Data;

class Node_Pre extends Node
{
	protected $language = '';

	public function __construct($name, $language = '')
	{
		parent::__construct($name);
		$this->language = $language;
	}

	public function getLanguage()
	{
		return $this->language;
	}
}
