<?php declare(strict_types=1);

namespace FastBillSdk\Worktimes;

use FastBillSdk\Api\ApiClient;
use FastBillSdk\Common\MissingPropertyException;
use FastBillSdk\Common\XmlService;

class WorktimesService
{
    /**
     * @var ApiClient
     */
    private $apiClient;

    /**
     * @var XmlService
     */
    private $xmlService;

    /**
     * @var WorktimesValidator
     */
    private $validator;

    public function __construct(ApiClient $apiClient, XmlService $xmlService, WorktimesValidator $validator)
    {
        $this->apiClient = $apiClient;
        $this->xmlService = $xmlService;
        $this->validator = $validator;
    }

    /**
     * @param WorktimesSearchStruct $searchStruct
     * @return WorktimesEntity[]
     */
    public function getTime(WorktimesSearchStruct $searchStruct): array
    {
        $this->xmlService->setService('time.get');
        $this->xmlService->setFilters($searchStruct->getFilters());
        $this->xmlService->setLimit($searchStruct->getLimit());
        $this->xmlService->setOffset($searchStruct->getOffset());

        $response = $this->apiClient->post($this->xmlService->getXml());

        $xml = new \SimpleXMLElement((string) $response->getBody());
        $results = [];
        foreach ($xml->RESPONSE->TIMES->TIME as $timeEntry) {
            $results[] = new WorktimesEntity($timeEntry);
        }

        return $results;
    }

    public function createTime(WorktimesEntity $entity): WorktimesEntity
    {
        $this->checkErrors($this->validator->validateRequiredCreationProperties($entity));

        $this->xmlService->setService('time.create');
        $this->xmlService->setData($entity->getXmlData());

        $response = $this->apiClient->post($this->xmlService->getXml());

        $xml = new \SimpleXMLElement((string) $response->getBody());

        $entity->timeId = $xml->RESPONSE->TIME_ID;

        return $entity;
    }

    public function updateTime(WorktimesEntity $entity): WorktimesEntity
    {
        $this->checkErrors($this->validator->validateRequiredUpdateProperties($entity));

        $this->xmlService->setService('time.update');
        $this->xmlService->setData($entity->getXmlData());

        $this->apiClient->post($this->xmlService->getXml());

        return $entity;
    }

    public function deleteTime(WorktimesEntity $entity): WorktimesEntity
    {
        $this->checkErrors($this->validator->validateRequiredDeleteProperties($entity));

        $this->xmlService->setService('time.delete');
        $this->xmlService->setData($entity->getXmlData());

        $this->apiClient->post($this->xmlService->getXml());

        $entity->timeId = null;

        return $entity;
    }

    private function checkErrors(array $errorMessages)
    {
        if (!empty($errorMessages)) {
            throw new MissingPropertyException(implode("\r\n", $errorMessages));
        }
    }
}
