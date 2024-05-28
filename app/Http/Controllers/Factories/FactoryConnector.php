<?php

namespace App\Http\Controllers\Factories;

abstract class FactoryConnector {

    private bool $status;
    private string $message;
    private mixed $data;

    /** @param bool $status */
    public function setStatus(bool $status): void {
        $this->status = $status;
    }

    /** @param string $message */
    public function setMessage(string $message): void {
        $this->message = $message;
    }

    /** @param mixed $data */
    public function setData(mixed $data): void {
        $this->data = $data;
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
