<?php

namespace silverorange\TracShift\Data;

class Node
{
	protected $name = '';
	protected $parent = null;
	protected $children = array();

	public function __construct($name)
	{
		$this->name = $name;
	}

	public function getName()
	{
		return $this->name;
	}

	public function getParent()
	{
		return $this->parent;
	}

	public function add(Node $node)
	{
		$parent = $this;
		while ($parent instanceof Node) {
			if ($parent === $node) {
				throw new HierarchyException(
					'Can not add ' . $node . ' to '. $this . ' without '
					. 'introducing a graph cycle.',
					0,
					clone $this,
					clone $node
				);
			}
			$parent = $parent->getParent();
		}

		if (!in_array($node, $this->children)) {
			$this->children[] = $node;
			$node->parent = $this;
		}

		return $this;
	}

	public function remove(Node $node)
	{
		$this->children = array_diff(
			$this->children,
			array($node)
		);

		$node->parent = null;

		return $node;
	}

	public function getChildren()
	{
		return $this->children;
	}

	public function __toString()
	{
		return $this->toStringRecursive();
	}

	public function __clone()
	{
		$children = array();
		foreach ($this->children as $child) {
			$clone = clone $child;
			$clone->parent = $this;
			$children[] = $clone;
		}
		$this->children = $children;
	}

	protected function toStringRecursive($depth = 0)
	{
		$string = str_repeat('  ', $depth) . $this->getName() . PHP_EOL;

		foreach ($this->getChildren() as $child) {
			$string .= $child->toStringRecursive($depth + 1);
		}

		return $string;
	}
}
