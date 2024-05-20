<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PingTest extends TestCase
{
    #[Test]
    public function canPing()
    {
        $this->getJson(route('ping'))->assertOk()->assertContent('pong');
    }
}
