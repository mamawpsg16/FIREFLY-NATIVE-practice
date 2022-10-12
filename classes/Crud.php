<?php
include_once '../config/Db.php';
class Crud extends Db
{
	public function getData($query)
	{
		$result = $this->connection()->query($query);

		if ($result == false) {
			return false;
		}

		$rows = [];
		while ($row = $result->fetchAll()) {
			$rows = $row;
		}
		return $rows;
	}

	public function createType($code, $description)
	{
		$sql = 'INSERT INTO types(code, description) VALUES( ?, ?);';
		$stmt = $this->connection()->prepare($sql);
		$stmt->execute([$code, $description]);
		if (!$stmt) {
			$stmt = null;
			header("location: ../types/add.php?error=stmtfailed");
			exit();
		}
		$result = '';
		if ($stmt->rowCount() > 0) {
			$result = false;
		} else {
			$result = true;
		}

		return $result;
	}

	public function createItem($code, $description, $type_id)
	{
		$sql = 'INSERT INTO items(type_id, code, description) VALUES(:type_id, :code, :description);';
		$stmt = $this->connection()->prepare($sql);
		$stmt->execute([':type_id' => $type_id, ':code' => $code, ':description' => $description]);
		if (!$stmt) {
			$stmt = null;
			header("location: ../items/add.php?error=stmtfailed");
			exit();
		}
		$result = '';
		if ($stmt->rowCount() > 0) {
			$result = false;
		} else {
			$result = true;
		}

		return $result;
	}

	public function updateType($code, $description, $id)
	{
		$sql = 'UPDATE types SET code = :code , description = :description WHERE id = :id;';
		$stmt = $this->connection()->prepare($sql);
		$stmt->execute([':code' => $code, ':description' => $description, ':id' => $id]);

		if (!$stmt) {
			$stmt = null;
			header("location: ../types/edit.php?error=stmtfailed");
			exit();
		}
		return true;
	}

	public function updateItem($code, $description, $id, $type_id)
	{
		print_r($type_id);
		$sql = 'UPDATE items SET  type_id = :type_id, code = :code , description = :description WHERE id = :id;';
		$stmt = $this->connection()->prepare($sql);
		$stmt->execute([':type_id' => $type_id, ':code' => $code, ':description' => $description, ':id' => $id]);

		if (!$stmt) {
			$stmt = null;
			header("location: ../items/edit.php?error=stmtfailed");
			exit();
		}
		return true;
	}


	public function delete($id, $table)
	{
		if($table === 'types'){
			$sql = "DELETE tp,it FROM $table tp
			LEFT JOIN items it ON tp.id = it.type_id
			WHERE tp.id = :id";
		}else{
			$sql = "DELETE FROM $table WHERE id = :id;";
		}
		
		$stmt = $this->connection()->prepare($sql);
		$stmt->execute([':id' => $id]);

		if (!$stmt) {
			echo 'Error: cannot delete id ' . $id . ' from table ' . $table;
			return false;
		}

		return true;
	}
}
