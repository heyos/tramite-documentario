<?php

require_once "../vendor/autoload.php";
require_once "../controllers/config.php";

class GoogleDrive {

	private static function config(){


		$arr = array(
			'PROD' => array(
				'view' => 'https://drive.google.com/open?id=',
				'carpeta' => '1BOPNvqfPy6PgCT569aD4-8zrrvMSitur',
				'jsonFile' => 'examenesm-17104cf0caed.json'
			),
			'DEV' => array(
				'view' => 'https://drive.google.com/open?id=',
				'carpeta' => '1XwURsUgp3SH6BpPpqZdoA2heIB-j6EFx',
				'jsonFile' => 'cargararchivos-313403-12858a049363.json'
			)				
		);



		return $arr['DEV'];
	}

	private static function client(){

		$googleConfig = self::config();

		$ruta = Config::rutas();
		$jsonFile = $ruta['google'].'/'.$googleConfig['jsonFile'];

		putenv("GOOGLE_APPLICATION_CREDENTIALS=".$jsonFile);

		$client = new Google_Client();
		$client -> useApplicationDefaultCredentials();
		$client -> SetScopes(['https://www.googleapis.com/auth/drive.file']);

		return $client;
	}

	/*
		args verifyFolderOrFile

		$params = array (
			'type' => //folder | file 
			'search' => 'string to search' // folder: 'folder_name' | file: 'file.pdf' | file_id: string id file -> required 
			'in_folder_id' => 'folder_id' //this param is not required
			'response' => //true -> not required
		);
	*/

	public static function verifyFolderOrFile($params){

		$googleConfig = self::config();

		$client = self::client();
		$service = new Google_Service_Drive($client);
		$type = array_key_exists('type',$params) ? $params['type'] : '';

		switch ($type) {
			case 'folder':

				$query ="mimeType='application/vnd.google-apps.folder' and ";
				$query .= sprintf("name contains '%s'",$params['search']);

				break;

			case 'file_id':
				$query = sprintf("id = '%s'",$params['search']);
				break;

			default:
				$query = sprintf("name = '%s'",$params['search']);
				break;
		}

		if(array_key_exists('in_folder_id',$params)){
			if($params['in_folder_id'] != ''){
				$query .= sprintf(" and '%s' in parents",$params['in_folder_id']);
			}
		}
		

		$query = trim($query);
		//echo $query;
				
		$response = $service->files->listFiles(
			array(
			    'q' => $query,
			    'fields' => 'files(id, name, size)'
			)
		);

		if(array_key_exists('response',$params)){
			
			$data = '';

			if($params['response']){
				$data = count($response->files) > 0 ? $response[0] : '';
			}

			return $data;

		}else{

			$id = '';
	        foreach ($response->files as $file) {
	            $id = $file->id;
	        }

	        return $id;

		}			

	}

	public static function crearCarpeta($folderName,$folder_id=''){

		$googleConfig = self::config();

		$client = self::client();
		$service = new Google_Service_Drive($client);

		$args = array(
          'type' => 'folder',
          'search' => $folderName,
          'in_folder' => false
        );

        if($folder_id != ''){
        	$args['in_folder'] =  true;
        	$args['in_folder_id'] = $folder_id;
        }

        $verify = self::verifyFolderOrFile($args);
        $folder_return = $verify; //return folder_id or empty

        if($verify == ''){

        	$folder = new Google_Service_Drive_DriveFile();
			$folder -> setName($folderName);

			$folder_id_upload = $folder_id == '' ? $googleConfig['carpeta'] : $folder_id;
			$folder -> setParents(array($folder_id_upload));
			$mimeType = "application/vnd.google-apps.folder";
			$folder -> setMimeType($mimeType);

			$resultado = $service->files->create(
				$folder,
				array(
					'data' => $folderName,
					'mimeType' => $mimeType,
					'uploadType' => 'media'
				)
			);

			if(is_object($resultado)){
				$folder_return = $resultado -> id;
			}

        }

		return $folder_return;
		
	}

	public static function uploadFile($fileTemp,$carpeta_id){

		$googleConfig = self::config();

		$client = self::client();
		$service = new Google_Service_Drive($client);

		$file = new Google_Service_Drive_DriveFile();
		$file -> setName($fileTemp['nameNew']);

		$file -> setParents(array($carpeta_id));
		$mimeType = $fileTemp['type'];
		$file -> setMimeType($mimeType);

		$resultado = $service->files->create(
			$file,
			array(
				'data' => file_get_contents($fileTemp['tmp_name']),
				'mimeType' => $mimeType,
				'uploadType' => 'media'
			)
		);

		$respuesta = '';

		if(is_object($resultado)){
			$respuesta = $resultado -> id;
		}

		return $respuesta;
	}

	private static function getDataFileOrFolder($id){
		$response = "";

		$client = self::client();
		$service = new Google_Service_Drive($client);
		$data = $service->files->get($id);

		if(is_object($data)){
			$response = $data;
		}

		return $response;
	}

	public static function downloadFile($file_id,$pathDownload = '',$searchInFolder=''){

		$responseOk = false;
		$data = '';
		$message = "";

		$routes = Config::rutas();

		$params = array (
			'search' => $file_id,
			'response' => true
		);

		if($searchInFolder != ''){
			$params['in_folder_id'] = $searchInFolder;
		}

		$file = self::verifyFolderOrFile($params);

		$file_size = 0;
		$file_name = '';

		if(is_object($file)){

			$file_name = $file->name;
			$file_size = intval($file->size);
			$fileId = $file->id;

			$client = self::client();
			$http = $client->authorize();

			$downloadDir = $pathDownload == '' ? date('Y-m-d') : $pathDownload;
			if(!is_dir($downloadDir)){
            	mkdir($downloadDir,0777,true);
          	}

			$myFile = $downloadDir.'/'.$file_name;
			$fp = fopen($myFile, 'w');

			$chunkSizeBytes = 1 * 1024 * 1024;
			$chunkStart = 0;
			$chunkEnd = 0;

			while ($chunkStart < $file_size) {

				$chunkEnd = $chunkStart + $chunkSizeBytes;

			 	$response = $http->request(
			  		'GET',
				  	sprintf('/drive/v3/files/%s', $fileId),
				  	[
				   		'query' => ['alt' => 'media'],
				   		'headers' => [
				       		'Range' => sprintf('bytes=%s-%s', $chunkStart, $chunkEnd)
				   		]
				  	]
			  	);
			  	
			  	$chunkStart = $chunkEnd + 1;
			  	fwrite($fp, $response->getBody()->getContents());

		 	}

		 	if(is_file($myFile)){
		 		$responseOk = true;
		 		$data = $myFile;
		 	}
			
			fclose($fp);

		}else{
			$message = "No existe en drive";
		}

		$return = array(
			'response' => $responseOk,
			'data' => $data,
			'message' => $message
		);

		return $return;
	}
}