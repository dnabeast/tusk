<?php

namespace Typesaucer\Tusk;

/**
*
*/
class Plugins
{

	public function tusk($string, $pluginDir = null) {
		if (!$pluginDir) { $pluginDir = app_path().'/Plugins/lib/'; }

		$pluginList = $this->pluginList($string, $pluginDir);
		$string = $this->replaceWithPlugins($string, $pluginList, $pluginDir);

		return $string;
	}

	public function extension($name){
		$array = explode('.', $name);
		return array_pop($array);
	}

	public function replaceWithPlugins($string, $plugins, $pluginDir){

		foreach ($plugins as $pluginName)
		{
			if ($this->extension($pluginName) == 'html') {
				$plugin = file_get_contents($pluginDir.$pluginName);
			}
			if ($this->extension($pluginName) == 'php') {
				$plugin = include($pluginDir.$pluginName);
			}

			$string = str_replace('[[- '.$pluginName.' -]]', $plugin, $string);
		}
		return $string;
	}

	public function pluginList($string, $pluginDir){
		$plugins = array_diff(scandir($pluginDir), array('..', '.')); // get file list

		return $plugins;
	}

}