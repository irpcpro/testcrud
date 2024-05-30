<?php

namespace App\Http\Controllers\Factories;

class FactoryConnector {

    private bool $status;
    private string $message;
    private mixed $data;

    /** @param bool $status */
    public function setStatus(bool $status): static {
        $this->status = $status;
        return $this;
    }

    /** @param string $message */
    public function setMessage(string $message): static {
        $this->message = $message;
        return $this;
    }

    /** @param mixed $data */
    public function setData(mixed $data): static {
        $this->data = $data;
        return $this;
    }

    /** @return bool */
    public function getStatus(): bool {
        return $this->status;
    }

    /** @return string */
    public function getMessage(): string {
        return $this->message;
    }

    /** @return mixed */
    public function getData(): mixed {
        return $this->data;
    }

}
