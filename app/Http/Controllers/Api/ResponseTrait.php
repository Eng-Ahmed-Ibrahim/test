<?php 
namespace App\Http\Controllers\Api;

trait ResponseTrait{
    public static function Response($status,$data=null,$msg=null){
        $array=[
            "data"=>$data,
            "msg"=>$msg,
            "status"=>$status,
        ];
        return response($array,$status);
    }
}