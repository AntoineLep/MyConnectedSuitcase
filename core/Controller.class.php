<?php
    class Controller {

        /**
        * (string) Default template to be used
        */
        protected $template;

        /**
        * (array) Computed view content list
        */
        private $views = [];

        public function __construct($template = 'default'){
            $this->template = $template;
        }

        /**
        * Default controller index empty function
        */
        protected function index(){}
        
        /**
        * Compute all stocked views and insert it in the given template
        * @param (array) vars: Array of variables to be passed to the template
        */
        protected function render($vars = []){
            extract($vars);
            $_viewContent = '';

            foreach ($this->views as $view) 
                $_viewContent .= $view . "\n";


            if($this->template)
                require(TEMPLATE_FOLDER . DS . $this->template . DS . 'index.php');
            else
                echo $_viewContent;
        }

        /**
        * Load a view
        * @param (string) view : path to the view in views folder without extention
        * @param (array) vars : Variables to be passed to the view
        * @param (bool) return : Indicates if the view content has to be returned. If true, the view content will be computed but will not be stocked
        * @return (string) The content of the view if return param is true, nothing otherwise
        */
        protected function loadView($view, $vars = [], $return = false){
            ob_start();
            extract($vars);

            if($view)
                require(VIEW_FOLDER . DS . str_replace('\\', DS, str_replace('/', DS, $view)) . '.php');

            $_viewContent = ob_get_clean();

            if($_viewContent)
                if(!$return)
                    array_push($this->views, $_viewContent);
                else
                    return $_viewContent;
        }

        /**
        * Load a model as a controller property
        * @param (string) modelName : Name of the model class
        * @param (string) newName : Default property name will be modelName except if this parameter is filled. In this case newName will be the property name 
        */
        protected function loadModel($modelName, $newName = null){
            $name = ($newName) ? $newName : $modelName;
            $this->$name = new $modelName();
        }
    }
?>