<?php

namespace Core\Infrastructure\Messaging\Kafka\Transaction;

use Core\Application\UseCase\Transaction\Create\CreateTransactionUseCase;
use Core\Application\UseCase\Transaction\Status\SaveTransactionInputDto;
use Core\Application\UseCase\Transaction\Status\SaveTransactionUseCase;
use Core\Domain\PixKey\Enum\KindType;
use Core\Infrastructure\Messaging\Kafka\LogKafka;
use Core\Infrastructure\Messaging\Kafka\ProcessMessageInterface;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\ValidationException;
use RdKafka\Message;

class ProcessSaveTransaction implements ProcessMessageInterface
{

    public function __construct(protected SaveTransactionUseCase $saveTransactionUseCase)
    {
    }

    public function process(Message $message)
    {
        $payload = json_decode($message->payload, true);

        try {
            $this->validate(payload: $payload ?? []);

            $input = new SaveTransactionInputDto(
                externalId: $payload['external_id'],
                status: $payload['status'],
            );

            $result = ($this->saveTransactionUseCase)($input);

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
