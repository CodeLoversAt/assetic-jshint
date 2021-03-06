<?php
/**
 * @package assetic-jshint
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 08.03.14
 * @time 16:29
 */

namespace CodeLovers\Test;


use Assetic\Asset\FileAsset;
use Assetic\Asset\StringAsset;
use Assetic\Exception\FilterException;
use Assetic\Filter\FilterInterface;
use Assetic\Test\Filter\FilterTestCase;
use CodeLovers\Assetic\Filter\JsHintFilter;

class JsHintFilterTest extends FilterTestCase
{
    /**
     * @var FilterInterface
     */
    private $filter;

    protected function setUp()
    {
        $jsHintBinary = $this->findExecutable('jshint', 'JSHINT_BIN');

        if (!$jsHintBinary) {
            $this->markTestSkipped('unable to find `jshint` executable');
        }

        $this->filter = new JsHintFilter($jsHintBinary);
    }

    public function testFilterLoadValid()
    {
        $file = __DIR__ . '/../../js/valid.js';
        $asset = new FileAsset($file);
        $asset->load();

        // the filter will not change the content
        $expected = $asset->getContent();

        $this->filter->filterLoad($asset);

        $this->assertEquals($expected, $asset->getContent());
    }

    public function testFilterLoadValidWithStringAssets()
    {
        $file = __DIR__ . '/../../js/valid.js';
        $content = file_get_contents($file);
        $asset = new StringAsset($content);
        $asset->load();

        // the filter will not change the content
        $expected = $content;

        $this->filter->filterLoad($asset);

        $this->assertEquals($expected, $asset->getContent());
    }

    /**
     * @expectedException \Assetic\Exception\FilterException
     */
    public function testFilterLoadInvalid()
    {
        $file = __DIR__ . '/../../js/invalid.js';
        $asset = new FileAsset($file);
        $asset->load();

        try {
            $this->filter->filterLoad($asset);
        } catch(FilterException $e) {
            printf($e->getMessage());

            throw $e;
        }

        $this->fail('expected a FilterException due to invalid javascript');
    }

    /**
     * @expectedException \Assetic\Exception\FilterException
     */
    public function testFilterLoadInvalidWithStringAsset()
    {
        $file = __DIR__ . '/../../js/invalid.js';
        $asset = new StringAsset(file_get_contents($file));
        $asset->load();

        try {
            $this->filter->filterLoad($asset);
        } catch(FilterException $e) {
            printf($e->getMessage());

            throw $e;
        }

        $this->fail('expected a FilterException due to invalid javascript');
    }
}
 