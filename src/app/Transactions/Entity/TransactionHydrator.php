<?php

namespace App\Transactions\Entity;

use App\Exceptions\InvalidTransactionDateException;
use App\Exceptions\InvalidTransactionValueException;
use Carbon\Carbon;
use Exception;
use InvalidArgumentException;
use Illuminate\Support\Facades\Validator;

class TransactionHydrator
{
    const validation = [
        'merchant' => 'required|int',
        'date' => 'required|date',
        'value' => 'regex:^[\$\£€][0-9]+.[0-9]{2}',
    ];

    const expectedFieldsCount = 3;

    private function validateRawPayload($data)
    {
        $dataCount = count($data);
        if ($dataCount !== self::expectedFieldsCount) {
            throw new InvalidArgumentException(
                'Unable to hydrate Transaction. Expected ' . self::expectedFieldsCount
                . ' fields. Received '
                . $dataCount
            );
        }
        Validator::make($data, self::validation);
    }

    public function fromArray(array $data)
    {
        $data = $this->mapPayloadToFields($data);

        return new Transaction(
            (int) $data['merchant'],
            $data['date'],
            $data['currency'],
            $data['value']
        );
    }

    /**
     * Maps raw payload into key value pair of properties, eg.
     * [ 0 => 1, 1 => '2020-01-01 00:00:00', 2 => '$2.01'] maps into
     * [ merchant => 1, date => '...', value => '' ]
     *
     *
     * @param array $data
     * @return array
     */
    private function mapPayloadToFields(array $data): array
    {
        $this->validateRawPayload($data);
        $mappedData = [];
        foreach (array_keys(self::validation) as $key => $property) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException('Transaction Payload missing required fields');
            }
            $mappedData[$property] = $data[$key];
        }

        $currency = mb_substr($mappedData['value'], 0, 1);
        $value = mb_substr($mappedData['value'], 1);
        if (!is_numeric($value)) {
            throw new InvalidTransactionValueException();
        }
        try {
            $transactionDate = Carbon::parse($mappedData['date']);
        } catch (Exception $e) {
            throw new InvalidTransactionDateException('Invalid transaction date');
        }
        $mappedData['value'] = $value;
        $mappedData['date'] = $transactionDate;
        $mappedData['currency'] = Currency::fromCurrencyCode($currency);

        return $mappedData;
    }
}