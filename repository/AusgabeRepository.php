<?php

require_once '../lib/Repository.php';

class AusgabeRepository extends Repository
{
    protected $tableName = 'ausgabe';

    public function getAusgaben($id){

        $query = "SELECT SUM(wert) as summe FROM {$this->tableName} WHERE haushalt_id=?";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        $statement->execute();

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception($statement->error);
        }

        // Ersten Datensatz aus dem Reultat holen
        $ausgaben = $result->fetch_object();

        // Datenbankressourcen wieder freigeben
        $result->close();

        // Den gefundenen Datensatz zurückgeben
        return $ausgaben;
    }
}
