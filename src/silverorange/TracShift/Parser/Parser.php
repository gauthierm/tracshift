<?php

namespace silverorange\TracShift\Parser;

class Parser
{
	protected $lexer = null;

	public function __construct(Lexer $lexer = null)
	{
		if (!$lexer instanceof Lexer) {
			$lexer = new Lexer();
		}

		$this->setLexer($lexer);
	}

	public function setLexer(Lexer $lexer)
	{
		$this->lexer = $lexer;
	}

	public function parse($string)
	{
		foreach ($this->lexer->getTokens($string) as $token) {
			echo $token, "\n";
		}
	}

	public function parseFile($filename)
	{
		return $this->parse(file_get_contents($filename));
	}
}
