<?php

namespace pixelandtonic\dynamodb;

use yii\base\InvalidConfigException;
use yii\di\Instance;
use yii\web\Session;

class DynamoDbSession extends Session
{
    public DynamoDBConnection|string|array $dynamoDb = 'dynamoDb';
    public string $dataAttribute = 'data';

    /**
     * While a gcSession method is provided, it should not be used in most cases.
     * Instead, configure DynamoDB's TTL settings to expire entries based on the ttl attribute.
     *
     * @inheritdoc
     */
    public $gCProbability = 0;

    /**
     * @inheritDoc
     * @throws InvalidConfigException
     */
    public function init(): void
    {
        parent::init();
        $this->dynamoDb = Instance::ensure($this->dynamoDb, DynamoDbConnection::class);
        $this->setTimeout($this->getTimeout());
    }

    public function setTimeout($value): void
    {
        parent::setTimeout($value);

        // Prevent premature set from constructor
        if ($this->dynamoDb instanceof DynamoDbConnection) {
            $this->dynamoDb->ttl = $value;
        }
    }

    /**
     * @inheritDoc
     */
    public function getUseCustomStorage(): bool
    {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function readSession($id): string
    {
        $item = $this->dynamoDb->getItem($id);
        $data = $item[$this->dataAttribute] ?? '';
        $ttl = $item[$this->dynamoDb->ttlAttribute] ?? null;

        if ($ttl && $ttl <= time()) {
            $this->destroySession($id);

            return '';
        }

        return $data;
    }

    /**
     * @inheritDoc
     */
    public function writeSession($id, $data): bool
    {
        return (bool) $this->dynamoDb->updateItem($id, [
            $this->dataAttribute => $data,
        ]);
    }

    /**
     * @inheritDoc
     */
    public function destroySession($id): bool
    {
        return (bool) $this->dynamoDb->deleteItem($id);
    }

    /**
     * @inheritDoc
     */
    public function gcSession($maxLifetime): bool
    {
        $this->dynamoDb->deleteExpired();

        return true;
    }
}
