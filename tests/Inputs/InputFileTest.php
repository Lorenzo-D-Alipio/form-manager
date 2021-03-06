<?php
use FormManager\Builder;

class InputFileTest extends BaseTest
{
    public function testBasic()
    {
        $this->_testElement(Builder::file());
        $this->_testField(Builder::file());
        $this->_testRequired(Builder::file());
    }

    public function testError()
    {
        $input = Builder::file();

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => __DIR__.'/image.jpg',
            'error' => 1,
        ));

        $this->assertFalse($input->isValid());
        $this->assertEquals('The uploaded file exceeds the upload_max_filesize directive in php.ini', $input->error());
    }

    public function testMimeType()
    {
        $input = Builder::file();

        $input->accept('image/png');

        $input->val(array(
            'name' => 'image.jpg',
            'type' => 'image/jpeg',
            'tmp_name' => dirname(__DIR__).'/image.jpg',
            'error' => 0,
        ));

        $this->assertFalse($input->isValid());

        $input->accept('image/jpeg');

        $this->assertTrue($input->isValid(), $input->error());
    }
}
