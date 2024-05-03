<?php

trait Auth_DB {

    public function saveOrg($domain, $email, $password) {
        $query = "INSERT INTO organizations (domain, email, password) VALUES (:domain, :email, :password)";

        $stmt = $this->db->prepare($query);
        
        try {
            $stmt->bindParam(":domain", $domain);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $password);

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


    public function getOrg($email) {
        $query = "SELECT id, domain, email, password FROM organizations WHERE email=:email";

        $stmt = $this->db->prepare($query);
        
        try {
            $stmt->bindParam(":email", $email);

            if ($stmt->execute()) {
                return $stmt->fetch();
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