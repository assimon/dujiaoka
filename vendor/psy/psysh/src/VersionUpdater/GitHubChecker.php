<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VersionUpdater;

use Psy\Shell;

class GitHubChecker implements Checker
{
    const URL = 'https://api.github.com/repos/bobthecow/psysh/releases/latest';

    private $latest;

    /**
     * @return bool
     */
    public function isLatest()
    {
        return \version_compare(Shell::VERSION, $this->getLatest(), '>=');
    }

    /**
     * @return string
     */
    public function getLatest()
    {
        if (!isset($this->latest)) {
            $this->setLatest($this->getVersionFromTag());
        }

        return $this->latest;
    }

    /**
     * @param string $version
     */
    public function setLatest($version)
    {
        $this->latest = $version;
    }

    /**
     * @return string|null
     */
    private function getVersionFromTag()
    {
        $contents = $this->fetchLatestRelease();
        if (!$contents || !isset($contents->tag_name)) {
            throw new \InvalidArgumentException('Unable to check for updates');
        }
        $this->setLatest($contents->tag_name);

        return $this->getLatest();
    }

    /**
     * Set to public to make testing easier.
     *
     * @return mixed
     */
    public function fetchLatestRelease()
    {
        $context = \stream_context_create([
            'http' => [
                'user_agent' => 'PsySH/' . Shell::VERSION,
                'timeout'    => 3,
            ],
        ]);

        \set_error_handler(function () {
            // Just ignore all errors with this. The checker will throw an exception
            // if it doesn't work :)
        });

        $result = @\file_get_contents(self::URL, false, $context);

        \restore_error_handler();

        return \json_decode($result);
    }
}
