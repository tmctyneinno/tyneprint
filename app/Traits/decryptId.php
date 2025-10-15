<?php 

namespace App\Traits;

trait decryptId
{

//function to decypt id
public function decryptId($id){
    $get_id = explode('_', $id);
    $id = decrypt($get_id[1]);
    return $id;
}
}








