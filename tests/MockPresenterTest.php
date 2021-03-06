<?php

namespace Krak\Tests;

use Krak\Presenter\Exception\CannotPresentException,
    Krak\Presenter\MockPresenter,
    Krak\Tests\TestCase,
    RuntimeException,
    stdClass;

class MockPresenterTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testInitialState()
    {
        $p = new MockPresenter();
        $this->assertEquals(0, $p->getStorage()->count());
    }

    public function testMock()
    {
        $p = new MockPresenter();

        $obj = new stdClass();
        $p->mock($obj, 'data');

        $this->assertEquals('data', $p->getStorage()[$obj]);
    }

    public function testPresent()
    {
        $p = new MockPresenter();

        $obj = new stdClass();
        $p->mock($obj, 'data');

        $this->assertEquals('data', $p->present($obj));
    }

    public function testPresentException()
    {
        $p = new MockPresenter();

        $obj = new stdClass();

        try {
            $p->present($obj);
            $this->assertTrue(false, 'did not throw an exception');
        } catch (CannotPresentException $e) {
            $this->assertTrue(true);
        }
    }
}
