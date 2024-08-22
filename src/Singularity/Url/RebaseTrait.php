<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity\Url;

use DecodeLabs\Singularity;
use DecodeLabs\Singularity\Url;

/**
 * @phpstan-require-implements Rebasable
 */
trait RebaseTrait
{
    public function rebase(
        Url $base
    ): static {
        $output = $this;

        if (!$output->hasHost()) {
            try {
                $output = $output->withHost($base->getHost());

                if (!$output->hasPort()) {
                    $output = $output->withPort($base->getPort());
                }

                if (!$output->hasUserInfo()) {
                    $output = $output->withUserInfo($base->getUserInfo());
                }
            } catch (LogicException $e) {
            }
        }

        if (!$output->hasScheme()) {
            try {
                $output = $output->withScheme($base->getScheme());
            } catch (LogicException $e) {
            }
        }

        $path = $output->getPath();

        if (preg_match('~/\.\.?(/|$)~', $path)) {
            try {
                $dirname = (string)$base->parsePath()?->getDirname();

                $path = Singularity::canonicalPath(
                    $dirname . ltrim($path, '/')
                );

                $output = $output->withPath($path);
            } catch (LogicException $e) {
            }
        }

        return $output;
    }
}
