<?php

namespace App\Traits;



trait FormatResult
{
    
    
    public function formatResult($val, $error=false){
        if (!$error) return ["data" => $val];
        return ["errors" => $val];
    }
}

?>