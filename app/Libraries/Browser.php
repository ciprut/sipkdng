<? 
	namespace App\Libraries;
	class Browser{
	  public $content = '';

	  public function set_cookies_json($cookies){
	    $cookies_json = json_decode($cookies, true);
	    $cookies_array = array();
	    foreach ($cookies_json as $key => $value){
	      $cookies_array[] = $key .'='.$value;
	    }
	    $this->request_cookies = 'Cookie: ' . join('; ', $cookies_array) . "\r\n";
	  }

	  public function set_cookies_string($cookies){
	    $this->request_cookies = 'Cookie: ' . $cookies . "\r\n";
	  }

	  public function cookie($header){
      $cookie="";
      $c=[];  
      for($i=count($header)-1;$i>=0;$i--){
          if(substr($header[$i],0,11)=="Set-Cookie:"){
              $tmp=substr($header[$i],11,strlen($header[$i])-11);
              $tmp2=explode(';',$tmp);
              array_push($c,$tmp2[0]);
          }
      }
      $cookie=implode('; ',$c);
      return $cookie;
  	}

	  public function get_cookies($data){
	    $result = "";

	    $cookies_array = array();
	    foreach($data as $s){
	      if (preg_match('|^Set-Cookie:\s*([^=]+)=([^;]+);(.+)$|', $s, $parts)){
	        $cookies_array[] = $parts[1] . '=' . $parts[2];
	      }
	    }
	    $result = join('; ', $cookies_array);
	    return $result;
	  }

	  public function getToken($url){
	  	 $opts = array(
	      'http' => array(
	        'method' => 'GET',
	        'header' => "Accept-language: en\r\n"
	      )
	    );
	    $context = stream_context_create($opts);
			$result = file_get_contents($url,false,$context);

			$result = str_replace('<','',$result);
			$result = str_replace('>','----',$result);
			$cookie=$this->get_cookies($http_response_header);
			$arr = explode('meta name="_token" content="',$result);
			$tkn = explode('"----',$arr[1]);
	    return ['token'=>$tkn[0],'cookie'=>$cookie];
	  }

	  public function get($url,$cookie=""){
	    $opts = array(
	      'http' => array(
	        'method' => 'GET',
	        'header' => "Accept-language: en\r\n" .
	                    "Cookie: ".$cookie
	      )
	    );
	    $context = stream_context_create($opts);
	    $response = file_get_contents($url, true, $context);
	    $this->content = $response;
	    return ['header'=>$http_response_header,'content'=>$response];
	  }

	  public function getjson($url,$cookie=""){
	    $opts = array(
	      'http' => array(
	        'method' => 'GET',
	        'header' => "Accept-language: en\r\n" .
	                    "Cookie: ".$cookie
	      )
	    );
	    $context = stream_context_create($opts);
	    $data = file_get_contents($url, false, $context);
	    return $data;
	  }

	  public function post($url,$param,$cookie){
      $context= stream_context_create([
          "http"=>[
              "method"=>"POST",
              "header"=>"Content-Type: application/x-www-form-urlencoded; charset=UTF-8\r\n".
                        "Cookie: ".$cookie."\r\n".
                        "Content-Length: ".strlen($param)."\r\n",
              "content"=>$param
          ]
      ]);
      $response=file_get_contents($url,false,$context);
      $data=['header'=>$http_response_header,'content'=>$response];
      return $data;
 		}
	}	
?>
