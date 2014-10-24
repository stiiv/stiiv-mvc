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
		Session::set("user", "stiiv85");
		$this->data("username::You are currently logged in as: ".Session::get("user"));
		$this->data("print::".Session::view());
		$sess = array(
			"id_user" => 265,
			"user2" => "ivan"
		);
		Session::multi_set($sess);
		$this->data($array_view);
		$this->view->render('test_view', false);
	}

}

