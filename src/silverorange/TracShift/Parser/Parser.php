<?php

namespace silverorange\TracShift;

class Parser
{
	public function parse($string)
	{
		$tokens = array(
			'[[',
			'[',
			']]',
			']',
			'||',
			'!',
			'=====',
			'====',
			'===',
			'==',
			'=',
			'\'\'\'\'\'',
			'\'\'\'',
			'\'\'',
			'__',
			'`',
			'~~',
			'^',
			',,'
			'^\s+*',
			'{{{',
			'}}}',
			'::',
		$tokens = '/()/
	}
}
