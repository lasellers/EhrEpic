<?php

namespace App\Library\Services;

use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as HttpClient;
use Mockery\Exception;

// $ curl "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/Patient/Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB"

class EpicService
{
    protected $epicUrl = "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/";
    protected $headers = [
        'Accept' => 'application/json',
        'Accept-Encoding' => 'gzip',
        'Accept-Language' => 'en-US,en;q=0.9'
    ];

    /**
     * @param $family
     * @param $given
     * @return array
     * @throws GuzzleException
     * @throws \Throwable
     */
    public function searchPatients($family, $given)
    {
        $client = new HttpClient($this->headers);
        $res = $client->request('GET', "{$this->epicUrl}/Patient?family={$family}&given={$given}", [
            'headers' => $this->headers
        ]);
        /** @var object */
        $rawPatientSearch = json_decode($res->getBody(), true);

        return $this->rawPatientSearchToIterator($rawPatientSearch);
    }

    /**
     * @param $rawPatientSearch
     * @return array
     * @throws \Throwable
     */
    protected function rawPatientSearchToIterator($rawPatientSearch)
    {
        throw_if(
            $rawPatientSearch['total'] !== count($rawPatientSearch['entry']),
            new Exception('Malformed EPIC data'));

        //
        $patients = array_map(function ($obj) {
            return
                //  'patient_id'=>$obj['resource']['id'], ...$obj['resource']
                $obj['resource'];
        }, $rawPatientSearch['entry']);

        $iterator = new \ArrayObject($patients);

        $patients = iterator_to_array($iterator);
        return $patients;
    }

    /**
     * @param $patientId
     * @return mixed
     * @throws GuzzleException
     */
    public function getPatient($patientId)
    {
        $client = new HttpClient($this->headers);
        $res = $client->request('GET', "{$this->epicUrl}/Patient/{$patientId}", [
            'headers' => $this->headers
        ]);
        /** @var object */
        $patient = json_decode($res->getBody());

        return $patient;
    }

}
