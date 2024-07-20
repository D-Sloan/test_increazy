<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class CepSearch extends Controller
{
    
    public function searchCEP($ceps){
        $array_cep = [];

        /*separa os ceps recebidos por virgula e retira apenas os números*/
        foreach(explode(",", $ceps) as $cep_value){
            $array_cep[] = $this->extractNumbersFromCep($cep_value);
        }

        /*Faz as buscas dos CEPs e organiza em um array*/
        $apiData = [];
        foreach($array_cep as $cep){

            /*Verifica a validade*/
            if (strlen($cep) == 8) {
                $recive_cep = $this->requestCepData($cep);
                /* Como exibido no retorno, o CEP deve vir apenas os números */
                $recive_cep["cep"] = $cep;
                $apiData[] = $recive_cep;
            } else {
                $apiData[] = ['cep' => $cep, 'error' => 'CEP inválido'];
            }
        }

        return response()->json($apiData);

    }

    /*Realiza a extração apenas dos números do cep*/
    private function extractNumbersFromCep($cep) {
        $formated_cep = preg_replace('/\D/', '', $cep);
        return $formated_cep;
    }

    /*Faz a requisição para a API do viacep*/
    private function requestCepData($cep)
    {
        $client = new Client();
        $response = $client->get("https://viacep.com.br/ws/{$cep}/json/");
        
        if ($response->getStatusCode() == 200) {
            $retorno = json_decode($response->getBody()->getContents(), true);
            if(!isset($retorno['erro'])){
                return $retorno;
            }
            
        }

        return ['cep' => $cep, 'error' => 'CEP inválido'];
    }


}
