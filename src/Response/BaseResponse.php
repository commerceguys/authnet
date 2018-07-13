<?php

namespace CommerceGuys\AuthNet\Response;

use CommerceGuys\AuthNet\DataTypes\Message;
use Psr\Http\Message\ResponseInterface as HttpResponseInterface;

/**
 * Class BaseResponse
 * @package CommerceGuys\AuthNet\Response
 */
abstract class BaseResponse implements ResponseInterface
{
    /**
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected $response;

    /**
     * @var object
     */
    protected $contents;

    /**
     * BaseResponse constructor.
     * @param \Psr\Http\Message\ResponseInterface $response
     */
    public function __construct(HttpResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * Returns the response raw data.
     *
     * @return mixed
     */
    public function contents()
    {
        return $this->contents;
    }

    public function getResultCode()
    {
        return $this->contents->messages->resultCode;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        if (is_array($this->contents->messages->message)) {
            $messages = [];
            foreach ($this->contents->messages->message as $item) {
                $messages[] = new Message([
                  'code' => $item->code,
                  'text' => $item->text,
                ]);
            }
            return $messages;
        } else {
            return [
              new Message([
                  'code' => $this->contents->messages->message->code,
                  'text' => $this->contents->messages->message->text,
              ])
            ];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getMessageCode()
    {
        if (is_array($this->contents->transactionResponse->messages->message)) {
            return $this->contents->transactionResponse->messages->message[0]->code;
        } else {
            return $this->contents->transactionResponse->messages->message->code;
        }
    }

    public function getErrors()
    {
        if (!isset($this->contents->transactionResponse->errors)) {
            return [];
        }

        if (is_array($this->contents->transactionResponse->errors)) {
            $messages = [];
            foreach ($this->contents->transactionResponse->errors as $item) {
                $messages[] = new Message([
                  'code' => $item->errorCode,
                  'text' => $item->errorText,
                ]);
            }
            return $messages;
        } else {
            return [
              new Message([
                'code' => $this->contents->transactionResponse->errors->error->errorCode,
                'text' => $this->contents->transactionResponse->errors->error->errorText,
              ])
            ];
        }
    }

    public function __isset($name)
    {
        return isset($this->contents->$name);
    }

    public function __get($name)
    {
        return $this->contents->$name;
    }
}
