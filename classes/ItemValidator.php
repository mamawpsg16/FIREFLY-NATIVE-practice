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
        }else{
            if($type_id == 'error'){
                $this->addError('type', 'setup type first!');
            }
        }
    }
    private function validateCode()
    {
        $code = trim($this->data['code']);
        $validate_code = $this->checkCode($code,$this->data['operation'],isset($this->data['id']) ? $this->data['id'] : null );
        if ($validate_code) {
            $this->addError('code_taken', 'code is already taken!');
        }

        if (empty($code)) {
            $this->addError('code', 'code is required!');
        }else{
            if(preg_match('/[^a-z_0-9 ]/i', $code)){
                $this->addError('code', 'code may only contain alphanumeric characters!');
            }else if(strlen($code) > 10 || strlen($code) < 2){
                $this->addError('code','code must be 2 - 10 characters only!');
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
            }
        }
    }

    private function checkCode($code,$operation,$id = null)
    {
        if ($operation == 'create'){
            $sql = "SELECT code FROM items WHERE code = '$code'";
        }else{
            $sql = "SELECT code FROM items WHERE code = '$code' AND id != $id";
        }

        $stmt = $this->connection()->prepare($sql);
        
        $stmt->execute();

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