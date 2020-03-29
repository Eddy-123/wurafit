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
	    }
	    if ($error) {
	    	$html .= '<span class="inline">'.$error.'</span>';
	    }
	    $html .= '</div>';
	    return $html;

	}
}