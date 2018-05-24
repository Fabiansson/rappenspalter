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

    public function readByName($name)
    {
        // Query erstellen
        $query = "SELECT * FROM {$this->tableName} WHERE name=?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $name);

        // Das Statement absetzen
        $statement->execute();

        // Resultat der Abfrage holen
        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $row = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $row;
    }
}
