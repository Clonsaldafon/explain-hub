<?php

namespace Questions\View\Components;

use Illuminate\View\Component;

class Question extends Component
{
    public string $title;
    public string $content;
    public string $status;
    public int $views;
    public int $likes;
    public array $tags;

    public function __construct(
        string $title,
        string $content,
        string $status,
        int $views = 0,
        int $likes = 0,
        array $tags = []
    )
    {
        $this->title = $title;
        $this->content = $content;
        $this->status = $status;
        $this->views = $views;
        $this->likes = $likes;
        $this->tags = $tags;
    }

    public function render()
    {
        return view('questions::components.question');
    }
}