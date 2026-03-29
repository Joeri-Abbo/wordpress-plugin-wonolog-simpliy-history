<?php

namespace WonologSimplyHistory\Tests;

use PHPUnit\Framework\TestCase;
use WonologSimplyHistory\WSHErrorHandler;

class ErrorHandlerTest extends TestCase
{
    private WSHErrorHandler $handler;

    protected function setUp(): void
    {
        $this->handler = new WSHErrorHandler();
    }

    public function testCheckValueReturnsValueWhenNotEmpty(): void
    {
        $this->assertSame('hello', $this->handler->check_value('hello'));
        $this->assertSame(42, $this->handler->check_value(42));
    }

    public function testCheckValueReturnsEmptyStringForFalsyValues(): void
    {
        $this->assertSame('', $this->handler->check_value(''));
        $this->assertSame('', $this->handler->check_value(null));
        $this->assertSame('', $this->handler->check_value(false));
    }
}
