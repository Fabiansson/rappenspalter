<?php

require_once '../lib/Repository.php';

class UserRepository extends Repository
{
    protected $tableName = 'haushalt';


    public function create($name, $password, $email)
    {
        $password = sha1($password);

        $query = "INSERT INTO $this->tableName (name, password, email) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sss',$name, $password, $email);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }
}
