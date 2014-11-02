<!DOCTYPE html>
<html lang="hr">
<head>
<meta charset="UTF-8" />
	<title>Test</title>
</head>
<body>

	<h2><?php echo $this->var_check($this->title); ?></h2>
	<h3><?php echo $subtitle; ?></h3>
	<p><?php echo $this->var_check($body); ?></p>
	<p><?php echo $this->var_check($test); ?></p>
	<p><?php echo $this->var_check($test2); ?></p>
	<p><?php echo $this->var_check($test3); ?></p>
	<p><?php echo $this->var_check($test4); ?></p>
	<p><?php echo $this->var_check($username); ?></p>

	<form>
		<label for="name"><?php echo $this->lang->general->name ?></label>
		<input type="text" name="name" id="name">
		<input type="submit" value="<?php echo $this->lang->form->submit ?>">
	</form>

</body>
</html>