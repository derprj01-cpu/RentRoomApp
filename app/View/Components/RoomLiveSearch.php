<?php

namespace App\View\Components;

use Illuminate\View\Component;

class RoomLiveSearch extends Component
{
    public $placeholder;
    public $value;
    public $searchUrl;
    public $resultsUrl;
    public $minChars;

    public function __construct(
        $placeholder = 'Search rooms...',
        $value = '',
        $searchUrl = null,
        $resultsUrl = null,
        $minChars = 2
    ) {
        $this->placeholder = $placeholder;
        $this->value = $value;
        $this->searchUrl = $searchUrl ?? route('admin.rooms.search');
        $this->resultsUrl = $resultsUrl ?? route('admin.rooms.index');
        $this->minChars = $minChars;
    }

    public function render()
    {
        return view('components.room-live-search');
    }
}
