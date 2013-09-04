<?php

namespace silverorange\TracShift\Data;

class HierarchyException extends RuntimeException implements Exception
{
	protected $tree = null;
	protected $node = null;

	public function __construct($message, $code, Node $tree, Node $node)
	{
		parent::__construct($message, $code);
		$this->tree = $tree;
		$this->node = $node;
	}

	public function getNode()
	{
		return clone $this->node;
	}

	public function getTree()
	{
		return clone $this->tree;
	}
}
