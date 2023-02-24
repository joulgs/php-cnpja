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

    public function getFounded(): string
    {
        return $this->response->founded;
    }

    public function getName(): string
    {
        return $this->response->company->name;
    }

    public function getAlias()
    {
        return isset($this->response->alias) ? $this->response->alias : null;
    }

    public function getAddress() 
    {
        return $this->response->address;
    }

    public function getPhoneFormatted(): string
    {
        $p1 = substr($this->response->phones[0]->number, 0, 4);
        $p2 = substr($this->response->phones[0]->number, 4, 4);
        return "({$this->response->phones[0]->area}) {$p1}-{$p2}";
    }

    public function getPhone(): string
    {
        return $this->response->phones[0]->area.$this->response->phones[0]->number;
    }

    public function getCnpj(): string
    {
        return $this->cnp;
    }

    public function getResponse()
    {
        return $this->response;
    }

    public function getEmail()
    {
        return isset($this->response->emails[0]->address) ? $this->response->emails[0]->address : null;
    }

    public function getState(): string
    {
        return $this->response->address->state;
    }

    public function getCity(): string
    {
        return $this->response->address->city;
    }

    public function getStreet(): string
    {
        return $this->response->address->street;
    }

    public function getNumber(): string
    {
        return $this->response->address->number;
    }
    
    public function getDistrict(): string
    {
        return $this->response->address->district;
    }

    public function getComplement()
    {
        return isset($this->response->address->details) ? $this->response->address->details : null;
    }

    public function getZipCode(): string
    {
        return $this->response->address->zip;
    }
    
    public function getCountry(): string
    {
        return $this->response->address->country->name;
    }

    public function getStatus(): string
    {
        return $this->response->status->text;
    }

    public function isActive(): bool
    {
        return $this->response->status->id === 2 ? true : false;
    }

    public function getCNAE(): int
    {
        return $this->response->mainActivity->id;
    }

    public function getMunicipalityCode(): int
    {
        return $this->response->address->municipality;
    }

    public function isHead(): bool
    {
        return $this->response->head;
    }

    public function getMainCnaeCode(): string
    {
        return $this->response->mainActivity->id;
    }

    public function getMainCnaeDescription(): string
    {
        return $this->response->mainActivity->text;
    }

    public function getSideCnaeArray(): array
    {
        $object = $this->response->sideActivities;

        $array = [];
        
        foreach ($object as $key => $value) {
            $array[] = Array('code' => $value->id, 'description' => $value->text);
        }

        return $array;
    }

    public function getAllCnaeArray(): array
    {
        $mainCnae = $this->response->mainActivity;

        $array[] = Array('code' => $mainCnae->id, 'description' => $mainCnae->text, 'main' => true);

        $sideCnae = $this->response->sideActivities;

        foreach ($sideCnae as $key => $value) {
            $array[] = Array('code' => $value->id, 'description' => $value->text, 'main' => false);
        }

        return $array;
    }
}
