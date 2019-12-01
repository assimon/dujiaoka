<?php

/*
 * This file is part of the overtrue/laravel-ueditor.
 *
 * (c) yueziii <i@yueziii.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Overtrue\LaravelUEditor\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class Catched.
 *
 * @author yueziii <i@yueziii.com>
 */
class Catched 
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * @var array
     */
    public $result;

    /**
     * Catched constructor.
     *
     * @param array  $result
     */
    public function __construct(array $result)
    {
        $this->result = $result;
    }
}
