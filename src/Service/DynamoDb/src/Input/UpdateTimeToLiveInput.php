<?php

namespace AsyncAws\DynamoDb\Input;

use AsyncAws\Core\Exception\InvalidArgument;
use AsyncAws\Core\Input;
use AsyncAws\Core\Request;
use AsyncAws\Core\Stream\StreamFactory;
use AsyncAws\DynamoDb\ValueObject\TimeToLiveSpecification;

final class UpdateTimeToLiveInput extends Input
{
    /**
     * The name of the table to be configured.
     *
     * @required
     *
     * @var string|null
     */
    private $TableName;

    /**
     * Represents the settings used to enable or disable Time to Live for the specified table.
     *
     * @required
     *
     * @var TimeToLiveSpecification|null
     */
    private $TimeToLiveSpecification;

    /**
     * @param array{
     *   TableName?: string,
     *   TimeToLiveSpecification?: \AsyncAws\DynamoDb\ValueObject\TimeToLiveSpecification|array,
     *   @region?: string,
     * } $input
     */
    public function __construct(array $input = [])
    {
        $this->TableName = $input['TableName'] ?? null;
        $this->TimeToLiveSpecification = isset($input['TimeToLiveSpecification']) ? TimeToLiveSpecification::create($input['TimeToLiveSpecification']) : null;
        parent::__construct($input);
    }

    public static function create($input): self
    {
        return $input instanceof self ? $input : new self($input);
    }

    public function getTableName(): ?string
    {
        return $this->TableName;
    }

    public function getTimeToLiveSpecification(): ?TimeToLiveSpecification
    {
        return $this->TimeToLiveSpecification;
    }

    /**
     * @internal
     */
    public function request(): Request
    {
        // Prepare headers
        $headers = [
            'Content-Type' => 'application/x-amz-json-1.0',
            'X-Amz-Target' => 'DynamoDB_20120810.UpdateTimeToLive',
        ];

        // Prepare query
        $query = [];

        // Prepare URI
        $uriString = '/';

        // Prepare Body
        $bodyPayload = $this->requestBody();
        $body = empty($bodyPayload) ? '{}' : json_encode($bodyPayload);

        // Return the Request
        return new Request('POST', $uriString, $query, $headers, StreamFactory::create($body));
    }

    public function setTableName(?string $value): self
    {
        $this->TableName = $value;

        return $this;
    }

    public function setTimeToLiveSpecification(?TimeToLiveSpecification $value): self
    {
        $this->TimeToLiveSpecification = $value;

        return $this;
    }

    private function requestBody(): array
    {
        $payload = [];
        if (null === $v = $this->TableName) {
            throw new InvalidArgument(sprintf('Missing parameter "TableName" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['TableName'] = $v;
        if (null === $v = $this->TimeToLiveSpecification) {
            throw new InvalidArgument(sprintf('Missing parameter "TimeToLiveSpecification" for "%s". The value cannot be null.', __CLASS__));
        }
        $payload['TimeToLiveSpecification'] = $v->requestBody();

        return $payload;
    }
}
