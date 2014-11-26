<?php

namespace spec\DeSmart\CacheProtract;

use Prophecy\Argument;
use PhpSpec\ObjectBehavior;
use Illuminate\Filesystem\Filesystem;

class FileStoreSpec extends ObjectBehavior
{

    private $cacheDir = 'cache';

    private $cacheKey = 'foo';

    function let(Filesystem $filesystem)
    {
        $this->beConstructedWith($filesystem, $this->cacheDir);
        $filesystem->exists(Argument::any())->willReturn(true);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('DeSmart\CacheProtract\FileStore');
    }

    function it_returns_null_when_files_does_not_exist(Filesystem $filesystem)
    {
        $filesystem->exists(Argument::any())->shouldBeCalled()->willReturn(false);
        $this->get($this->cacheKey)->shouldReturn(null);
    }

    function it_return_null_when_cant_read_file(Filesystem $filesystem)
    {
        $filesystem->get(Argument::any())->shouldBeCalled()->willThrow('\Exception');
        $this->get($this->cacheKey)->shouldReturn(null);
    }

    function it_prolongs_expired_cache(Filesystem $filesystem)
    {
        $serialized = serialize($value = new \stdClass);
        $contents = sprintf('%s%s', time() - 3600, $serialized);
        $filesystem->get(Argument::any())->willReturn($contents);

        $put_contents = (time() + 60).$serialized;
        $filesystem->put(Argument::any(), $put_contents)->shouldBeCalled();

        $this->setProlongTime(1);
        $this->get($this->cacheKey)->shouldReturn(null);
    }

    function it_returns_cached_value(Filesystem $filesystem)
    {
        $serialized = serialize($value = 'value');
        $contents = (time() + 3600).$serialized;
        $filesystem->get(Argument::any())->willReturn($contents);

        $this->get($this->cacheKey)->shouldReturn($value);
    }
}
