<?php


trait Org_DB {

    public function getStat($id) {
        return [
            'scans_today' => 5,
            'scans_this_month' => 20,
            'scans_this_year' => 100,
            'total_cars' => 200,
        ];
    }

    public function getVehicleList($id) {

        $query = "SELECT number, owner, orgId password FROM vehicle_numbers WHERE orgId=:id";

        $stmt = $this->db->prepare($query);
        
        try {
            $stmt->bindParam(":id", $id);

            if ($stmt->execute()) {
                return $stmt->fetchAll();
            }
            else {
                return FALSE;
            }
        }
        catch(PDOException $e) {
            return FALSE;
        }
    }

    public function saveVehicle($orgId, $vehicle_number, $owner) {

        $query = "INSERT INTO vehicle_numbers (orgId, number, owner) VALUES (:orgId, :number, :owner)";

        $stmt = $this->db->prepare($query);
        
        try {
            $stmt->bindParam(":orgId", $orgId);
            $stmt->bindParam(":owner", $owner);
            $stmt->bindParam(":number", $vehicle_number);

            if ($stmt->execute()) {
                return TRUE;
            }
            else {
                return FALSE;
            }
        }
        catch(PDOException $e) {
            return FALSE;
        }
    }
}


?>