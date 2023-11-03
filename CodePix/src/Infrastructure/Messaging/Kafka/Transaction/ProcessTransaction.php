<?php

namespace Core\Infrastructure\Messaging\Kafka\Transaction;

use Core\Application\UseCase\Transaction\Create\CreateTransactionInputDto;
use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Domain\PixKey\Enum\KindType;
use Core\Infrastructure\Messaging\Kafka\LogKafka;
use Core\Infrastructure\Messaging\Kafka\ProcessMessageInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use RdKafka\Message;

class ProcessTransaction implements ProcessMessageInterface
{

    public function __construct(protected CreateTransactionUseCase $createTransactionUseCase)
    {
    }

    public function process(Message $message)
    {
        $payload = json_decode($message->payload, true);

        try {
            $this->validate(payload: $payload ?? []);

            $input = new CreateTransactionInputDto(
                externalId: $payload['external_id'],
                accountId: $payload['account_id'],
                amount: (float)$payload['amount'],
                pixKeyTo: $payload['pix_key_to'],
                pixKeyKindTo: $payload['pix_key_kind_to'],
                description: $payload['description']
            );

            $result = ($this->createTransactionUseCase)($input);

            LogKafka::info(
                topic: $message->topic_name,
                result: json_encode($result)
            );
        } catch (\Throwable $th) {
            LogKafka::error(
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
            'external_id' => 'required',
            'account_id' => 'required|exists:accounts,id',
            'amount' => 'required',
            'pix_key_to' => 'required',
            'pix_key_kind_to' => ['required', new Enum(KindType::class)],
            'description' => 'required',
        ];

        $validator = Validator::make($payload, $rules);

        if ($validator->fails()) {
            $errors = $validator->errors();
            throw new \Exception($errors);
        }
    }
}
