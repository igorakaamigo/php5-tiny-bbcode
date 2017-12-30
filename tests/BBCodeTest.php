<?php
/**
 * MIT License
 *
 * Copyright (c) 2017 Igor M Osipov
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 */

use \Igorakaamigo\Utils\BBCode;

final class BBCodeTest extends PHPUnit_Framework_TestCase
{
    public function testItShouldReplaceHtmlEntities()
    {
        $expected = '&lt;div class=&quot;b-example&quot;&gt;
        &lt;div class=&quot;b-example_inner&quot;&gt;
          &lt;p&gt;A &amp; paragraph&lt;/p&gt;
        &lt;/div&gt;
      &lt;/div&gt;';
        $source = '
      <div class="b-example">
        <div class="b-example_inner">
          <p>A & paragraph</p>
        </div>
      </div>
    ';
        $this->assertEquals($expected, BBCode::convert($source));
    }

    public function testItShouldStripLeadingAndTrailingWhitespaces()
    {
        $expected = 'A  string to be returned';
        $source = "     A  string to be returned   \t\n\r     ";
        $this->assertEquals($expected, BBCode::convert($source));
    }

    public function testItShouldDealWithNestedTags()
    {
        $expected = '<del><span style="text-decoration: underline;"><strong><em>A text to be processed</em></strong></span></del>';
        $source = '   [s][u][b][i]A text to be processed[/i][/b][/u][/s]   ';
        $this->assertEquals($expected, BBCode::convert($source));

        $expected = '<a href="http://www.google.com/"><img src="http://www.domain.tld/upload/123.png" alt="" /></a>';
        $source = '[url=http://www.google.com/][img]http://www.domain.tld/upload/123.png[/img][/url]';
        $this->assertEquals($expected, BBCode::convert($source));
    }

    public function testItShouldDealWithTagB()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('b', function ($v) {
            return "<strong>$v</strong>";
        });
    }

    public function testItShouldDealWithAnAlternateListDefinitionUl() {
        $this->_itShouldBehaveLikeAList(
            '[list]',
            '[/list]',
            '<ul>',
            '</ul>'
        );
    }

    public function testItShouldDealWithAnAlternateListDefinitionOlType1() {
        $this->_itShouldBehaveLikeAList(
            '[list=1]',
            '[/list]',
            '<ol type="1">',
            '</ol>'
        );

        $this->_itShouldBehaveLikeAList(
            '[list="1"]',
            '[/list]',
            '<ol type="1">',
            '</ol>'
        );
    }

    public function testItShouldDealWithAnAlternateListDefinitionOlTypeSmallA() {
        $this->_itShouldBehaveLikeAList(
            '[list=a]',
            '[/list]',
            '<ol type="a">',
            '</ol>'
        );

        $this->_itShouldBehaveLikeAList(
            '[list="a"]',
            '[/list]',
            '<ol type="a">',
            '</ol>'
        );
    }

    public function testItShouldDealWithAnAlternateListDefinitionOlTypeCapitalA() {
        $this->_itShouldBehaveLikeAList(
            '[list=A]',
            '[/list]',
            '<ol type="A">',
            '</ol>'
        );

        $this->_itShouldBehaveLikeAList(
            '[list="A"]',
            '[/list]',
            '<ol type="A">',
            '</ol>'
        );
    }

    public function testItShouldDealWithAnAlternateListDefinitionOlTypeSmallI() {
        $this->_itShouldBehaveLikeAList(
            '[list=i]',
            '[/list]',
            '<ol type="i">',
            '</ol>'
        );

        $this->_itShouldBehaveLikeAList(
            '[list="i"]',
            '[/list]',
            '<ol type="i">',
            '</ol>'
        );
    }

    public function testItShouldDealWithAnAlternateListDefinitionOlTypeCapitalI() {
        $this->_itShouldBehaveLikeAList(
            '[list=I]',
            '[/list]',
            '<ol type="I">',
            '</ol>'
        );

        $this->_itShouldBehaveLikeAList(
            '[list="I"]',
            '[/list]',
            '<ol type="I">',
            '</ol>'
        );
    }

    public function testItShouldDealWithTagI()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('i', function ($v) {
            return "<em>$v</em>";
        });
    }

    public function testItShouldDealWithTagU()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('u', function ($v) {
            return "<span style=\"text-decoration: underline;\">$v</span>";
        });
    }

    public function testItShouldDealWithTagS()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('s', function ($v) {
            return "<del>$v</del>";
        });
    }

    public function testItShouldDealWithTagUl()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('ul', function ($v) {
            return "<ul>$v</ul>";
        });
    }

    public function testItShouldDealWithTagOl()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('ol', function ($v) {
            return "<ol>$v</ol>";
        });
    }

    public function testItShouldDealWithTagLi()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('li', function ($v) {
            return '<li>' . preg_replace('#(^\s+)|(\s+$)#', '', $v) . '</li>';
        });
    }

    public function testItShouldDealWithTagTable()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('table', function ($v) {
            return "<table>$v</table>";
        });
    }

    public function testItShouldDealWithTagTr()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('tr', function ($v) {
            return "<tr>$v</tr>";
        });
    }

    public function testItShouldDealWithTagTd()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('td', function ($v) {
            return "<td>$v</td>";
        });
    }

    public function testItShouldDealWithTagUrl()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('url', function ($v) {
            return "<a href=\"$v\">$v</a>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('url', 'http://www.google.com/', function ($v) {
            return "<a href=\"http://www.google.com/\">$v</a>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('url', '"http://www.google.com/"', function ($v) {
            return "<a href=\"http://www.google.com/\">$v</a>";
        });
    }

    public function testItShouldDealWithTagEmail()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('email', function ($v) {
            return "<a href=\"mailto:$v\">$v</a>";
        });
    }

    public function testItShouldDealWithTagImg()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('img', function ($v) {
            return "<img src=\"$v\" alt=\"\" />";
        });
    }

    public function testItShouldDealWithTagQuote()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('quote', function ($v) {
            return "<blockquote>$v</blockquote>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('quote', '"Quote author"', function ($v) {
            return "<blockquote>$v</blockquote>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('quote', 'Quote author', function ($v) {
            return "<blockquote>$v</blockquote>";
        });
    }

    public function testItShouldDealWithTagCode()
    {
        $this->_itShouldBehaveLikeASimpleWrapperTag('code', function ($v) {
            return "<code style=\"white-space: pre;\">$v</code>";
        });
    }

    public function testItShouldDealWithTagSize()
    {
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('size', '"20"', function ($v) {
            return "<span style=\"font-size: 20px;\">$v</span>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('size', '20', function ($v) {
            return "<span style=\"font-size: 20px;\">$v</span>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('size', '"20em"', function ($v) {
            return "<span style=\"font-size: 20em;\">$v</span>";
        });
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('size', '20em', function ($v) {
            return "<span style=\"font-size: 20em;\">$v</span>";
        });
    }

    public function testItShouldDealWithTagColor()
    {
        $this->_itShouldBehaveLikeAnAttributedWrapperTag('color', '"#AABBCC"', function ($v) {
            return "<span style=\"color: #AABBCC;\">$v</span>";
        });

        $this->_itShouldBehaveLikeAnAttributedWrapperTag('color', '#AABBCC', function ($v) {
            return "<span style=\"color: #AABBCC;\">$v</span>";
        });
    }

    public function testItShouldDealWithIgnoreHtmlParam() {
        $expected = "A leading string &nbsp;&quot;<br><br/><br /> A trailing string";
        $source = 'A leading string &nbsp;&quot;<br><br/><br /> A trailing string';
        $ignoreHtml = array(
            '&nbsp;',
            '&quot;',
            '<br>',
            '<br/>',
            '<br />',
        );
        $this->assertEquals($expected, BBCode::convert($source, $ignoreHtml));
    }

    public function testItShouldNotBreakSingleByteCharsetString() {
        $expected = iconv('utf-8', 'cp1251', 'Строка&amp;nbsp;со <спецсимволами>');
        $source = iconv('utf-8', 'cp1251', 'Строка&nbsp;со <спецсимволами>');
        $this->assertEquals($expected, BBCode::convert($source, [iconv('utf-8', 'cp1251', '<спецсимволами>')]));
    }

    private function _itShouldBehaveLikeAList($inA, $inB, $outA, $outB) {
        $expected =  $outA . '
        <li>Item 1</li>
        <li>Item 2</li>
        <li>Item 3</li>
        ' . $outB;
        $source = "
        {$inA}
        [*]Item 1
        [*] Item 2 \t
        [*]  Item 3  \t
        {$inB}
        ";
        $this->assertEquals($expected, BBCode::convert($source));
    }

    private function _itShouldBehaveLikeAnAttributedWrapperTag($tagName, $attributeValue, $tagBuilder)
    {
        $expected = "A leading string {$tagBuilder('A tag string')} A trailing string";
        $source = "A leading string [$tagName=$attributeValue]A tag string[/$tagName] A trailing string";
        $this->assertEquals($expected, BBCode::convert($source), 'It should render a correct markup');

        $uTag = strtoupper($tagName);
        $source = "A leading string [$uTag=$attributeValue]A tag string[/$uTag] A trailing string";
        $this->assertEquals($expected, BBCode::convert($source), 'Tag names should be case-insensitive');

        $expected = "A leading part {$tagBuilder('
      A tag value
    ')} A trailing part";
        $source = "A leading part [$tagName=$attributeValue]
      A tag value
    [/$tagName] A trailing part";
        $this->assertEquals($expected, BBCode::convert($source),
            'Tag content should be processed as a multiline string');
    }

    private function _itShouldBehaveLikeASimpleWrapperTag($tagName, $tagBuilder)
    {
        $expected = "A leading part {$tagBuilder('A tag value')} A trailing part";
        $source = "A leading part [$tagName]A tag value[/$tagName] A trailing part";
        $this->assertEquals($expected, BBCode::convert($source), 'It should render a correct markup');

        $uTag = strtoupper($tagName);
        $source = "A leading part [$uTag]A tag value[/$uTag] A trailing part";
        $this->assertEquals($expected, BBCode::convert($source), 'Tag names should be case-insensitive');

        $expected = "A leading part {$tagBuilder('
      A tag value
    ')} A trailing part";
        $source = "A leading part [$tagName]
      A tag value
    [/$tagName] A trailing part";
        $this->assertEquals($expected, BBCode::convert($source),
            'Tag content should be processed as a multiline string');
    }
}
