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

namespace Igorakaamigo\Utils;

/**
 * Class BBCode
 *
 * A lightweight BBCode subset implementation.
 *
 * @package Igorakaamigo\Utils
 */
class BBCode
{
    private static $_specialchars = [
        '#&#'  => '&amp;',
        '#"#'  => '&quot;',
        '#\'#' => '&#039;',
        '#<#'  => '&lt;',
        '#>#'  => '&gt;',
    ];

    private static $_patterns = [
        '#\[b\](.*?)\[/b\]#si'                                   => '<strong>\1</strong>',
        '#\[i\](.*?)\[/i\]#si'                                   => '<em>\1</em>',
        '#\[u\](.*?)\[/u\]#si'                                   => '<span style="text-decoration: underline;">\1</span>',
        '#\[s\](.*?)\[/s\]#si'                                   => '<del>\1</del>',
        '#\[email\](.*?)\[/email\]#si'                           => '<a href="mailto:\1">\1</a>',
        '#\[url\](.*?)\[/url\]#si'                               => '<a href="\1">\1</a>',
        '#\[url=(&quot;)?(.*?)(&quot;)?\](.*?)\[/url\]#si'       => '<a href="\2">\4</a>',
        '#\[img\](.*?)\[/img\]#si'                               => '<img src="\1" alt="" />',
        '#\[quote(=(&quot;)?.*?(&quot;)?)?\](.*?)\[/quote\]#si'  => '<blockquote>\4</blockquote>',
        '#\[code\](.*?)\[/code\]#si'                             => '<code style="white-space: pre;">\1</code>',
        '#\[size=(&quot;)?(\d+)(&quot;)?\](.*?)\[/size\]#si'     => '<span style="font-size: \2px;">\4</span>',
        '#\[size=(&quot;)?(.*?)(&quot;)?\](.*?)\[/size\]#si'     => '<span style="font-size: \2;">\4</span>',
        '#\[color=(&quot;)?(.*?)(&quot;)?\](.*?)\[/color\]#si'   => '<span style="color: \2;">\4</span>',
        '#\[li\](.*?)\[/li\]#si'                                 => '<li>\1</li>',
        '#\[\*\](.*)#'                                           => '<li>\1</li>',
        '#\[ul\](.*?)\[/ul\]#si'                                 => '<ul>\1</ul>',
        '#\[list\](.*?)\[/list\]#si'                             => '<ul>\1</ul>',
        '#\[list=(&quot;)?([1aAiI])(&quot;)?\](.*?)\[/list\]#si' => '<ol type="\2">\4</ol>',
        '#\[ol\](.*?)\[/ol\]#si'                                 => '<ol>\1</ol>',
        '#\[table\](.*?)\[/table\]#si'                           => '<table>\1</table>',
        '#\[tr\](.*?)\[/tr\]#si'                                 => '<tr>\1</tr>',
        '#\[td\](.*?)\[/td\]#si'                                 => '<td>\1</td>',
        '#<li>\s*(.*?)\s*</li>#si'                               => '<li>\1</li>',
        '#(^\s+)|(\s+$)#si'                                      => '',
    ];

    /**
     * BBCode translation
     *
     * @param string $sourceString A string containing BBCode tags
     * @param array $ignoreHtml do not remove these html tags / entities, default value is []
     * @return string HTML string
     */
    static function convert($sourceString, $ignoreHtml = [])
    {
        $processedIgnoreHtml = array_map(function ($e) {
            return self::_htmlspecialchars($e);
        }, $ignoreHtml);

        $result = preg_replace(
            array_keys(self::$_patterns),
            array_values(self::$_patterns),
            self::_htmlspecialchars($sourceString)
        );

        if (count($ignoreHtml) > 0) {
            $result = strtr(
                $result,
                array_combine($processedIgnoreHtml, $ignoreHtml)
            );
        }

        return $result;
    }

    private static function _htmlspecialchars($str)
    {
        return preg_replace(
            array_keys(self::$_specialchars),
            array_values(self::$_specialchars),
            $str
        );
    }
}
