<?php include_once('../config/Db.php'); ?>
<?php
    class Validator{
        private $data;
        private $errors =[];
        private static $fields = ['code','description'];

        public function __construct($post_data){
            $this->data = $post_data;
        }

        public function validateForm(){
            // print_r($this->data);
            foreach (self::$fields as $field) {
                if(!array_key_exists($field,$this->data)){
                    trigger_error("$field is not a present data");
                    return;
                }
            }
            $this->validateCode();
            $this->validateDescription();

            return $this->errors;
        }

        

        private function validateCode(){
            $val = trim($this->data['code']);
            $conn = new DbConfig;
            $code = $conn->checkCode('code', $val,'types');
            if ($code  == $val) {
                $this->addError('code','code is already taken!');

            }
            if(empty($val)){
                $this->addError('code','code is required!');
            }
        }

        private function validateDescription(){
            $val = trim($this->data['description']);
            if(empty($val)){
                $this->addError('description','description is required!');
            }
        }

        private function addError($key,$value){
            $this->errors[$key]=$value;
        }

        
    }
?>