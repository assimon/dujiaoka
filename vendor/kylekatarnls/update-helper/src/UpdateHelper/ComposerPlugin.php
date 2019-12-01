<?php

namespace UpdateHelper;

use Composer\Composer;
use Composer\EventDispatcher\Event;
use Composer\EventDispatcher\EventSubscriberInterface;
use Composer\IO\IOInterface;
use Composer\Plugin\PluginInterface;

class ComposerPlugin implements PluginInterface, EventSubscriberInterface
{
    protected $io;

    public function activate(Composer $composer, IOInterface $io)
    {
        $this->io = $io;
    }

    public static function getSubscribedEvents()
    {
        return array(
            'post-autoload-dump' => array(
                array('onAutoloadDump', 0),
            ),
        );
    }

    public function onAutoloadDump(Event $event)
    {
        if (!class_exists('UpdateHelper\\UpdateHelper')) {
            return;
        }

        UpdateHelper::check($event);
    }
}
