<?php
namespace Hairspress\Core;

class Controller
{
	protected $template;

	public function before()
	{
		$this->template = new \stdClass();
	}

	public function after()
	{
		return $this->template;
	}
}