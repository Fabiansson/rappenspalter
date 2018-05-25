<?php

require_once '../lib/Repository.php';

class EinnahmeRepository extends Repository
{
    protected $tableName = 'einnahme';

    public function getEinnahmen($id)
    {

        $query = "SELECT SUM(wert) as summe FROM {$this->tableName} WHERE haushalt_id=?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        $statement->execute();

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $einnahmen = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $einnahmen;
    }

    public function addEinnahme($wert, $haushalt_id)
    {

        $query = "INSERT INTO $this->tableName (wert, datum, haushalt_id) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssi', $wert, date("Y-m-d"), $haushalt_id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }
}
