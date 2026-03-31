<?php

namespace Questions\View\Components;

use Illuminate\View\Component;

class TagList extends Component
{
    public array $tags;

    public function __construct(array $tags = [])
    {
        $this->tags = $tags;
    }

    public function render()
    {
        return view('questions::components.tag-list');
    }
}