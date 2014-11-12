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

	public function test_input() {
		$input = new Input();

		$name = $_POST["name"] = "ivan";
		$email = $_POST["email"] = "granica";
		$phone = $_POST["phone"] = "fasdfgadfg";
		$password = $_POST["password"] = "grana";
		$password2 = $_POST["password2"] = "granAAa";

		$input->check($name, "Ime", array(
			'required' => true,
			'maxlength' => 3
		));

		$input->check($email, "E-mail", array(
			'email' => true,
		));

		$input->check($password2, "password2", array(
			'match' => 'password',
		));

		if(FORM_SUBMIT == "POST") {
			echo $input->upload_info();
			if (!$input->is_max_upload_size()) {
				pretty_print($input->get_errors(), "Upload Errors", "red");
			}
			echo "uploaded";
		}

		header("Content-Type: text/html; charset=utf-8");

		pretty_print($_POST, "POST");
		pretty_print($_REQUEST, "REQUEST");
		pretty_print($input->get_errors(), "Errors");
		//echo $input->get_formatted_errors();

		$form = <<<FORM
		<form action="/stiiv-mvc/test/test_input" method="post" enctype="multipart/form-data">
			<input type="file" name="file" />
			<input type="submit" value="Upload" />
		</form>
FORM;
		echo $form;
	}

}

