<?php

namespace App\Http\Controllers\Factories\ResponseFactory;

use App\Http\Controllers\Controller;

class ResponseFactoryController extends Controller {

    const NAME_STATUS = 'status';
    const NAME_STATUS_CODE = 'status_code';
    const NAME_MESSAGE = 'message';
    const NAME_DATA = 'data';

    /**
     * @param bool $status
     * @param string $message
     * @param mixed $data
     * @param int $status_code
     */
    public function __construct(
        private bool $status,
        private string $message,
        private mixed $data,
        private int $status_code = 200
    ){

    }

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

    /** @param int $status_code */
    public function setStatusCode(int $status_code): void {
        $this->status_code = $status_code;
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

    /** @return int */
    public function getStatusCode(): int {
        return $this->status_code;
    }

    /**
     * get the last data for return to response
     * @return array
     * */
    public function get(): array {
        return [
            $this::NAME_STATUS => $this->status,
            $this::NAME_STATUS_CODE => $this->status_code,
            $this::NAME_MESSAGE => $this->message,
            $this::NAME_DATA => $this->data,
        ];
    }

}
