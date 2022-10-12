<?php include_once('../config/Db.php'); ?>
<?php
class ItemValidator extends Db
{
    private $data;
    private $errors = [];
    private static $fields = ['code', 'description','type_id'];

    public function __construct($post_data)
    {
        $this->data = $post_data;
    }

    public function validateForm()
    {
        foreach (self::$fields as $field) {
            if (!array_key_exists($field, $this->data)) {
                trigger_error("$field is not a present data");
                return;
            }
        }
        $this->validateCode();
        $this->validateDescription();
        $this->validateId();

        return $this->errors;
    }



    private function validateId()
    {
        $type_id = trim($this->data['type_id']);
        if (empty($type_id)) {
            $this->addError('type', 'type is required!');
        }
    }
    private function validateCode()
    {
        $code = trim($this->data['code']);

        $validate_code = $this->checkCode($code,$this->data['operation']);
        if ($validate_code) {
            $this->addError('code_taken', 'code is already taken!');
        }

        if (empty($code)) {
            $this->addError('code', 'code is required!');
        }else {
            if(preg_match('/[^a-z_0-9]/i', $code)){
                $this->addError('code', 'code may only contain alphanumeric characters!');
            }else if(strlen($code) > 5 || strlen($code) < 2){
                $this->addError('code','code must be 2 - 5 characters only!');
            }
        }
    }

    private function validateDescription()
    {
        $description = trim($this->data['description']);
        if (empty($description)) {
            $this->addError('description', 'description is required!');
        }else{
            if(preg_match('/[^a-z0-9 ]/i', $description)){
                $this->addError('description', 'description may only contain alphanumeric characters or space!');
            }else if(strlen($description) > 50 || strlen($description) < 5){
                $this->addError('description','code must be 5 - 50 characters only!');
            }
        }
    }

    private function checkCode($code,$operation,$id = null)
    {
        if ($operation == 'create'){
            $sql = 'SELECT code FROM items WHERE code = :code;';
        }else{
            $sql = 'SELECT code FROM items WHERE code = :code AND id != :id;';
        }
        $stmt = $this->connection()->prepare($sql);
        
        if ($operation == 'create'){
            $stmt->execute([':code' => $code]);
        }else{
            $stmt->execute([':code' => $code, 'id' => $id]);
        }

        if (!$stmt) {
            $stmt = null;
            header("location: ../index.php?error=stmtfailed");
            exit();
        }
        if ($stmt->rowCount() == 0) {
            return false;
        }
        return true;
    }

   
    private function addError($key, $value)
    {
        $this->errors[$key] = $value;
    }
}
?>