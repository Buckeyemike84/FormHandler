<?php

namespace FormHandler;
use \FormHandler\Utils;

/**
 * Generated by PHPUnit_SkeletonGenerator on 2015-12-28 at 11:07:30.
 */
class UtilsTest extends \PHPUnit_Framework_TestCase
{
    public function dataProviderTestHtml()
    {
        return array(
            1 => array('https://test.com/', 'https:&#x2F;&#x2F;test.com&#x2F;'),
            2 => array('https://test.com/<script>', 'https:&#x2F;&#x2F;test.com&#x2F;&lt;script&gt;'),
            3 => array('https://test.com/<script>alert(\'1\')</script>', 'https:&#x2F;&#x2F;test.com&#x2F;&lt;script&gt;alert(&#x27;1&#x27;)&lt;&#x2F;script&gt;'),
            4 => array('https://test.com/<script>alert("1")</script>', 'https:&#x2F;&#x2F;test.com&#x2F;&lt;script&gt;alert(&quot;1&quot;)&lt;&#x2F;script&gt;'),
            5 => array('https://test.com/test.php?">=', 'https:&#x2F;&#x2F;test.com&#x2F;test.php?&quot;&gt;='),
            6 => array('test.com/test.php?">', 'test.com&#x2F;test.php?&quot;&gt;'),
            7 => array('test.php?">', 'test.php?&quot;&gt;'),
        );
    }

    /**
     * @dataProvider dataProviderTestHtml
     */
    public function testHtml($input, $expected)
    {
        $this->assertEquals($expected, Utils::html($input));
    }

    public function dataProviderTestUrl()
    {
        return array(
            1 => array('test.com/test/"><script>', 'http://test.com/test/%22%3E%3Cscript%3E'),
            2 => array('//dev.color-base.com:443/pdc/src/index.php?firstparam=1&secondparam=2#str', '//dev.color-base.com:443/pdc/src/index.php?firstparam=1&secondparam=2#str'),
            3 => array('https://dev.color-base.com:443/pdc/src/index.php?firstparam=1&secondparam=2#str', 'https://dev.color-base.com:443/pdc/src/index.php?firstparam=1&secondparam=2#str'),
            4 => array('dev.color-base.com/pdc/src/index.php', 'http://dev.color-base.com/pdc/src/index.php'),
            5 => array('//test.com?test=test1&secondparam=">', '//test.com?test=test1&secondparam=%22%3E'),
            6 => array('./test.php', './test.php'),
            7 => array('https://test.com/<script>', 'https://test.com/%3Cscript%3E'),
            8 => array('/pdc/src/index.php', '/pdc/src/index.php'),
            9 => array('https://test.com/', 'https://test.com/'),
            10 => array('https://test.com/<script>alert(\'1\')</script>', 'https://test.com/%3Cscript%3Ealert%28%271%27%29%3C/script%3E'),
            11 => array('https://test.com/<script>alert("1")</script>', 'https://test.com/%3Cscript%3Ealert%28%221%22%29%3C/script%3E'),
            12 => array('https://test.com/"><script>', 'https://test.com/%22%3E%3Cscript%3E'),
            13 => array('https://test.com/test.php?">', 'https://test.com/test.php?%22%3E='),
            14 => array('test.com/test.php?">', 'http://test.com/test.php?%22%3E='),
            15 => array('./test.php?">', './test.php?%22%3E='),
            16 => array('http://test.com/test/%2F%22%3E%3Cscript%3E', 'http://test.com/test/%2F%22%3E%3Cscript%3E'),
            17 => array('http://test.com/test/%252F%2522%253E%253Cscript%253E', 'http://test.com/test/%252F%2522%253E%253Cscript%253E'),
            18 => array('https://test.com/<script>al/ert("1")</script>', 'https://test.com/%3Cscript%3Eal/ert%28%221%22%29%3C/script%3E'),
        );
    }


    /**
     * @dataProvider dataProviderTestUrl
     */
    public function testUrl($input, $expected)
    {
        $this->assertEquals($expected, Utils::url($input));
    }

    /**
     * @covers Utils::buildRequestUrl
     */
    public function testbuildRequestUrl()
    {
        $list = array(
            'https://test.com/<script>' => 'https://test.com/%3Cscript%3E',
            'https://test.com/index.php?test=1&2=<script>' => 'https://test.com/index.php?test=1&2=%3Cscript%3E',
            'https://test.com/<script>alert(\'1\')</script>' => 'https://test.com/%3Cscript%3Ealert%28%271%27%29%3C/script%3E',
            'https://test.com/<script>alert("1")</script>' => 'https://test.com/%3Cscript%3Ealert%28%221%22%29%3C/script%3E',
            'https://test.com/test.php?">' => 'https://test.com/test.php?%22%3E=',
            'https://test.com/test.php?test=1&a=">\'' => 'https://test.com/test.php?test=1&a=%22%3E%27',
        );

        foreach($list as $input => $check)
        {
            $url = parse_url($input);

            $protocol = array_key_exists('scheme', $url)
                ? $url['scheme']
                : 'http';

            $host = array_key_exists('host', $url)
                ? $url['host']
                : 'localhost';

            if(array_key_exists('path', $url))
            {
                $host .= $url['path'];
            }

            $query = array_key_exists('query', $url)
                ? '?'.$url['query']
                : '';

            $this->assertEquals($check, Utils::buildRequestUrl($protocol, $host, $query));
        }
    }
}
