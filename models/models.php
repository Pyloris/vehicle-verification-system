<?php
require_once __DIR__ . "/../vendor/autoload.php";

use sirJuni\Framework\Model\Database;

// load config
require_once __DIR__ . "/../config.php";



// load authentication module
require_once __DIR__ . "/Auth/auth.php";
require_once __DIR__ . "/Org/org.php";


class DB extends Database {

    use Auth_DB;
    use Org_DB;

    public function __construct() {
        $this->dbConnect();
    }
}

?>