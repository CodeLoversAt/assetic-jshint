<?php
/**
 * @package assetic-jshint
 *
 * @author Daniel Holzmann <d@velopment.at>
 * @date 08.03.14
 * @time 16:09
 */

namespace CodeLovers\Assetic\Filter;


use Assetic\Asset\AssetInterface;
use Assetic\Exception\FilterException;
use Assetic\Filter\BaseNodeFilter;

class JsHintFilter extends BaseNodeFilter
{
    /**
     * path to jshint binary
     */
    private $jsHintBinary;

    public function __construct($jsHintBinary = '/usr/bin/jshint')
    {
        $this->jsHintBinary = $jsHintBinary;
    }

    /**
     * Filters an asset after it has been loaded.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterLoad(AssetInterface $asset)
    {
        if ('' != ($sourceRoot = $asset->getSourceRoot()) && '' != ($sourcePath = $asset->getSourcePath())) {
            $input = $sourceRoot . '/' . $sourcePath;
            $remove = false;
        } else {
            $input = tempnam(sys_get_temp_dir(), 'assetic_jshint');
            file_put_contents($input, $asset->getContent());
            $remove = true;
        }

        $pb = $this->createProcessBuilder(array($this->jsHintBinary));
        $pb->add($input);
        $proc = $pb->getProcess();
        $code = $proc->run();

        if (true === $remove) {
            unlink($input);
        }

        if (0 !== $code) {
            throw FilterException::fromProcess($proc)->setInput($asset->getContent());
        }
    }

    /**
     * Filters an asset just before it's dumped.
     *
     * @param AssetInterface $asset An asset
     */
    public function filterDump(AssetInterface $asset)
    {
        // nothing to do
        // we run on load and throw execptions on errors
    }
}