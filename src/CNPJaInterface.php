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

    public function getAddress(): object
    {
        return $this->response->address;
    }

    public function getPhoneFormatted(): String
    {
        $p1 = substr($this->response->phones[0]->number, 0, 4);
        $p2 = substr($this->response->phones[0]->number, 4, 4);
        return "({$this->response->phones[0]->area}) {$p1}-{$p2}";
    }

    public function getPhone(): String
    {
        return $this->response->phones[0]->area.$this->response->phones[0]->number;
    }

    public function getCnpj(): String
    {
        return $this->cnp;
    }

    public function getResponse(): object
    {
        return $this->response;
    }

    public function getEmail(): String
    {
        return $this->response->emails[0]->address;
    }

    public function getState(): String
    {
        return $this->response->address->state;
    }

    public function getCity(): String
    {
        return $this->response->address->city;
    }

    public function getStreet(): String
    {
        return $this->response->address->street;
    }

    public function getNumber(): String
    {
        return $this->response->address->number;
    }
    
    public function getDistrict(): String
    {
        return $this->response->address->district;
    }

    public function getZipCode(): String
    {
        return $this->response->address->zip;
    }
    
    public function getCountry(): String
    {
        return $this->response->address->country->name;
    }

    public function getStatus(): String
    {
        return $this->response->status->text;
    }

    public function isActive(): bool
    {
        return $this->response->status->id === 2 ? true : false;
    }
}
