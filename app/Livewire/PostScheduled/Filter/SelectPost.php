<?php

namespace App\Livewire\PostScheduled\Filter;

use App\Models\PostScheduled;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class SelectPost extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        $auto_posts = PostScheduled::with("post")->get();

        $auto_posts = collect($auto_posts)->mapWithKeys(function ($item) {
            return [$item->id => $item->post->title];
        });
        $auto_posts->prepend("All");

        return $form
            ->schema([
                \Filament\Forms\Components\Select::make('sort_by')
                    ->options($auto_posts)
                    ->default('')
                    ->reactive()
                    ->afterStateUpdated(function(){
                        $this->emit('update-events', "11");
                    }),
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.post_scheduled.filter.select-post');
    }
}
