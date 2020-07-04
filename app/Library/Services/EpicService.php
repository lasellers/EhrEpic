<?php

namespace App\Library\Services;

use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Client as HttpClient;
use Mockery\Exception;

// "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/Patient/Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB"

class EpicService
{
    protected $epicUrl = "https://open-ic.epic.com/FHIR/api/FHIR/DSTU2/";
    protected $headers = [
        'Accept' => 'application/json',
        'Accept-Encoding' => 'gzip',
        'Accept-Language' => 'en-US,en;q=0.9'
    ];

    /**
     * Test accounts:
     * Jason Argonaut ?family=Argonaut&given=Jason
     * Jessica Argonaut ?family=Argonaut&given=Jessica
     * James Kirk ?family=James&given=Kirk
     * Daisy Tinsley ?family=Tinsley&given=Daisy
     *
     * @param $queryData
     * @return \ArrayObject
     * @throws GuzzleException
     */
    public function searchPatients($queryData)
    {
        $client = new HttpClient($this->headers);
        $urlQuery = http_build_query($queryData);
        $res = $client->request('GET', "{$this->epicUrl}/Patient?$urlQuery", [
            'headers' => $this->headers
        ]);
        /** @var object */
        $rawPatientSearch = json_decode($res->getBody(), true);
        return $this->rawPatientSearchToIterator($rawPatientSearch);
    }

    /**
     * @param $rawPatientSearch
     * @return \ArrayObject
     */
    protected function rawPatientSearchToIterator($rawPatientSearch)
    {
        /*        throw_if(
                    $rawPatientSearch['total'] != 0 &&
                    $rawPatientSearch['total'] !== count($rawPatientSearch['entry']),
                    new Exception('Malformed EPIC data'));
        */
        //
        $patients = array_map(function ($obj) {
            return $obj['resource'];
        }, $rawPatientSearch['entry']);
        $patients = array_filter($patients, function ($obj) {
            return $obj['resourceType'] == 'Patient';
        });

        return new \ArrayObject($patients);
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

    /**
     * @param $patientId Tbt3KuCY0B5PSrJvCu2j-PlK.aiHsu2xUjUM8bWpetXoB
     * @param $procedureId T2ffTCnlLQ-grHJP5yDSZjn5j0NrpKynvAK9vwE7XNDAB
     * @return mixed
     * @throws GuzzleException
     */
    public function getProcedure(string $patientId, string $procedureId)
    {
        $client = new HttpClient($this->headers);
        $res = $client->request('GET', "{$this->epicUrl}/Procedure?patient={$patientId}&_id={$procedureId}", [
            'headers' => $this->headers
        ]);
        /** @var object */
        return json_decode($res->getBody());
    }

    public function getProcedures($patientId)
    {
        $client = new HttpClient($this->headers);
        $res = $client->request('GET', "{$this->epicUrl}/Procedure?patient={$patientId}", [
            'headers' => $this->headers
        ]);
        /** @var object */
        $rawProcedures = json_decode($res->getBody(), true);

        return $this->rawProceduresToIterator($rawProcedures);
    }

    /**
     * @param $rawProcedures
     * @return array
     * @throws \Throwable
     */
    protected function rawProceduresToIterator($rawProcedures)
    {
        /* throw_if(
             $rawProcedures['total'] !== count($rawProcedures['entry']),
             new Exception('Malformed EPIC data'));
        */
        //
        $patients = array_map(function ($obj) {
            return $obj['resource'];
        }, $rawProcedures['entry']);

        $iterator = new \ArrayObject($patients);

        return iterator_to_array($iterator);
    }

}
