<?php
    class context 
    {
        private $data;
        const SUCCESS = "Success";
        const ERROR = "Error";
        const NONE = "None";
        private $name;
        private static $instance = null;

        public static function getInstance()
        {
            if(self::$instance==null)
            {
                self::$instance = new context();
            }
            return self::$instance;
        }

        private function __construct()
        {

        }

        public function init($name)
        {
            $this->name = $name;
        }

        public function getLayout()
        {
            return $this->layout;
        }

        public function setLayout($layout)
        {
            $this->layout = $layout;
        }

        public function executeAction($action, $request)
        {
            $this->layout = "layout";
            if(!method_exists('mainController', $action))
            {
                return false;
            }
            return mainController::$action($request,$this);
        }

        // Les 2 méthodes ci-dessous permettent de stocker des variables dans l'instance context
        public function __get($prop)
        {
            if(array_key_exists($prop, $this->data))
            {
                return $this->data[$prop];
            }
            return NULL;
        }

        public function __set($prop, $value)
        {
            $this->data[$prop] = $value;
        }
    }
?>