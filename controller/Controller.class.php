<?php

class Controller {
    private $action;

    public function __construct(array $arguments = array()){
		if(!empty($arguments)){
			foreach($arguments as $property=>$argument){
				$this->{$property}=$argument;
			}
		}
	}

	function __get($nom){
		return $this->$nom;
	}

	function __set($nom, $valeur){
		$this->$nom=$valeur;
	}

	public function __toString(){
		$name=get_class($this);
		$s="<{$name}>\n";
		foreach($this as $key=>$value){
			$s.="\t<{$key}>{$this->{$key}}</{$key}>\n";
		}
		$s.="</{$name}>\n";
		return $s;
	}

    public function changePage(){
        if (isset($this->action)) {

            if($this->action=="products"){
                include("view/products.php");
            } 
            
            elseif ($this->action=="newLogin") {
                include("view/loginForm.php");
            }

            elseif ($this->action=="deco") {
                setcookie('employeeId', '', time() - 3600, '/');
                setcookie('employeeRole', '', time() - 3600, '/');
                setcookie('employeeStore', '', time() - 3600, '/');
                header("Location: index.php?action=products");
            }

            elseif ($this->action=="legalNotice") {
                include("view/legalNotice.php");
            }

            elseif ($this->action=="addForm") {
                include("view/addForm.php");
            }

            elseif ($this->action=="editForm") {
                include("view/editForm.php");
            }

            elseif ($this->action=="deleteForm") {
                include("view/deleteForm.php");
            }

            elseif ($this->action=="storeAdd") {
                include("view/storeAdd.php");
            }

            elseif ($this->action=="storeDisplay") {
                include("view/storeDisplay.php");
            }

            elseif ($this->action=="changeLogin") {
                include("view/changeLogin.php");
            }
        }
    }

    /*private function callAPI($role, $email, $password) {
        $api_url = 'URL_DE_VOTRE_API';
        $data = array('action' => $role, 'email' => $email, 'password' => $password);
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type: application/x-www-form-urlencoded',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = file_get_contents($api_url, false, $context);
        $response = json_decode($result, true);
        return $response;
    }*/
}