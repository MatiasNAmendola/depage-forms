<?php

use depage\htmlform\elements\text;

class textToStringTest extends PHPUnit_Framework_TestCase {
    public function setUp() {
        $this->form = new nameTestForm;
        $this->text = new text('textName', array(), $this->form);
    }

    public function testSimple() {
        $expected = '<p id="formName-textName" class="input-text" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName</span>' .
                '<input name="textName" type="text" value="">' .
            '</label>' .
        '</p>' . "\n";

        $this->assertEquals($expected, $this->text->__toString());
    }

    public function testValue() {
        $expected = '<p id="formName-textName" class="input-text" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName</span>' .
                '<input name="textName" type="text" value="testValue">' .
            '</label>' .
        '</p>' . "\n";

        $this->text->setValue('testValue');
        $this->assertEquals($expected, $this->text->__toString());
    }

    public function testRequired() {
        $expected = '<p id="formName-textName" class="input-text required" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName <em>*</em></span>' .
                '<input name="textName" type="text" required value="">' .
            '</label>' .
        '</p>' . "\n";

        $this->text->setRequired();
        $this->assertEquals($expected, $this->text->__toString());
    }

    public function testList() {
        $expected ='<p id="formName-textName" class="input-text" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName</span>' .
                '<input name="textName" type="text" list="formName-textName-list" value="">' .
                '<datalist id="formName-textName-list">' .
                    '<option value="item1">' .
                    '<option value="item2">' .
                    '<option value="item3">' .
                '</datalist>' .
            '</label>' .
        '</p>' . "\n";

        $parameters = array(
            'list' => array('item1', 'item2', 'item3')
        );
        $text = new text('textName', $parameters, $this->form);
        $this->assertEquals($expected, $text->__toString());
    }

    public function testAssociativeList() {
        $expected = '<p id="formName-textName" class="input-text" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName</span>' .
                '<input name="textName" type="text" list="formName-textName-list" value="">' .
                '<datalist id="formName-textName-list">' .
                    '<option value="key1" label="item1">' .
                    '<option value="key2" label="item2">' .
                    '<option value="key3" label="item3">' .
                '</datalist>' .
            '</label>' .
        '</p>'. "\n";

        $parameters = array(
            'list' => array(
                'key1' => 'item1',
                'key2' => 'item2',
                'key3' => 'item3',
            )
        );
        $text = new text('textName', $parameters, $this->form);
        $this->assertEquals($expected, $text->__toString());
    }

    public function testHtmlEscaping() {
        $expected = '<p id="formName-textName" class="input-text required" title="ti&quot;&gt;tle" data-errorMessage="er&quot;&gt;rorMessage">' .
            '<label>' .
                '<span class="label">la&quot;&gt;bel <em>ma&quot;&gt;rker</em></span>' .
                '<input name="textName" type="text" required value="">' .
            '</label>' .
        '</p>' . "\n";

        $parameters = array(
            'label'         => 'la">bel',
            'marker'        => 'ma">rker',
            'errorMessage'  => 'er">rorMessage',
            'title'         => 'ti">tle',
            'required'      => true,
        );
        $text = new text('textName', $parameters, $this->form);
        $this->assertEquals($expected, $text->__toString());
    }

    public function testHtmlEscapedList() {
        $expected = '<p id="formName-textName" class="input-text" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName</span>' .
                '<input name="textName" type="text" list="formName-textName-list" value="">' .
                '<datalist id="formName-textName-list">' .
                    '<option value="it&quot;&gt;em1">' .
                    '<option value="it&quot;&gt;em2">' .
                    '<option value="it&quot;&gt;em3">' .
                '</datalist>' .
            '</label>' .
        '</p>' . "\n";

        $parameters = array(
            'list' => array('it">em1', 'it">em2', 'it">em3'),
        );
        $text = new text('textName', $parameters, $this->form);
        $this->assertEquals($expected, $text->__toString());
    }

     public function testEscapedAssociativeList() {
        $expected = '<p id="formName-textName" class="input-text" data-errorMessage="Please enter valid data!">' .
            '<label>' .
                '<span class="label">textName</span>' .
                '<input name="textName" type="text" list="formName-textName-list" value="">' .
                '<datalist id="formName-textName-list">' .
                    '<option value="ke&quot;&gt;y1" label="it&quot;&gt;em1">' .
                    '<option value="ke&quot;&gt;y2" label="it&quot;&gt;em2">' .
                    '<option value="ke&quot;&gt;y3" label="it&quot;&gt;em3">' .
                '</datalist>' .
            '</label>' .
        '</p>'. "\n";

        $parameters = array(
            'list' => array(
                'ke">y1' => 'it">em1',
                'ke">y2' => 'it">em2',
                'ke">y3' => 'it">em3',
            )
        );

        $text = new text('textName', $parameters, $this->form);
        $this->assertEquals($expected, $text->__toString());
    }
}