<?php

namespace Click\Framework\View\Model;

class Base
{
    public function getHeading(): string
    {
        return "A Heading";
    }

    public function getContent(): string
    {
        return "Some testing content to output onto the page.";
    }

    public function getTime(): string
    {
        return (string) new \DateTime();
    }
}