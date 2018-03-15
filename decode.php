<?php
 
 class Decode{

    private $jwtToken;
    private $jwtToken_break;
    private $status;
    private $service_type;
    //private $error_type;
    //private $error_code;
    private $result_detail = array();
    

    function __construct($jwtToken){
        $this->jwtToken = $jwtToken;
        $this->jwtToken_break = explode(".",$this->jwtToken);
        $this->status = null;
        $this->service_type = null;
        //$this->error_type = null;
        //$this->error_code = null;
        $this->result_detail = null;
    }

    /**
     * @param int $type:        Defines the type of result to be returned. Ranges from 0 to 2. 
     * 0 means encoded payload, 1 means payload in JSON, 2 means payload in array.
     * @param int $msg_type:    Defines that data detailing.
     * 0 means data in detailed format, 1 means data in short format.
     */
    function getPayload($type,$msg_type){
        if(!Decode::checkIfInteger($type)){
            throw new Exception("Undefined \"Type Variable\" passed, please check if you are passing Array type only. For more, plase refer to the manual.", 1);
        }
        if($type > 2 || $type < 0){
            throw new Exception("Range of \"Type variable\" not defined. Please see if you are providing value between 0-2. For more, please refer to the manual.",1);
        }
        if($type == 0){
            $this->result = $this->jwtToken_break[1];
            $this->status = 1;
            $this->service_type = "Get payload as it is.";
        }elseif($type == 1){
            $this->result = Decode::json_degenerator($this->jwtToken_break[1]);
            $this->status = 1;
            $this->service_type = "Get the payload in JSON.";
        }
        elseif($type == 2){
            $this->result = Decode::array_degenerator($this->jwtToken_break[1]);
            $this->status = 1;
            $this->service_type = "Get the payload in array.";
        }

        if(!Decode::checkIfInteger($msg_type)){
            throw new Exception("Undefined \"Message Type Variable\" type passed, please check if you are passing Array type only. For more, plase refer to the manual.", 1);
        }
        if($msg_type>2 || $msg_type<0){
            throw new Exception("Range of \" Message Type variable\" not defined. Please see if you are providing value between 0-1. For more, please refer to the manual.",1);
        }

        //If msg_type variable is passed as 0, then only the payload data will be returned.
        //Else if msg_type variable is passed as 1, then detailed array of data will be passed.
        if($msg_type==0){
            return $this->result;
        }elseif($msg_type==1){
            $this->result_detail = ["Status"=>$this->status,"Service Type"=>$this->service_type,"Result"=>$this->result];
            return $this->result_detail;
        }
    }

    function json_degenerator($data){
        $data  = base64_decode($data);
        return $data;
    }

    function array_degenerator($data){
        $data = base64_decode($data);
        $data = json_decode($data, TRUE);
        return $data;
    }

    function checkIfInteger($data){
        return is_int($data);
    }
    
 }
    try{
        $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJ1c2VySWQiOiJiMDhmODZhZi0zNWRhLTQ4ZjItOGZhYi1jZWYzOTA0NjYwYmQifQ.-xN_h82PHVTCMA9vdoHrcZxH-x5mb11y1537t3rGzcM";
        $decode = new Decode($token);
        $result = $decode->getPayload(1,1);
        var_dump($result);
        //echo $decode->display(1);
        //var_dump($decode->result);
    }catch(Exception $e){
        echo $e->getMessage();
    }

?>