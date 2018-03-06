<?php
	/**
	* @author Vinayak Sarawagi(vinayaksarawagi25@gmail.com)
	* @author Mayank Sareen(mayanksareen63@gmail.com)
	*/
	class phpJwt
	{
		private $algo_type;
		private $payload_data=array();
		private $header_data;	
    const ALGO_TYPE_HS256 = 0;
		const ALGO_TYPE_HS384 = 1;
		const ALGO_TYPE_HS5345678 = 2;
		const ALGO_TYPE_RS256 = 3;
		const ALGO_TYPE_RS384 = 4;
		const ALGO_TYPE_RS512 = 5;

		private $supported_algos = array("HS256 ","HS384","HS512","RS256","RS384","RS512"); 

		/**
		*@param int    $algo_type : Defines the type of supported algo
		*@param String $type      : Defines the type of the header restricted to JWT
		*@param String $cty       : Defines the content-type of the token
		*/
		function createHeader($algo_type,$type="JWT",$cty=null){
			if($algo_type > 5 or $algo_type<0){
				throw new Exception("Algorithm type not defined. Please refer to the manual", 1);
			}
			if($cty==null){
				$this->header_data = ["type"=>"JWT","alg"=>"'".$this->supported_algos[$algo_type]."'"];	
			}else{
				$this->header_data = ["type"=>"JWT","alg"=>"'".$this->supported_algos[$algo_type]."'","cty"=>"'".$cty."'"];
			}
			$this->header_data = phpJwt::base64_generator(phpJwt::json_generator($this->header_data));
			var_dump($this->header_data);
		}

		//This function creates generic standard payload
		/**
		*@param String $iss: Defines issuer string.
		*@param String $sub: Defines the princi[pal of the subject JWT.
		*@param String $aud: Defines the recepient that the JWT is intended for.
		*@param int $exp:	Defines the expiration time for the JWT
		*@param int $nbf: 	Defines the time before the JWT must not be accepted.
		*@param int $iat:	Defines the time at which the JWT is issued at.
		*@param int $jti:	Defines the unique identifier for the JWT.
		*/
		function createPayload($iss=null,$sub=null,$aud=null,$exp=null,$nbf=null,$iat=null,$jti=null){
				if($iss!=null)
				{
					$this->payload_data["iss"] = $iss;
				}
				if($sub!=null){
					$this->payload_data["sub"] = $sub;
				}
				if($aud!=null){
					$this->payload_data["aud"] = $aud;
				}
				if($exp!=null){
					$this->payload_data["exp"] = $exp;
				}
				if($nbf!=null){
					$this->payload_data["nbf"] = $nbf;
				}
				if($iat!=null){
					$this->payload_data["iat"] = $iat;
				}
				if($jti!=null){
					$this->payload_data["jti"] = $jti;
				}

				$this->payload_data = phpJwt::json_generator($this->payload_data);
				var_dump($this->payload_data);
		}



		//This function creates extra data to be included in payload
		function createExtraPayload($extra_data){
			foreach ($extra_data as $key => $value) {
				$this->payload_data[$key] = $value;
			}
			//$this->payload_data = phpJwt::json_generator($this->payload_data);
			//var_dump($this->payload_data);
		}	



		//Converts array data into json data
		//Currently uses json_encode() generic function
		function json_generator($data){
			$data =  json_encode($data);
			return $data;
		}

		function base64_generator($jsonData){
			$jsonData = base64_encode($jsonData);
			return $jsonData;
		}

		function checkIfInteger($data){
			return is_int($data);
		}

		function checkIfString($data){
			return is_string($data);
		}
	}


	$obj = new phpJwt();
	$obj->createHeader(0,"JWT","text/html");
	$obj->createPayload("assguard","login","generic",1234567,12345678,12234567,23456);
	$obj->createHeader(6,"JWT","text/html");
	$data =["email"=>"vinayaksarawagi25@gmail.com","id"=>4567890];
	$obj->createExtraPayload($data);
?>