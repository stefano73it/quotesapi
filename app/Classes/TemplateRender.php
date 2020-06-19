<?php

namespace App\Classes;

class TemplateRender {
	private $template;
	private $vars = array();

	public function __construct($template) {
		$this->template = $template;
	}

	/*
	 * an array of variables that will be used in the template
	 */
	public function setVars($vars) {
		$this->vars = $vars;
	}

	/*
	 * build the template output
	 */
	public function output() {
		$templateFile = 'resources/templates/' .$this->template. '.tpl.php';

		ob_start();

		foreach ($this->vars as $k => $v) {
			${$k} = $v;
		}

		include($templateFile);

		return ob_get_clean();
	}
}