<?php

namespace App\Transactions\Entity;

use App\Currencies\Entity\Currency;
use App\Exceptions\Transactions\InvalidTransactionDateException;
use App\Exceptions\Transactions\InvalidTransactionValueException;
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

    private static function validateRawPayload($data)
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

    public static function fromArray(array $data)
    {
        $data = self::mapPayloadToFields($data);

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
    private static function mapPayloadToFields(array $data): array
    {
        self::validateRawPayload($data);
        $mappedData = [];
        foreach (array_keys(self::validation) as $key => $property) {
            if (!array_key_exists($key, $data)) {
                throw new InvalidArgumentException('Transaction Payload missing required fields');
            }
            $mappedData[$property] = $data[$key];
        }

        $value = mb_substr($mappedData['value'], 1);
        if (!is_numeric($value)) {
            throw new InvalidTransactionValueException();
        }
        try {
            $transactionDate = Carbon::parse($mappedData['date']);
        } catch (Exception $e) {
            throw new InvalidTransactionDateException('Invalid transaction date');
        }

        $currency = mb_substr($mappedData['value'], 0, 1);
        $mappedData['currency'] = Currency::fromCurrencyCode($currency);
        $mappedData['value'] = $value * 100;
        $mappedData['date'] = $transactionDate;

        return $mappedData;
    }
}