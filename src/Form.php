<?php 
/**
 * 
 */
class Form
{
	public $controller;
	public $errors;

	public function __construct($controller){
		$this->controller = $controller;
	}

	public function input($name, $label, $options = array()){		
		$error = false;
		$classError = '';
		if (isset($this->errors[$name])) {
			$error = $this->errors[$name];
			$classError = 'bg-danger';
		}
		if (!isset($this->controller->request->data->$name)) {
			$value = '';
		}else{
			$value = $this->controller->request->data->$name;
		}
		if ($label == 'hidden') {
			return '<input type="hidden" name="'.$name.'" value="'.$value.'">';
		}

	 	$html =  '<div class="form-group '.$classError.'">
	    <label for="input'.$name.'">'.$label.'</label>';
	    
	    $attr = ' ';
	    foreach ($options as $key => $val) {
	    	if ($key != 'type') {
	    		$attr .= "$key=\"$val\"";
	    	}
	    }

	    if (!isset($options['type'])) {
	    	$html .= '<input type="text" class="form-control" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
	    }elseif ($options['type'] == 'textarea') {
	    	$html .= '<textarea class="form-control" id="input'.$name.'" name="'.$name.'"'.$attr.'>'.$value.'</textarea>';
	    }elseif ($options['type'] == 'checkbox') {
	    	$html = '<div class="form-check">
					  <input type="hidden" name="'.$name.'" value="0" ><input class="form-check-input" type="checkbox" value="1" id="input'.$name.'" name="'.$name.'" '.(empty($value) ?  '' : 'checked').'>
					  <label class="form-check-label" for="input'.$name.'">'
					    .$label.
					  '</label>
					</div>';
			return $html;
	    }elseif ($options['type'] == 'file') {
	    	$html = '<label for="input'.$name.'">'.$label.'</label>';
	    	$html .= '<div class="custom-file">'.'<input type="file" class="custom-file-input" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.' ><label class="custom-file-label" for="'.$name.'">Choisir un fichier</label>';
	    	if ($error) {
	    	$html .= '<span class="inline '.$classError.'">'.$error.'</span>';
	    	}
	    	$html .= '<div/>';
			return $html;
	    }elseif ($options['type'] == 'password') {
	    	$html .= '<input type="password" class="form-control" id="input'.$name.'" name="'.$name.'" value="'.$value.'"'.$attr.'>';
	    }elseif ($options['type'] == 'date') {
	    	$html = '<div class="form-group row">
	    		<label for="input'.$name.'" class="col-2 col-form-label">'.$label.'</label>
	    		<div class="col-10">
	    		<input class="form-control" type="date" value="'.$value.'" name="'.$name.'" id="input'.$name.'">
	    		</div>
	    		';
	    		//debug($this->controller->request->data->$name);
	    }
	    if ($error) {
	    	$html .= '<span class="inline">'.$error.'</span>';
	    }
	    $html .= '</div>';
	    return $html;

	}
	/*
<div class="form-group row">
  <label for="example-date-input" class="col-2 col-form-label">Date</label>
  <div class="col-10">
    <input class="form-control" type="date" value="2011-08-19" id="example-date-input">
  </div>
</div>
*/
}