<?php declare(strict_types=1);

namespace FastBillSdk\Projects;

class ProjectsEntity
{
    public $projectId;

    public $projectName;

    public $customerId;

    public $customerCostcenterId;

    public $hourPrice;

    public $currencyCode;

    public $vatPercent;

    public $startDate;

    public $endDate;

    public $tasks;

    const FIELD_MAPPING = [
        'PROJECT_ID' => 'projectId',
        'PROJECT_NAME' => 'projectName',
        'CUSTOMER_ID' => 'customerId',
        'CUSTOMER_COSTCENTER_ID' => 'customerCostcenterId',
        'HOUR_PRICE' => 'hourPrice',
        'CURRENCY_CODE' => 'currencyCode',
        'VAT_PERCENT' => 'vatPercent',
        'START_DATE' => 'startDate',
        'END_DATE' => 'endDate',
        'TASKS' => 'tasks',
    ];

    const XML_FIELD_MAPPING = [
        'projectId' => 'PROJECT_ID',
        'projectName' => 'PROJECT_NAME',
        'customerId' => 'CUSTOMER_ID',
        'customerCostcenterId' => 'CUSTOMER_COSTCENTER_ID',
        'hourPrice' => 'HOUR_PRICE',
        'currencyCode' => 'CURRENCY_CODE',
        'vatPercent' => 'VAT_PERCENT',
        'startDate' => 'START_DATE',
        'endDate' => 'END_DATE',
        'tasks' => 'TASKS',
    ];

    public function __construct(\SimpleXMLElement $data = null)
    {
        if ($data) {
            $this->setData($data);
        }
    }

    /**
     * @param \SimpleXMLElement $data
     * @return ProjectsEntity
     */
    public function setData(\SimpleXMLElement $data): self
    {
        foreach ($data as $key => $value) {
            if (!isset(self::FIELD_MAPPING[$key])) {
                trigger_error('the provided xml key ' . $key . ' is not mapped at the moment in ' . self::class);
                continue;
            }

            $this->{self::FIELD_MAPPING[$key]} = (string) $value;
        }

        return $this;
    }
}
