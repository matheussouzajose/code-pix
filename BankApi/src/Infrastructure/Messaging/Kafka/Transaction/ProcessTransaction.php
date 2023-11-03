<?php

namespace Core\Infrastructure\Messaging\Kafka\Transaction;

use Core\Application\UseCase\Transaction\Save\SaveTransactionInputDto;
use Core\Application\UseCase\Transaction\Save\SaveTransactionUseCase;
use Core\Domain\Shared\Messaging\Publisher\PublisherInterface;
use Core\Domain\Transaction\Enum\TransactionStatus;
use Core\Infrastructure\Messaging\Kafka\KafkaLog;
use Core\Infrastructure\Messaging\Kafka\ProcessMessageInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use RdKafka\Message;

class ProcessTransaction implements ProcessMessageInterface
{
    public function __construct(
        protected SaveTransactionUseCase $saveTransactionUseCase,
    ) {
    }

    public function process(Message $message): void
    {
        $payload = json_decode($message->payload, true);

        try {
            $this->validate(payload: $payload ?? []);

            $input = new SaveTransactionInputDto(
                externalId: $payload['external_id'],
                accountId: $payload['account_id'],
                amount: $payload['amount'],
                pixKeyTo: $payload['pix_key_to'],
                pixKindTo: $payload['pix_key_kind_to'],
                description: $payload['description'],
                status: TransactionStatus::tryFrom($payload['status'])->value,
            );

            $result = ($this->saveTransactionUseCase)(input: $input);

            KafkaLog::info(
                topic: $message->topic_name,
                result: json_encode($result)
            );
        } catch (\Throwable $th) {
            KafkaLog::error(
                topic: $message->topic_name,
                error: $th->getMessage()
            );
        }
    }

    /**
     * @throws ValidationException
     * @throws \Exception
     */
    protected function validate($payload): void
    {
        $rules = [
            'external_id' => 'required|exists:transactions,external_id',
            'account_id' => 'required|exists:bank_accounts,id',
            'amount' => 'required',
            'pix_key_to' => 'required',
            'pix_key_kind_to' => 'required',
            'description' => 'required',
            'status' => ['required', new Enum(TransactionStatus::class)],
        ];

        $validator = Validator::make($payload, $rules);

        if ( $validator->fails() ) {
            $errors = $validator->errors();
            throw new \Exception($errors);
        }
    }
}
