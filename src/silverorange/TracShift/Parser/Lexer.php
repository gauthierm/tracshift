<?php

namespace silverorange\TracShift\Parser;

class Lexer
{
	protected static $tokenTypes = array(
		'\n\n'      => Token::DOUBLE_NEWLINE,
		'\n'        => Token::NEWLINE,
		'  '        => Token::DOUBLE_SPACE,
		'>'         => Token::CITATION,
		'\'\'\''    => Token::STRONG,
		'\'\''      => Token::EM,
		'~~'        => Token::STRIKE,
		'\^'        => Token::SUPER,
		',,'        => Token::SUB,
		'__'        => Token::UNDERLINE,
		'`'         => Token::PRE,
		'\|\|'      => Token::TABLE,
		'\{\{\{'    => Token::PRE_START,
		'\}\}\}'    => Token::PRE_END,
		'!'         => Token::ESCAPE,
		'\[\['      => Token::MACRO_START,
		'\]\]'      => Token::MACRO_END,
		'\['        => Token::LINK_START,
		'\]'        => Token::LINK_END,
		' [*-] '    => Token::UNORDERED_LIST,
		' [0-9]+. ' => Token::ORDERED_LIST,
		'::'        => Token::DOUBLE_COLON,
		'----'      => Token::LINE,
		'====='     => Token::HEADER5,
		'===='      => Token::HEADER4,
		'==='       => Token::HEADER3,
		'=='        => Token::HEADER2,
		'='         => Token::HEADER1,
	);

	public function getTokens($string)
	{

		$expression = '/(' . implode('|', array_keys(self::$tokenTypes)) . ')/s';

		$rawTokens = preg_split(
			$expression,
			$string,
			-1,
			PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
		);

		$tokens = array();

		foreach ($rawTokens as $rawToken) {
			$tokens[] = $this->getToken($rawToken);
		}

		return $tokens;
	}

	protected function getToken($rawToken)
	{
		$type = Token::TEXT;

		foreach (self::$tokenTypes as $expression => $tokenType) {
			if (preg_match('/^' . $expression . '$/', $rawToken) === 1) {
				$type = $tokenType;
				break;
			}
		}

		return new Token($type, $rawToken);
	}
}
