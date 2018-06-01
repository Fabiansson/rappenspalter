<?php

require_once '../lib/Repository.php';

class UserRepository extends Repository {
    protected $tableName = 'haushalt';

    /**
     * Diese Methode erstellt einen Haushaltsaccount.
     *
     * @param $name Haushaltsname
     * @param $password
     * @param $email
     * @return mixed
     * @throws Exception
     */
    public function create($name, $password, $email) {
        $password = sha1($password);

        $query = "INSERT INTO {$this->tableName} (name, password, email) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('sss', $name, $password, $email);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }

    public function readByName($name) {

        $query = "SELECT * FROM {$this->tableName} WHERE name = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $name);

        $statement->execute();

        $result = $statement->get_result();
        if (!$result) {
            throw new Exception($statement->error);
        }

        $row = $result->fetch_object();

        $result->close();

        return $row;
    }

    public function setEinnahmen($wert, $haushalt_id) {
        $query = "UPDATE {$this->tableName} SET mntlEinnahmen = ? WHERE id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('di', $wert, $haushalt_id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }

    public function setAusgaben($wert, $haushalt_id) {
        $query = "UPDATE {$this->tableName} SET mntlAusgaben = ? WHERE id = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('di', $wert, $haushalt_id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }

    /**
     * Diese Methode prüft ob ein Haushalt mit diesem namen bereits existiert oder nicht.
     *
     * @param $name Eingegebener Name
     * @return bool Ob der Haushalt bereits exisiert oder nicht.
     * @throws Exception
     */
    public function checkDuplicate($name) {
        $query = "SELECT * FROM {$this->tableName} WHERE name = ?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('s', $name);

        $statement->execute();

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception($statement->error);
        }

        $duplicate = $result->fetch_object();

        $result->close();

        return !($duplicate == NULL);
    }

    /**
     * Diese Methode dient zum löschen eines Haushalts.
     *
     * @param id $id HaushaltsID die gelöscht werden soll.
     * @throws Exception
     */
    public function deleteById($id) {
        $query = "DELETE FROM {$this->tableName} WHERE id=?";

        // Datenbankverbindung anfordern und, das Query "preparen" (vorbereiten)
        // und die Parameter "binden"
        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        // Das Statement absetzen
        $statement->execute();
    }
}
