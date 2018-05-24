<?php

require_once '../lib/Repository.php';

class EinnahmeRepository extends Repository
{
    protected $tableName = 'einnahme';

    public function addEinnahme($wert, $haushalt_id){

        $query = "INSERT INTO $this->tableName (wert, datum, haushalt_id) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('ssi', $wert, date("Y-m-d"), $haushalt_id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }
}
