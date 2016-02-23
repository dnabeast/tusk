<?php

use Typesaucer\Tusk\Plugins;

class MenuTest extends PHPUnit_Framework_TestCase
{

    public function test_if_a_tusk_is_replaced_with_a_plugin_file()
    {
        $string = 'Lorem ipsum [[- dolor.html -]]';
        $expected = 'Lorem ipsum replacement';

        $this->assertEquals( (new Plugins)->tusk($string, 'tests/plugins/lib/'), $expected);

        $string = 'Lorem ipsum [[- dolor.php -]]';
        $expected = 'Lorem ipsum replacement php';
        $this->assertEquals( (new Plugins)->tusk($string, 'tests/plugins/lib/'), $expected);
    }

    public function test_if_the_extension_to_the_name_is_correct()
    {
        $name = 'bros.fine.html';
        $this->assertEquals((new Plugins)->extension($name), 'html');
    }

}
