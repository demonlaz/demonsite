<?php 
//ищет все файлы в деректории и подключает их или выводит
class patern{
	
					
						public $putc;
						private $arr_file=[];
					  public	function __construct($putch="protected/views/*.php"){
						
														$this->putc=$putch;
														$this->arr_file=glob($this->putc);
														//require_once $this->arr_file[$key];

						}
						
						public function conect($key)
							{
														
														$this->arr_file=glob($this->putc);
														require_once $this->arr_file[$key];
						}
							
							// Распечатывает дамп переменной на экран.

               public   function display()
                {
                         echo 
                          "<pre>".
                                  htmlspecialchars(dumperGet($this->arr_file)),
                         "</pre>"; 
                 }


// Распечатывает дамп переменной на экран.


  // Возвращает строку - дамп значения переменной в древовидной форме 
  // (если это массив или объект). В переменной $leftSp хранится 
  // строка с пробелами, которая будет выводиться слева от текста.
private  function dumperGet(&$obj, $leftSp = "")
  { 
    if (is_array($obj)) {
      $type = "Array[".count($obj)."]"; 
    } elseif (is_object($obj)) {
      $type = "Object";
    } elseif (gettype($obj) == "boolean") {
      return $obj? "true" : "false";
    } else {
      return "\"$obj\"";
    }
    $buf = $type; 
    $leftSp .= "    ";
    for (Reset($obj); list($k, $v) = each($obj); ) {
      if ($k === "GLOBALS") continue;
      $buf .= "\n$leftSp$k => ".dumperGet($v, $leftSp);
    }
    return $buf;
  }
}

?>