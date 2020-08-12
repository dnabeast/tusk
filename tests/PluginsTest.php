<?php

use DNABeast\Tusk\Plugins;
use PHPUnit\Framework\TestCase;

class PluginsTest extends TestCase
{

	public function test_if_a_tusk_is_replaced_with_a_plugin_file()
	{
		$string = 'Lorem ipsum [[- dolorhtml -]]';
		$expected = 'Lorem ipsum replacement';

		$this->assertEquals( (new Plugins)->tusk($string, 'tests/plugins/lib/'), $expected);

		$string = 'Lorem ipsum [[- dolor -]]';
		$expected = 'Lorem ipsum HTML bit replacement php';
		$this->assertEquals( (new Plugins)->tusk($string, 'tests/plugins/lib/'), $expected);
	}


	public function test_for_unfound_plugin_creates_new_plugin()
	{
		$string = 'Lorem ipsum [[- plugindoesntexist -]] ?? [[- plugindoesntexist2 -]]';
		(new Plugins)->tusk($string, 'tests/plugins/lib/');
		$plugins = array_diff(scandir('tests/plugins/lib/'), array('..', '.', '.DS_Store')); // get file list

		$this->assertContains( 'plugindoesntexist.php', $plugins);
		$this->assertContains( 'plugindoesntexist2.php', $plugins);

		unlink('tests/plugins/lib/plugindoesntexist.php');
		unlink('tests/plugins/lib/plugindoesntexist2.php');

	}


}
