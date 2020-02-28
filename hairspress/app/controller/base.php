<?php

namespace Hairspress\App;

use Hairspress\Core\Controller;
use Hairspress\Core\View;

class Controller_Base extends Controller
{
	public function before()
	{
		parent::before();

		$this->template->nav_flag = false;

		$this->template->content = '';
		$this->template->sidebar = '';
	}

	public function after()
	{
		$this->template->header = View::forge('elements/header', $this->template);
		$this->template->footer = View::forge('elements/footer', $this->template);

		return $this->template;
	}
}