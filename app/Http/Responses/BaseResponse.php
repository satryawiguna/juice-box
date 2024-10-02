<?php

namespace App\Http\Responses;

use App\Enums\MessageType;
use Illuminate\Support\Collection;

class BaseResponse
{
    public string $type;

    public int $codeStatus;

    public Collection $messages;

    public function __construct()
    {
        $this->messages = new Collection();
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCodeStatus(): int
    {
        return $this->codeStatus;
    }

    public function getMessages(): Collection
    {
        return $this->messages ?? new Collection();
    }

    public function isError(): bool
    {
        return $this->messages->filter(function ($item) {
                return $item->messageType === MessageType::ERROR;
            })->count() > 0;
    }

    public function isInfo(): bool
    {
        return $this->messages->filter(function ($item) {
                return $item->messageType === MessageType::INFO;
            })->count() > 0;
    }

    public function isWarning(): bool
    {
        return $this->messages->filter(function ($item) {
                return $item->messageType === MessageType::WARNING;
            })->count() > 0;
    }

    public function isSuccess(): bool
    {
        return $this->messages->filter(function ($item) {
                return $item->messageType === MessageType::SUCCESS;
            })->count() > 0;
    }

    public function addErrorMessage(string $message): void
    {
        $this->messages->push(
            new MessageResponse(MessageType::ERROR,
                $message)
        );
    }

    public function addInfoMessage(string $message): void
    {
        $this->messages->push(
            new MessageResponse(MessageType::INFO,
                $message)
        );
    }

    public function addWarningMessage(string $message): void
    {
        $this->messages->push(
            new MessageResponse(MessageType::WARNING,
                $message)
        );
    }

    public function addSuccessMessage(string $message): void
    {
        $this->messages->push(
            new MessageResponse(MessageType::SUCCESS,
                $message)
        );
    }

    public function getMessageResponseAll(): array
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            $response->push($item->text);
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseAllLatest(): string
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            $response->push($item->text);
        })->all();

        return $response->last();
    }

    public function getMessageResponseError(): array
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::ERROR) {
                $response->push($item->text);
            }
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseErrorLatest(): string
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::ERROR) {
                $response->push($item->text);
            }
        })->all();

        return $response->last();
    }

    public function getMessageResponseInfo(): array
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::INFO) {
                $response->push($item->text);
            }
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseInfoLatest(): string
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::INFO) {
                $response->push($item->text);
            }
        })->all();

        return $response->last();
    }

    public function getMessageResponseWarning(): array
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::WARNING) {
                $response->push($item->text);
            }
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseWarningLatest(): string
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::WARNING) {
                $response->push($item->text);
            }
        })->all();

        return $response->last();
    }

    public function getMessageResponseSuccess(): array
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::SUCCESS) {
                $response->push($item->text);
            }
        })->all();

        return $response->toArray();
    }

    public function getMessageResponseSuccessLatest(): string
    {
        $response = new Collection();

        $this->messages->each(function ($item, $key) use ($response) {
            if ($item->messageType === MessageType::SUCCESS) {
                $response->push($item->text);
            }
        })->all();

        return $response->last();
    }
}
