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

		$this->createNewPlugins($string, $pluginDir);

		return $string;
	}


	public function replaceWithPlugins($string, $plugins, $pluginDir){

		foreach ($plugins as $pluginName)
		{
			ob_start();
			include($pluginDir.$pluginName);
			$plugin = ob_get_contents();
			ob_end_clean();
			$string = str_replace('[[- '.substr($pluginName, 0, -4).' -]]', $plugin, $string);
		}
		return $string;
	}

	public function pluginList($string, $pluginDir){
		$plugins = array_diff(scandir($pluginDir), array('..', '.', '.DS_Store')); // get file list

		return $plugins;
	}

	public function createNewPlugins($string, $pluginDir){
		preg_match_all('/(?<=\[\[\-\s).*?(?=\s\-\]\])/', $string, $matches);

		foreach ($matches[0] as $match) {
			file_put_contents($pluginDir.$match.".php",'
< ?php
	use App\Gallery\Gallery;
	$view = (new Gallery("'.$match.'"))->make();
	echo $view->render();
?>

				');
		}

	}

}