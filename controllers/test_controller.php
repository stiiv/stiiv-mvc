<?php

class Test extends Controller {
	
	public function index() {
		$this->title('Test title');
		$this->data('subtitle::Test subtitle');
		$this->data('body::Hello, in order to begin, we need to test this.');
		$this->data('test::This is a test value');
		$array_view = array(
			"test2" => "This is a test 2",
			"test3" => "This is a test 3",
			"test4" => "This is a test 4"
		);
		$paginate = new Pagination(1,5,20);
		$this->data($array_view);
		$this->view->render('test_view', false);
	}

}

