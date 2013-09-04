<?php

namespace silverorange\TracShift\Parser;

class Token
{
	const TEXT = 1;

	const DOUBLE_NEWLINE = 2;
	const NEWLINE = 3;
	const DOUBLE_SPACE = 4;
	const CITATION = 5;

	const STRONG = 6;
	const EM = 7;
	const STRIKE = 8;
	const SUPER = 9;
	const SUB = 10;
	const UNDERLINE = 11;
	const PRE = 12;

	const TABLE = 13;

	const PRE_START = 14;
	const PRE_END = 15;

	const ESCAPE = 16;

	const MACRO_START = 17;
	const MACRO_END = 18;

	const LINK_START = 19;
	const LINK_END = 20;

	const UNORDERED_LIST = 21;
	const ORDERED_LIST = 22;
	const DOUBLE_COLON = 23;

	const LINE = 24;

	const HEADER5 = 25;
	const HEADER4 = 26;
	const HEADER3 = 27;
	const HEADER2 = 28;
	const HEADER1 = 29;

	public static $tokenNameMap = array(
		Token::TEXT           => 'TEXT',
		Token::DOUBLE_NEWLINE => 'DOUBLE_NEWLINE',
		Token::NEWLINE        => 'NEWLINE',
		Token::DOUBLE_SPACE   => 'DOUBLE_SPACE',
		Token::CITATION       => 'CITATION',
		Token::STRONG         => 'STRONG',
		Token::EM             => 'EM',
		Token::STRIKE         => 'STRIKE',
		Token::SUPER          => 'SUPER',
		Token::SUB            => 'SUB',
		Token::UNDERLINE      => 'UNDERLINE',
		Token::PRE            => 'PRE',
		Token::TABLE          => 'TABLE',
		Token::PRE_START      => 'PRE_START',
		Token::PRE_END        => 'PRE_END',
		Token::ESCAPE         => 'ESCAPE',
		Token::MACRO_START    => 'MACRO_START',
		Token::MACRO_END      => 'MACRO_END',
		Token::LINK_START     => 'LINK_START',
		Token::LINK_END       => 'LINK_END',
		Token::UNORDERED_LIST => 'UNORDERED_LIST',
		Token::ORDERED_LIST   => 'ORDERED_LIST',
		Token::DOUBLE_COLON   => 'DOUBLE_COLON',
		Token::LINE           => 'LINE',
		Token::HEADER5        => 'HEADER5',
		Token::HEADER4        => 'HEADER4',
		Token::HEADER3        => 'HEADER3',
		Token::HEADER2        => 'HEADER2',
		Token::HEADER1        => 'HEADER1',
	);

	protected $type = self::TEXT;
	protected $content = '';

	public function __construct($type, $content)
	{
		if (!isset(self::$tokenNameMap[$type])) {
			throw new TokenTypeException(
				'There is no token type ' . $type . '.',
				0,
				$type
			);
		}

		$this->type = $type;
		$this->content = $content;
	}

	public function getType()
	{
		return $this->type;
	}

	public function getContent()
	{
		return $this->content;
	}

	public function __toString()
	{
		return self::$tokenNameMap[$this->type]
			. ' :: ' . addcslashes($this->content, "\r\n\t");
	}
}
