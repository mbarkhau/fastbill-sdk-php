<?php declare(strict_types=1);

namespace FastBillSdk\Worktimes;

class WorktimesEntity
{
    public $timeId;

    public $customerId;

    public $projectId;

    public $invoiceId;

    public $date;

    public $startTime = '0000-00-00 00:00:00';

    public $endTime;

    public $minutes;

    public $billableMinutes;

    public $comment;

    const FIELD_MAPPING = [
        'TIME_ID' => 'timeId',
        'CUSTOMER_ID' => 'customerId',
        'PROJECT_ID' => 'projectId',
        'INVOICE_ID' => 'invoiceId',
        'DATE' => 'date',
        'START_TIME' => 'startTime',
        'END_TIME' => 'endTime',
        'MINUTES' => 'minutes',
        'BILLABLE_MINUTES' => 'billableMinutes',
        'COMMENT' => 'comment',
    ];

    const XML_FIELD_MAPPING = [
        'customerId' => 'CUSTOMER_ID',
        'projectId' => 'PROJECT_ID',
        'invoiceId' => 'INVOICE_ID',
        'date' => 'DATE',
        'startTime' => 'START_TIME',
        'endTime' => 'END_TIME',
        'minutes' => 'MINUTES',
        'billableMinutes' => 'BILLABLE_MINUTES',
        'comment' => 'COMMENT',
    ];

    public function __construct(\SimpleXMLElement $data = null)
    {
        if ($data) {
            $this->setData($data);
        }
    }

    /**
     * @param \SimpleXMLElement $data
     * @return WorktimesEntity
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

    /**
     * @return array
     */
    public function getXmlData(): array
    {
        $xmlData = [];
        foreach (self::XML_FIELD_MAPPING as $key => $value) {
            if ($this->$key) {
                $xmlData[$value] = $this->$key;
            }
        }

        return $xmlData;
    }
}
