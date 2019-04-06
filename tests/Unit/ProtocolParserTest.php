<?php

namespace seregazhuk\React\Memcached\tests\Unit;

use PHPUnit\Framework\TestCase;
use seregazhuk\React\Memcached\Exception\WrongCommandException;
use seregazhuk\React\Memcached\Protocol\Parser;
use seregazhuk\React\Memcached\Protocol\Request\Request;
use seregazhuk\React\Memcached\Protocol\Request\SimpleRequest;
use seregazhuk\React\Memcached\Protocol\Request\StorageRequest;

final class ProtocolParserTest extends TestCase
{
    /** @test */
    public function it_returns_instance_of_request(): void
    {
        $parser = new Parser();
        $this->assertInstanceOf(Request::class, $parser->createRequest('version', []));
    }

    /** @test */
    public function it_creates_simple_request_for_non_storage_commands(): void
    {
        $parser = new Parser();
        $this->assertInstanceOf(SimpleRequest::class, $parser->createRequest('version', []));
    }

    /** @test */
    public function it_creates_storage_request_for_storage_commands(): void
    {
        $parser = new Parser();
        $this->assertInstanceOf(StorageRequest::class, $parser->createRequest('set', ['key', 'val']));
    }

    /** @test */
    public function it_throws_exception_for_unknown_command(): void
    {
        $this->expectException(WrongCommandException::class);
        $parser = new Parser();
        $parser->createRequest('unknown', []);
    }

    /** @test */
    public function it_throws_exception_when_parsing_response_for_unknown_command(): void
    {
        $this->expectException(WrongCommandException::class);
        $parser = new Parser();
        $parser->parseResponse('unknown', '');
    }
}
