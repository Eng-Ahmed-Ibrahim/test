<?php 
namespace App\Http\Controllers\Api;

trait ResponseTrait{
    public static function Response($data=null,$status,$msg=null){
        $array=[
            "data"=>$data,
            "msg"=>$msg,
            "status"=>$status,
        ];
        return response($array,$status);
    }
}