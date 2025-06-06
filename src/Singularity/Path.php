<?php

/**
 * @package Singularity
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace DecodeLabs\Singularity;

use DecodeLabs\Collections\ImmutableSequence;
use DecodeLabs\Nuance\Dumpable;
use DecodeLabs\Nuance\Entity\NativeObject as NuanceEntity;

/**
 * @extends ImmutableSequence<string>
 */
class Path extends ImmutableSequence implements Dumpable
{
    protected(set) string $separator = '/';
    protected(set) bool $leadingSlash = false;
    protected(set) bool $trailingSlash = false;

    public string $dirName {
        get => $this->getDirName();
    }

    public ?string $baseName {
        get => $this->getBaseName();
    }

    public ?string $fileName {
        get => $this->getFileName();
    }

    public ?string $fileRoot {
        get => $this->getFileRoot();
    }

    public ?string $extension {
        get => $this->getExtension();
    }


    /**
     * Create Path from parsed string
     */
    public static function fromString(
        string $path,
        ?string $separator = null
    ): static {
        if (str_starts_with($path, 'file://')) {
            $path = substr($path, 7);
        }

        if ($separator === null) {
            $hasForward = strpos($path, '/') !== false;
            $hasBackward = strpos($path, '\\') !== false;

            if (
                $hasBackward &&
                !$hasForward
            ) {
                $separator = '\\';
            } else {
                $separator = '/';
            }
        }

        if (str_starts_with($path, $separator)) {
            $leadingSlash = true;
            $path = substr($path, 1);
        } else {
            $leadingSlash = false;
        }

        if (str_ends_with($path, $separator)) {
            $trailingSlash = true;
            $path = substr($path, 0, -1);
        } else {
            $trailingSlash = false;
        }

        /** @var non-empty-string $separator */
        $items = explode($separator, $path);

        return new static(
            items: $items,
            leadingSlash: $leadingSlash,
            trailingSlash: $trailingSlash,
            separator: $separator
        );
    }

    /**
     * Init with items, slashes and separator
     *
     * @param iterable<string> $items
     */
    final public function __construct(
        iterable $items = [],
        bool $leadingSlash = false,
        bool $trailingSlash = false,
        ?string $separator = null
    ) {
        $this->leadingSlash = $leadingSlash;
        $this->trailingSlash = $trailingSlash;

        if ($separator !== null) {
            $this->separator = $separator;
        }

        parent::__construct($items);
    }


    /**
     * @return array<string>
     */
    public function __serialize(): array
    {
        return [
            $this->__toString()
        ];
    }

    /**
     * @param array<string> $data
     */
    public function __unserialize(
        array $data
    ): void {
        $path = static::fromString($data[0]);
        $this->items = $path->items;
        $this->leadingSlash = $path->leadingSlash;
        $this->trailingSlash = $path->trailingSlash;
        $this->separator = $path->separator;
    }


    /**
     * Should path include a leading slash?
     */
    public function withLeadingSlash(
        bool $slash
    ): static {
        $output = clone $this;
        $output->leadingSlash = $slash;
        return $output;
    }

    /**
     * Will path include a leading slash?
     */
    public function hasLeadingSlash(): bool
    {
        return $this->leadingSlash;
    }


    /**
     * Should path include a trailing slash?
     */
    public function withTrailingSlash(
        bool $slash
    ): static {
        $output = clone $this;
        $output->trailingSlash = $slash;
        return $output;
    }

    /**
     * Will path include a trailing slash?
     */
    public function hasTrailingSlash(): bool
    {
        return $this->trailingSlash;
    }



    /**
     * Set path separator
     */
    public function withSeparator(
        string $separator
    ): static {
        $output = clone $this;
        $output->separator = $separator;
        return $output;
    }

    /**
     * Get path separator
     */
    public function getSeparator(): string
    {
        return $this->separator;
    }


    /**
     * Canonicalize path
     */
    public function canonicalize(): static
    {
        if (
            !in_array('.', $this->items) &&
            !in_array('..', $this->items) &&
            !in_array('', $this->items)
        ) {
            return $this;
        }

        $output = clone $this;
        $output->items = [];

        foreach ($this->items as $item) {
            if (
                $item === '..' &&
                !$output->isEmpty() &&
                $output->getLast() !== '..'
            ) {
                array_pop($output->items);
                continue;
            }

            if (
                $item !== '.' &&
                $item !== ''
            ) {
                $output->items[] = $item;
            }
        }

        return $output;
    }



    /**
     * Get dirname
     */
    public function getDirName(): string
    {
        return dirname($this->__toString() . 'a') . '/';
    }


    /**
     * Set base name
     */
    public function withBaseName(
        string $baseName
    ): static {
        return $this->set(-1, $baseName);
    }

    /**
     * Get base name
     */
    public function getBaseName(): ?string
    {
        return $this->getLast();
    }


    /**
     * Set file name (including extension)
     */
    public function withFileName(
        ?string $name
    ): static {
        if ($name === null) {
            if ($this->trailingSlash) {
                return $this;
            }

            $output = clone $this;
            $output->trailingSlash = true;
            array_pop($output->items);
            return $output;
        }

        if ($this->trailingSlash) {
            $output = clone $this;
            $output->items[] = $name;
            $output->trailingSlash = false;
            return $output;
        }

        return $this->set(-1, $name);
    }

    /**
     * Get file name (including extension)
     */
    public function getFileName(): ?string
    {
        if ($this->trailingSlash) {
            return null;
        }

        return $this->getBaseName();
    }


    /**
     * Set file name (not including extension)
     */
    public function withFileRoot(
        ?string $root
    ): static {
        if ($this->trailingSlash) {
            if ($root === null) {
                return $this;
            }

            $output = clone $this;
            $output->items[] = $root;
            $output->trailingSlash = false;
            return $output;
        }

        if (
            strlen((string)($extension = $this->getExtension())) ||
            substr((string)$this->getLast(), -1) == '.'
        ) {
            $root .= '.' . $extension;
        }

        return $this->withFileName($root);
    }

    /**
     * Get file root (name not including extension)
     */
    public function getFileRoot(): ?string
    {
        if ($this->trailingSlash) {
            return null;
        }

        $baseName = (string)$this->getBaseName();

        if (false === ($pos = strrpos($baseName, '.'))) {
            return $baseName;
        }

        return substr($baseName, 0, $pos);
    }



    /**
     * Set file extension
     */
    public function withExtension(
        ?string $extension
    ): static {
        $fileName = (string)$this->getFileRoot();

        if ($extension !== null) {
            $fileName .= '.' . ltrim($extension, '.');
        }

        if ($fileName === '') {
            return $this;
        }


        if ($this->trailingSlash) {
            $output = clone $this;
            $output->items[] = $fileName;
            $output->trailingSlash = false;
            return $output;
        }

        return $this->withFileName($fileName);
    }

    /**
     * Get file extension
     */
    public function getExtension(): ?string
    {
        if ($this->trailingSlash) {
            return null;
        }

        $baseName = (string)$this->getBaseName();

        if (false === ($pos = strrpos($baseName, '.'))) {
            return null;
        }

        $length = strlen($baseName);

        if ($pos === $length) {
            return null;
        }

        return substr($baseName, $pos + 1);
    }

    /**
     * Does path have file extension / match given extensions?
     */
    public function hasExtension(
        string ...$extensions
    ): bool {
        if ($this->trailingSlash) {
            return false;
        }

        if (($baseName = (string)$this->getBaseName()) === '..') {
            return false;
        }

        if (empty($extensions)) {
            return false !== strrpos($baseName, '.');
        }

        if (is_string($extension = $this->getExtension())) {
            $extension = strtolower($extension);
        }

        array_walk($extensions, 'strtolower');
        return in_array($extension, $extensions, true);
    }



    /**
     * Convert path to string
     */
    public function __toString(): string
    {
        $output = '';

        if ($this->leadingSlash) {
            $output .= $this->separator;
        }

        $output .= implode($this->separator, $this->items);

        if (
            (
                $this->trailingSlash &&
                $output !== $this->separator
            ) ||
            $output === ''
        ) {
            $output .= $this->separator;
        }

        return $output;
    }


    public function toNuanceEntity(): NuanceEntity
    {
        $entity = new NuanceEntity($this);
        $entity->definition = $this->__toString();

        $entity->meta = [
            'items' => $this->items,
            'leadingSlash' => $this->leadingSlash,
            'trailingSlash' => $this->trailingSlash,
            'separator' => $this->separator
        ];

        return $entity;
    }
}
