<?php

class Test extends Controller {
	
	public function index() {
		$this->view->title = 'Test title';
		$this->view->data['subtitle'] = 'Test subtitle';
		$this->view->data['body'] = 'Hello, in order to begin, we need to test this.';
		$this->view->render('test_view', false);
	}

}

