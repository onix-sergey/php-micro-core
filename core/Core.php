<?

require 'Db.php';
require 'Model.php';
require 'ViewsUtils.php';

/**
 *  $set = new ArraySet(array("a"=>1,"b"=>2));
 *  var_dump($set->getB());
 */
class ArraySet {

	private $data;

	function __construct($data) {
		$this->data = $data;
	}
	
	function __call($val, $x) {				
		$val = strtolower($val);
		if(substr($val, 0, 4) == 'get_') {
			return $this->data[substr($val, 4)];
		} elseif(substr($val, 0, 3) == 'get') {
			return $this->data[substr($val, 3)];
		} else {
			trigger_error("method $val does not exist\n");
		}		
		return false;
	}
	
}

class Application {
	
	function run($action = 'main', $layout = 'layout') {	
		$db = new Db(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);		
		if(substr($action, -1) == '/') { // remove last slash if exists
			$action = substr($action, 0, -1);
		}
		$action = str_replace('/', '_', $action);				
		$controller = WWW_ROOT . '/controllers/' . $action . '.php';
		
		if(strcmp(realpath($controller), $_SERVER['DOCUMENT_WWW_ROOT'])) {		
					
			$view = new View($action, $layout);
			
			if(isset($_SESSION['user'])) {
				$user = $_SESSION['user'];
				$view->set('user', $user);
			}
			
			if(is_file($controller)) {
				include($controller);								
			} else {
				$view->changeAction('404');				
			}
			$view->set('user', $user);			
			$view->display();
		} else {			
			trigger_error('Hacker attack from IP:' . $_SERVER['REMOTE_ADDR']);
			die();
		}
	}
}

class View {

	private $layout;
	private $vars;
	private $action;

	public function __construct($action, $layout = 'default') {	
		$this->action = $action;
		$this->layout($layout);
		$this->vars = array();
	}
	
	function layout($layout){
		$this->layout = sprintf(WWW_ROOT . '/views/%s.php', $layout);
	}
	
	public function display() {
		extract($this->vars);
		if($this->layout && file_exists($this->layout)) {
			$layout = $this->action . '.php';					
			include $this->layout;
		} else {			
			include(WWW_ROOT . '/views/' . $this->action . '.php');
		}
	}
	
	public function getHtml() {
		ob_start();
		$this->display();		
		return ob_get_clean();		
	}
	
	public function set($name, $value) {
		$this->vars[$name] = $value;
	}
	
	public function changeAction($action) {
		$this->action = $action;
	}
	
}

?>