<?php

namespace silverorange\TracShift\Parser;

use silverorange\TracShift\Data\Node as Node;
use silverorange\TracShift\Data\Node_Text as Node_Text;

class Parser
{
	protected $lexer = null;
	protected $tree = null;
	protected $currentNode = null;

	protected $inlineState = array(
		'strong'    => false,
		'em'        => false,
		'strike'    => false,
		'super'     => false,
		'sub'       => false,
		'underline' => false,
		'pre'       => false,
	);

	protected $inCode = false;
	protected $skipNext = false;

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
		$this->reset();

		$tokens = $this->lexer->getTokens($string);

		while (count($tokens) > 0) {
			$this->tree->add($this->parseRecursive());
		}

		return $this->tree;
	}

	public function parseRecursive(array &$tokens)
	{
		$token = array_shift($tokens);
		$node = $this->parseToken($token);

		return $node;
	}

	public function parseFile($filename)
	{
		return $this->parse(file_get_contents($filename));
	}

	protected function reset()
	{
		$this->inlineState = array(
			'strong'    => false,
			'em'        => false,
			'strike'    => false,
			'super'     => false,
			'sub'       => false,
			'underline' => false,
			'pre'       => false,
		);

		$this->tree = new Node('document');
		$this->currentNode = $this->tree;
	}

	protected function parseToken(Token $token)
	{
		if ($this->skipNext) {
			$this->skipNext = false;
			$this->parseTextToken($token);
		} else {
			switch ($token->getType()) {
			case Token::TEXT:
				$this->parseTextToken($token);
				break;

			case Token::DOUBLE_NEWLINE:
				if ($this->inParagraph) {
					$this->inParagraph = false;
				}
				$this->isLineStart = true;
				break;

			case Token::NEWLINE:
				$this->isLineStart = true;
				break;

			case Token::DOUBLE_SPACE:
				break;
			case Token::CITATION:
				break;
			case Token::STRONG:
				$this->parseInlineToken($token, 'strong');
				break;

			case Token::EM:
				$this->parseInlineToken($token, 'em');
				break;

			case Token::STRIKE:
				$this->parseInlineToken($token, 'strike');
				break;

			case Token::SUPER:
				$this->parseInlineToken($token, 'super');
				break;

			case Token::SUB:
				$this->parseInlineToken($token, 'sub');
				break;

			case Token::UNDERLINE:
				$this->parseInlineToken($token, 'underline');
				break;

			case Token::PRE:
				$this->parseInlineToken($token, 'pre');
				break;

			case Token::TABLE:
				break;

			case Token::PRE_START:
				if ($this->inCode) {
					$this->parseTextToken($token);
				} else {
					$this->inCode = true;
					$node = new Node('pre');
					$this->currentNode->add($node);
					$this->currentNode = $node;
				}
				break;

			case Token::PRE_END:
				if ($this->inCode) {
					$this->inCode = false;
					$this->currentNode = $this->currentNode->getParent();
				} else {
					$this->parseTextToken($token);
				}
				break;

			case Token::ESCAPE:
				$this->skipNext = true;
				break;

			case Token::MACRO_START:
				break;
			case Token::MACRO_END:
				break;
			case Token::LINK_START:
				break;
			case Token::LINK_END:
				break;
			case Token::UNORDERED_LIST:
				break;
			case Token::ORDERED_LIST:
				break;
			case Token::DOUBLE_COLON:
				break;
			case Token::LINE:
				break;
			case Token::HEADER5:
			case Token::HEADER4:
			case Token::HEADER3:
			case Token::HEADER2:
			case Token::HEADER1:
				break;
			}
	}

	protected function parseTextToken(Token $token)
	{
		$this->currentNode->add(new Node_Text('text', $token->getContent()));
	}

	protected function parseInlineToken(Token $token, $name)
	{
		if ($this->inCode) {
			$this->parseTextToken($token);
		} else {
			if ($this->inlineState[$name]) {

				$this->inlineState[$name] = false;
				$node = $this->currentNode;
				while ($node->getName() != $name) {
					$node = $node->getParent();
				}
				$this->currentNode = $node->getParent();

				// TODO handle bad nesting, also required for parsing '''''.
			} else {
				$this->inlineState[$name] = true;
				$node = new Node($name);
				$this->currentNode->add($node);
				$this->currentNode = $node;
			}
		}
	}
}
