<?php
require_once __DIR__ . "/../vendor/autoload.php";

// load database
require_once __DIR__ . "/../models/models.php";

use sirJuni\Framework\View\VIEW;
use sirJuni\Framework\Middleware\Auth;
use sirJuni\Framework\Helper\HelperFuncs;

class AuthC {
    function handleLogin($request) {
        if ($request->method() == "POST") {

            $db = new DB();

            $email = $request->formData("email");
            $password = $request->formData("password");
            $hash = hash("sha256", $password);

            $org = $db->getOrg($email);

            if ($org != FALSE and $org['password'] == $hash) {
                Auth::login($org);

                // SAVE THE SESSION
                $_SESSION['id'] = $org['id'];
                $_SESSION['email'] = $org['email'];
                $_SESSION['domain'] = $org['domain'];

                HelperFuncs::redirect("/dashboard");
                return;
            }
            else {
                HelperFuncs::redirect("/login?error=wrong email or password");
                return;
            }
        }
        else if ($request->method() == "GET") {
            $context = [];
            $context['message'] = $request->queryData("error");

            VIEW::init("orgAuth.html", $context);
        }
    }

    function postSignup($request) {
        $db = new DB();

        $domain = $request->formData("domain");
        $email = $request->formData("email");
        $password = $request->formData("password");

        $hash = hash("sha256", $password);
        
        // save the org
        if ($db->saveOrg($domain, $email, $hash)) {
            $org = $db->getOrg($email);
            Auth::login($org);

            // SAVE THE SESSION
            $_SESSION['id'] = $org['id'];
            $_SESSION['email'] = $org['email'];
            $_SESSION['domain'] = $org['domain'];

            HelperFuncs::redirect("/dashboard");
            return;
        }
        else{
            HelperFuncs::redirect("/login?error=could not sign you up!");
            return;
        }
    }

    function logout($request) {
        Auth::logout();
        HelperFuncs::redirect("/");
    }
}

?>