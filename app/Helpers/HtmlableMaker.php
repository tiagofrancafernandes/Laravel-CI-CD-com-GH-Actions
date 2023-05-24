<?php

namespace App\Helpers;

use Illuminate\Contracts\Support\Htmlable;

class HtmlableMaker implements Htmlable
{
    public function __construct(
        protected string $content,
        protected bool $isBlade = false,
    ) {
        //
    }

    /**
     * Get content as a string of HTML.
     *
     * @return string
     */
    public function toHtml(): string
    {
        if ($this->isBlade) {
            return \Illuminate\Support\Facades\Blade::render($this->content);
        }

        return $this->content;
    }

    /**
     * function make
     *
     * @param string $content
     * @return Htmlable
     */
    public static function make(string $content): Htmlable
    {
        return new static($content);
    }

    /**
     * function blade
     *
     * @param string $content
     * @return Htmlable
     */
    public static function blade(string $content): Htmlable
    {
        return new static($content, true);
    }

    public function __toString()
    {
        return $this->toHtml();
    }
}
