<?php

namespace Tests;

use App\StringCalculator;
use PHPUnit\Framework\TestCase;
use Exception;

class StringCalculatorTest extends TestCase
{
    private StringCalculator $calculator;

    protected function setUp(): void
    {
        $this->calculator = new StringCalculator();
    }

    public function testEmptyStringReturnsZero(): void
    {
        $result = $this->calculator->add("");
        $this->assertEquals(0, $result);
    }

    public function testSingleNumberReturnsValue(): void
    {
        $this->assertEquals(1, $this->calculator->add("1"));
        $this->assertEquals(50, $this->calculator->add("50"));
    }

    public function testTwoNumbersCommaSeparated(): void
    {
        $this->assertEquals(3, $this->calculator->add("1,2"));
        $this->assertEquals(20, $this->calculator->add("10,10"));
    }

    public function testMultipleNumbers(): void
    {
        $this->assertEquals(10, $this->calculator->add("1,2,3,4"));
    }

    public function testNewLinesAsDelimiters(): void
    {
       
        $this->assertEquals(6, $this->calculator->add("1\n2,3"));
    }

    public function testCustomDelimiter(): void
    {
        $this->assertEquals(3, $this->calculator->add("//;\n1;2"));
        $this->assertEquals(10, $this->calculator->add("//|\n2|3|5"));
    }

    public function testNegativeNumbersThrowException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage("Negatives not allowed: -1, -5");

        $this->calculator->add("2,-1,3,-5");
    }
   
    public function testIgnoreNumbersGreaterThan1000(): void
    {
        $this->assertEquals(2, $this->calculator->add("2,1001"));
    }
}