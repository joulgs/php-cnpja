<?php

namespace JGS\CNPJa;

class CNPJaInterface
{
    private $token = null;
    private $url = 'https://api.cnpja.com/office/';
    private $cnp = null;
    private $response = null;
    private $isValid = false;

    public function __construct($token, $cnp)
    {
        $this->token = trim($token);
        $this->cnp = preg_replace('/\D/', '', trim($cnp));

        $this->doResearch();
    }

    private function doResearch()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $this->url . $this->cnp,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "authorization: " . $this->token,
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            $this->isValid = false;
        } else {
            $response = json_decode($response);

            if (isset($response->code) && $response->code == 404) {
                $this->isValid = false;
            } else {
                $this->response = $response;
                $this->isValid = true;
            }
        }
    }

    public function getFounded()
    {
        return $this->response->founded;
    }

    public function getName()
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

    public function getPhoneFormatted()
    {
        if (isset($this->response->phones[0])) {
            $p1 = substr($this->response->phones[0]->number, 0, 4);
            $p2 = substr($this->response->phones[0]->number, 4, 4);
            return "({$this->response->phones[0]->area}) {$p1}-{$p2}";
        } else {
            return '';
        }
    }

    public function getPhone()
    {
        return isset($this->response->phones[0]->area) && isset($this->response->phones[0]->number) ? $this->response->phones[0]->area . $this->response->phones[0]->number : null;
    }

    public function getCnpj()
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

    public function getState()
    {
        return $this->response->address->state;
    }

    public function getCity()
    {
        return $this->response->address->city;
    }

    public function getCityCode()
    {
        return $this->response->address->municipality;
    }

    public function getStreet()
    {
        return $this->response->address->street;
    }

    public function getNumber()
    {
        return $this->response->address->number;
    }

    public function getDistrict()
    {
        return $this->response->address->district;
    }

    public function getComplement()
    {
        return isset($this->response->address->details) ? $this->response->address->details : null;
    }

    public function getZipCode()
    {
        return $this->response->address->zip;
    }

    public function getCountry()
    {
        return $this->response->address->country->name;
    }

    public function getStatus()
    {
        return $this->response->status->text;
    }

    public function isActive()
    {
        return $this->response->status->id === 2 ? true : false;
    }

    public function getCNAE()
    {
        return $this->response->mainActivity->id;
    }

    public function getMunicipalityCode()
    {
        return $this->response->address->municipality;
    }

    public function isHead()
    {
        return $this->response->head;
    }

    public function getMainCnaeCode()
    {
        return $this->response->mainActivity->id;
    }

    public function getMainCnaeDescription()
    {
        return $this->response->mainActivity->text;
    }

    public function getSideCnaeArray()
    {
        $object = $this->response->sideActivities;

        $array = [];

        foreach ($object as $key => $value) {
            $array[] = array('code' => $value->id, 'description' => $value->text);
        }

        return $array;
    }

    public function getAllCnaeArray()
    {
        $mainCnae = $this->response->mainActivity;

        $array[] = array('code' => $mainCnae->id, 'description' => $mainCnae->text, 'main' => true);

        $sideCnae = $this->response->sideActivities;

        foreach ($sideCnae as $key => $value) {
            $array[] = array('code' => $value->id, 'description' => $value->text, 'main' => false);
        }

        return $array;
    }

    public function isValid()
    {
        return $this->isValid;
    }
}
