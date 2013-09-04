<?php

namespace silverorange\TracShift\Data;

class Node_Link extends Node
{
	protected $uri = '';
	protected $title = '';

	public function __construct($name, $uri, $title = '')
	{
		parent::__construct($name);
		$this->uri = $uri;
		$this->title = $title;
	}

	public function getURI()
	{
		return $this->uri;
	}

	public function getTitle()
	{
		return $this->title;
	}
}
