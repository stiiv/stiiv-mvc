<?php

class Test extends Controller {
	
	public function index() {
		$this->title($this->view->lang->message->welcome);
		$this->data('lang_nav::'.$this->view->lang_html_links);
		$this->_DBcheck();
		$this->view->render('test_view', false);
	}

	protected function _DBcheck() {
		if(DB_NAME == "") {
			$this->data(array(
				"class" => "error",
				"change_db" => $this->view->lang->message->noDB
			));
		} else {
			$this->data(array(
				"class" => "success",
				"change_db" => $this->view->lang->message->DBselected." ".DB_NAME
			));
		}
	}

}

