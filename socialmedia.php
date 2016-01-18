<?php 




interface DataMinable{
	public function setPlatform();
	public function setHashtag();
}

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
		//CONFIGUTATION PER SOCIAL MEDIA
		//CURL API
		//PARSE DATA
		//SAVE INTO DATABASE

	}
}



public class APISettings{

	//This can be place in a separete configuration file for the porpuse of the application.
	// Settings info for each social media platform.
	 $config = array(
        'instafame' => array(
          'url' => 'api.instafame.dev/api/search?api_key={API_KEY}&‘hashtag={HASHTAG}',
          'method' => 'GET',
          'API_KEY' => '321654987',
          'header_Authentication' => false,
          'params' => ''
        ),
   
        'twinker' => array(
          'url' => 'api.twinker.dev/search/{HASHTAG}',
          'method' => 'GET',
          'API_KEY' => '123456789',
          'header_Authentication' => true,
          'params', 'Bearer 123456789'
        ),

        'fastbook' => array(
          'url' => 'fastbook.dev/v1/{HASHTAG}',
          'method' => 'GET',
          'API_KEY' => '456789123',
          'header_Authentication' => true,
          'params', 'Bearer 456789123'
        )
    );


	public __construct($platform){
		
		$this->platform = $platform;

		$this->runData();
	
	}

	
	private function replaceValues($url){
		if(strpos($url,'{HASHTAG}') !== false){
			$url = str_replace("{HASHTAG}", $this->hashtag, $url);
		}	

		if(strpos($url,'{API_KEY}') !== false){
			$url = str_replace("{API_KEY}", $settings['api_key'], $url);
		}	

		return $url;
	}

	/*
		GetData() this function will retrive the information
		from the api specified by the platform selected. 
		Using Curl to connect and communicate to many different types 
		of services.
	*/
	private function getData(){
		
		$settings =  $this->config[$this->platform];
		
		$url = $this->replaceValues($settings['url']);
			
		$channel = curl_init();

		curl_setopt($channel, CURLOPT_URL, $settings['url'] );
		curl_setopt($channel, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_HTTPHEADER, );


		if(isset($settings['header_Authentication']) && $settings['header_Authentication'] ){
			curl_setopt($channel, CURLOPT_HTTPHEADER, array('Content-type: application/json', 'Authentication: '.$settings['params']));
		}

		$result = curl_exec($channel);
		
		curl_close($channel);
		
		return $result;
	}

	private function parseAndCleanData($main_tag, $id_tag, $msg_tag){
		$array_to_save = array();

		$result = str_replace($main_tag, "",  $result ); 
				  $result = substr($json, 0, -2);


				  $resultArr = explode($id_tag, $result

				   foreach($resultArr as $info){
				      $data = explode($msg_tag, $info);
				      $text = '';
				      $id = $data[0];

				      if($data && isset($data[1]))
				        $text = substr($data[1], 0, -2);
				       
				       if(strlen($text) > 0){
				          $array_to_save[]['id'] = $id;
				          $array_to_save[]['text'] = $text;
				       }
				        
				  }

		return $array_to_save;
	}
	/*
			EX: 

			{body: [
			  {message_id: 1, message_text: ‘Here’s a picture of me with my #mzwallace.’}, 
			  {message_id: 2, message_ text: ‘Hey #mzwallace, Wow! That was f@$t!!!’},
			  {message_id: 3, message_text: ‘#mzwallace #handbags #<3 spread the @mzwallace love!’}
			]}

			{data: [
			  {id: 1, text: ‘Checkout my new twinker account! Here’s a picture of me with my #mzwallace.’}, 
			  {id: 2, text: ‘Hey #mzwallace, I love twinker!’},
			  {id: 3, text: ‘#mzwallace #handbags #<3 spread the @mzwallace love!’}
			]}

			{[
			  {_id: 1, message: ‘Here’s a picture of me with my #mzwallace.’}, 
			  {_id: 2, message: ‘Hey #mzwallace, #money #fame!’},
			  {_id: 3, message: ‘#mzwallace #handbags #<3 spread the @mzwallace love!’}
			]}
		*/

	private function saveData($result = null ){

		if(is_null( $result )){
			return false;
		}

		switch( $this->platform ){

			case 'instafame':
				$main_tag = "{body: [{";
				$id_tag = 'message_id: ';
				$msg_tag = ', message_text: ';

				$array_data = $this->parseAndCleanData($main_tag,$id_tag, $msg_tag );
			break;

			case 'twinker':
				$main_tag = "{data: [{";
				$id_tag = 'id: ';
				$msg_tag = ', text: ';

				$array_data = $this->parseAndCleanData($main_tag,$id_tag, $msg_tag );
			break;

			case 'fastbook':
				$main_tag = "[{";
				$id_tag = '_id: ';
				$msg_tag = ', message: ';

				$array_data = $this->parseAndCleanData($main_tag,$id_tag, $msg_tag );
			break;
		}
		

		//SAVE INTO DATABASE This can be move to another function.
		//Assuming we have a database created with a table name social_media_records and the required fields;
		/* 
			id PRIMARY KEY, INTEGER,  AUTOINCREMENT, NOT NULL,
		 	data_id DEFAULT, INTEGER, 
		 	data_message VARCHAR  
		*/

		 //Create connection
		 //Verify the connection was stabilish 
		 //Insert EX: 

		 	$query = "INSERT INTO social_media_records (data_id, data_message) VALUES( ";
		 	$len = count($array_data);
		 	$i = 0;
		 	foreach($array_data as $records){
		 		$query .= '('int($records['id']).', '.$records['text'].' ) ';
		 	
		 		if($i <= $len -1 )		
		 			$query .= ' ,';
		 	
		 		$i ++;
		 	}
		 	

		 //CLose COnnection.

	}


	/*
		From Here we call our main functions to get and save the data pull
		for each social media
	*/
	private function runData(){
		
		$results = $this->getData();

		if(!is_null($result) && $result ){
			$success = $this->saveData( $results );
		}else{
			$success = false;
		}

		return $success;
		
	}
}

class SocialMedia{
	
	$data_miner = new DataMiner();

	$data_miner->setPlatform('twinker');
	$data_miner->setHashtag('#mzwallace');

	$data_miner->mine();

}


/*

Twinker –
Authentication: 
Done in the header with ‘Authorization’, API Key 123456789 
e.g. ‘Authorization’: ‘Bearer 123456789’
API Endpoint: api.twinker.dev/search/{hashtag}
Response:
{data: [
  {id: 1, text: ‘Checkout my new twinker account! Here’s a picture of me with my #mzwallace.’}, 
  {id: 2, text: ‘Hey #mzwallace, I love twinker!’},
  {id: 3, text: ‘#mzwallace #handbags #<3 spread the @mzwallace love!’}
]}


Instafame –
Authentication:
Done with query params ‘api_key’, ‘hashtag’, API Key 321654987
API Endpoint: api.instafame.dev/api/search
Response:
{[
  {_id: 1, message: ‘Here’s a picture of me with my #mzwallace.’}, 
  {_id: 2, message: ‘Hey #mzwallace, #money #fame!’},
  {_id: 3, message: ‘#mzwallace #handbags #<3 spread the @mzwallace love!’}
]}


Fastbook –
Authentication: 
Done in the header with ‘Authorization’, API Key 456789123 
e.g. ‘Authorization’: ‘Bearer 456789123’
API Endpoint: fastbook.dev/v1/{hashtag}
Response:
{body: [
  {message_id: 1, message_text: ‘Here’s a picture of me with my #mzwallace.’}, 
  {message_id: 2, message_ text: ‘Hey #mzwallace, Wow! That was f@$t!!!’},
  {message_id: 3, message_text: ‘#mzwallace #handbags #<3 spread the @mzwallace love!’}
]}

*/





?>