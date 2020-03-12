<?php

namespace Bibace\Foundation\Http;

use GuzzleHttp\Psr7\Response;
use Psr\Http\Message\ResponseInterface;

class BaseResponse extends Response
{
    public function getBodyContents()
    {
        $this->getBody()->rewind();
        $contents = $this->getBody()->getContents();
        $this->getBody()->rewind();

        return $contents;
    }

    public static function buildFromPsrResponse(ResponseInterface $response) 
    {
        return new static(
            $response->getStatusCode(),
            $response->getHeaders(),
            $response->getBody(),
            $response->getProtocolVersion(),
            $response->getReasonPhrase()
        );
    }

    public function toObject()
    {
        return json_decode($this->toJson);
    }

    public function toJson()
    {
        return json_encode($this->toArray());
    }

    public function toArray()
    {
        $content = $this->removeControlCharacters($this->getBodyContents());

        $array = json_decode($content, true, 512, JSON_BIGINT_AS_STRING);

        if(JSON_ERROR_NONE === json_last_error()) {
            return (array) $array;
        }

        return [];
    }

    public function __toString()
    {
        return $this->getBodyContents();
    }

    public function removeControlCharacters(string $content)
    {
        return \preg_replace('/[\x00-\x1F\x80-\x9F]/u', '', $content);
    }
}