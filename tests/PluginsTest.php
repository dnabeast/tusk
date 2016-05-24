<?php

use Typesaucer\Tusk\Plugins;

class MenuTest extends PHPUnit_Framework_TestCase
{

    public function test_if_a_tusk_is_replaced_with_a_plugin_file()
    {
        $string = 'Lorem ipsum [[- dolorhtml.php -]]';
        $expected = 'Lorem ipsum replacement';

        $this->assertEquals( (new Plugins)->tusk($string, 'tests/plugins/lib/'), $expected);

        $string = 'Lorem ipsum [[- dolor.php -]]';
        $expected = 'Lorem ipsum HTML bit replacement php';
        $this->assertEquals( (new Plugins)->tusk($string, 'tests/plugins/lib/'), $expected);
    }

    public function test_if_the_extension_to_the_name_is_correct()
    {
        $name = 'bros.fine.html';
        $this->assertEquals((new Plugins)->extension($name), 'html');
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
