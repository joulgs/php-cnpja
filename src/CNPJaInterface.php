<?php

namespace JGS\CNPJa;

class CNPJaInterface
{
    private $token = null;
    private $url = 'https://api.cnpja.com/office/';
    private $cnp = null;
    private $response = null;

    public function __construct($token, $cnp)
    {
        $this->token = trim($token);
        $this->cnp = preg_replace('/\D/' , '', trim($cnp));
        
        $this->doResearch();
    }

    private function doResearch(): bool
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url.$this->cnp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: ".$this->token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err)
            return false;
        
        $this->response = json_decode($response);
        return true;
    }

    public function getFounded(): String
    {
        return $this->response->founded;
    }

    public function getName(): String
    {
        return $this->response->company->name;
    }
}
