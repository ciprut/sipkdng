<?php
namespace App\Libraries;

class Libs{

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
        $result=file_get_contents($url,false,$context);
        $data=['header'=>$http_response_header,'content'=>$result];
        return $data;
    }

    public function getjson($url,$cookie=""){
        $opts = array(
          'http' => array(
            'method' => 'GET',
            'header' => "Accept-language: en\r\n" .
                        'Cookie: '.$cookie
          )
        );
        $context = stream_context_create($opts);
        $result = file_get_contents($url, false, $context);
        $data=['header'=>$http_response_header,'content'=>$result];

        return $result;
      }
    public function get($url,$cookie=''){
        $opt=[
            'http'=>[
                'method'=>'GET',
                'header'=>"Accept-language: en\r\n".
                          'Cookie: '.$cookie
            ]
        ];
        $context=stream_context_create($opt);
        $result=file_get_contents($url,false,$context);
        $data=['header'=>$http_response_header,'content'=>$result];
        return $data;
    }
    public function getHTML($url,$cookie=''){
        $opt=[
            'http'=>[
                'method'=>'GET',
                'header'=>"Accept-language: en\r\n".
                          'Cookie: '.$cookie
            ]
        ];
        $context=stream_context_create($opt);
        $html=file_get_contents($url,false,$context);
        //$data=['header'=>$http_response_header,'content'=>$result];
        $encodedHTML = str_replace('</script>','#-#',$html);
        $encodedHTML = str_replace('<script>','#---#',$encodedHTML);

        $results = explode("#---#",$encodedHTML);
        $results = explode("#-#",$results[1]);
        $res = str_replace(" var ","",$results[0]);
        $res = str_replace('"',"",$res);
        $res = explode(",",$res);
        $data = [];
        for($n=0;$n<sizeof($res);$n++){
            $h = explode("=",$res[$n]);
            $data[$h[0]] = $h[1];
        }
        $data['header'] = $http_response_header;
//        var_dump($http_response_header);
        return $data;
    }

    public function Cookie($data){
        $tmp=[];
        for($i=count($data)-1;$i>=0;$i--){
            if(substr($data[$i],0,11)=="Set-Cookie:"){
                $tmp2=explode(';',$data[$i]);
                array_push($tmp,substr($tmp2[0],strlen("Set-Cookie:"),strlen($tmp2[0])-strlen("Set-Cookie:")));
            }
                
        }
        return implode(';',$tmp);
    }
    public function CookieNew($data){
        $tmp=[];
        for($i=count($data)-1;$i>=0;$i--){
            if(substr($data[$i],0,11)=="Set-Cookie:"){
                $tmp2=explode(';',$data[$i]);
                array_push($tmp,substr($tmp2[0],strlen("Set-Cookie:"),strlen($tmp2[0])-strlen("Set-Cookie:")));
            }
                
        }
        return implode(';',$tmp);
    }

    public function cookieArray($data){
        $tmp=[];
        for($i=count($data)-1;$i>=0;$i--){
            if(substr($data[$i],0,11)=="Set-Cookie:"){
                $tmp2=explode(';',$data[$i]);
                $tmp3=substr($tmp2[0],strlen("Set-Cookie:"),strlen($tmp2[0])-strlen("Set-Cookie:"));
                $tmp4=explode('=',$tmp3);
                $tmp[$tmp4[0]]=$tmp4[1];
            }
        }
        return $tmp;
    }

    public function token($data){
        $tmp=explode('<meta name="_token" content="',$data);
        $tmp2=explode('">',$tmp[1]);
        return $tmp2[0];
    }

    public function siaptoken($data){
        $tmp=explode('<meta name="csrf-token" content="',$data);
        $tmp2=explode('">',$tmp[1]);
        return $tmp2[0];
    }
}