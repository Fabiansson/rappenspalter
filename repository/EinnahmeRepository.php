<?php

require_once '../lib/Repository.php';

class EinnahmeRepository extends Repository {
    protected $tableName = 'einnahme';

    /**
     * Diese Methode gibt die Summe aller Einnahmen aus dem aktuellen Monat zurück.
     *
     * @param $id die HaushaltID
     * @return die Abefragten Einnahmen
     * @throws Exception
     */
    public function getEinnahmen($id) {

        $query = "SELECT SUM(wert) as summe FROM {$this->tableName} WHERE haushalt_id=? AND MONTH(datum)=MONTH(CURRENT_DATE()) AND YEAR(datum) = YEAR(CURRENT_DATE())";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('i', $id);

        $statement->execute();

        $result = $statement->get_result();

        if (!$result) {
            throw new Exception($statement->error);
        }

        $einnahmen = $result->fetch_object();

        $result->close();

        return $einnahmen;
    }

    /**
     * Diese Methode dient dazu Einnahmen hinzuzufügen.
     *
     * @param $wert Höhe der Einnahme
     * @param $haushalt_id Die HaushaltsID
     * @return mixed
     * @throws Exception
     */
    public function addEinnahme($wert, $haushalt_id) {

        $query = "INSERT INTO $this->tableName (wert, datum, haushalt_id) VALUES (?, ?, ?)";

        $statement = ConnectionHandler::getConnection()->prepare($query);
        $statement->bind_param('dsi', $wert, date("Y-m-d"), $haushalt_id);

        if (!$statement->execute()) {
            throw new Exception($statement->error);
        }

        return $statement->insert_id;
    }
}
