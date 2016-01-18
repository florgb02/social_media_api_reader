<?php 
/*



*/
class DataMiner extends DataMinable{
	
	$hashtag;
	$api_key;
	$platform;

	
	//Set Platform
	public function setPlatform( $platform ){
		$this->platform = $platform;
	}

	//Set HashTag
	public function setHashtag($hashtag){
		$this->hastag = $hashtag;
	}

	public function mine(){

		$api = new APISettings( $platform );

		$success = $api->runData();

		if($success) echo "Data Saved Success!";
		else echo "ERROR";
		
	}
}
?>