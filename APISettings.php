<?php 
public class APISettings{

	$platform;
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

	/* Will Make Database Connection and Insert The records */
	private function saveRecord(){
		//Assuming we have a database created with a table name social_media_records and the required fields;
		/* 
			id PRIMARY KEY, INTEGER,  AUTOINCREMENT, NOT NULL,
		 	data_id DEFAULT, INTEGER, 
		 	data_message VARCHAR  
		*/

		 try{

		 	//Create connection 
		 	//Verify the connection 

		 	//Insert EX: 

		 	//Build The Query
		 	$query = "INSERT INTO social_media_records (data_id, data_message) VALUES( ";
		 	$len = count($array_data);
		 	$i = 0;
		 
		 	foreach($array_data as $records){
		 		$query .= '(' $records['id'].', '.$records['text'].' ) '; 
		 	
		 		if($i <= $len -1 )		
		 			$query .= ' ,';
		 	
		 		$i ++;
		 	}

		 	//Execute Query 
		 	//If success return true;
		 	//CLose Connection.

		 }catch(Exception $error){
		 	echo 'ERROR: ',  $error->getMessage();
		 	$success = false;
		 }

		return $success;
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
	

	private function saveData($result = null ){

		if(is_null( $result )){
			return false;
		}

		switch( $this->platform ){

			case 'instafame':
				$main_tag = "{body: [{";
				$id_tag = 'message_id: ';
				$msg_tag = ', message_text: ';

				$array_data = $this->parseAndCleanData($main_tag, $id_tag, $msg_tag );
			break;

			case 'twinker':
				$main_tag = "{data: [{";
				$id_tag = 'id: ';
				$msg_tag = ', text: ';

				$array_data = $this->parseAndCleanData($main_tag, $id_tag, $msg_tag );
			break;

			case 'fastbook':
				$main_tag = "[{";
				$id_tag = '_id: ';
				$msg_tag = ', message: ';

				$array_data = $this->parseAndCleanData($main_tag, $id_tag, $msg_tag );
			break;
		}

		return $this->saveRecord( $array_data );

	}


	/*
		From Here we call our main functions to get and save the data pull
		for each social media
	*/
	public function runData(){
		
		$results = $this->getData();

		if(!is_null($result) && $result ){
			$success = $this->saveData( $results );
		}else{
			$success = false;
		}

		return $success;
	}
}

?>
