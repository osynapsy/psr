<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use Osynapsy\Psr\Http\Stream\StringStream;

/**
 * Description of StringStreamTest
 *
 * @author Pietro Celeste <p.celeste@osynapsy.net>
 */
class StringStreamTest extends TestCase
{
    public function testStream(): void
    {
        $string = 'prova';
        $stream = new StringStream($string, 'w');
        $this->assertEquals((string) $stream, $string);
    }

    public function testStreamIsReadable(): void
    {
        $string1 = 'test the StringStream';
        $stream1 = new StringStream($string1, 'r');
        $this->assertTrue($stream1->isReadable());
        $stream2 = new StringStream($string1, 'a');
        $this->assertTrue($stream2->isReadable());
    }

    public function testStreamRead(): void
    {
        $string = 'test the StringStream';
        $stream = new StringStream($string);
        $result = $stream->read(3);
        $this->assertEquals('tes', $result);
    }

    public function testStreamRead2(): void
    {
        $string = 'test the StringStream';
        $stream = new StringStream($string);
        $stream->read(3);
        $str2 = $stream->read(3);
        $this->assertEquals('t t', $str2);
    }

    public function testGetContents(): void
    {
        $string = 'test the StringStream';
        $stream = new StringStream($string);
        $stream->read(5);
        $this->assertEquals($stream->getContent(), 'the StringStream');
    }

    public function testStreamIsWritable(): void
    {
        $string1 = 'test the StringStream';
        $stream = new StringStream($string1, 'w');
        $this->assertTrue($stream->isWritable());
    }

    public function testWrite(): void
    {
        $string1 = 'test the StringStream';
        $string2 = ' and it method write';
        $stream = new StringStream($string1);
        $stream->end();
        $stream->write($string2);
        $stream->rewind();
        $this->assertEquals($stream->getContent(), $string1.$string2);
    }

    public function testSteramIsEof(): void
    {
        $string1 = 'test the StringStream';
        $stream = new StringStream($string1, 'r');
        $stream->read(9);
        $stream->read(13);
        $this->assertTrue($stream->eof());
    }

    public function testStreamSeek(): void
    {
        $string1 = 'test the StringStream';
        $stream = new StringStream($string1, 'r');
        $stream->getContent();
        $stream->seek(5);
        $this->assertEquals($stream->getContent(), 'the StringStream');
    }

    public function testStreamTell(): void
    {
        $string1 = 'test the StringStream';
        $stream = new StringStream($string1, 'r');
        $stream->seek(5);
        $stream->read(5);
        $this->assertEquals(10, $stream->tell());
    }

    public function testStreamSearch(): void
    {
        $string1 = 'test the StringStream';
        $stream = new StringStream($string1, 'r');
        $this->assertEquals(5, $stream->search('the'));
    }

/*    public function testStreamPrepend(): void
    {
        $stream = new StringStream('<html>{{main}}</html>', 'a');
        $stream->prepend('test prepend', '{{main}}');
        $stream->rewind();
        $this->assertEquals('<html>test prepend{{main}}</html>', $stream->getContents());
    }

    public function testStreamPostpend(): void
    {
        $stream = new StringStream('<html>{{main}}</html>', 'a');
        $stream->postpend('test postpend', '{{main}}');
        $stream->rewind();
        $this->assertEquals('<html>{{main}}test postpend</html>', $stream->getContents());
    }
 */

    protected function debug($result)
    {
        var_dump($result);
        ob_flush();
    }
}
