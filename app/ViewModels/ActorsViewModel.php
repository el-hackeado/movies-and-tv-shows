<?php

namespace App\ViewModels;

use Carbon\Carbon;
use Spatie\ViewModels\ViewModel;

class ActorsViewModel extends ViewModel
{
    public $popactors;
    public $page;
    public function __construct($popactors, $page)
    {
        $this->popactors=$popactors;
        $this->page=$page;
    }
    public function popactors(){
        return collect($this->popactors)->map(function($actor){

            return collect($actor)->merge([
                'profile_path'=> ($actor['profile_path'])
            ?"https://image.tmdb.org/t/p/w235_and_h235_face/".$actor['profile_path']
                : 'https://ui-avatars.com/api/?size=235&name='.$actor['name'],
                'known_for'=> collect($actor['known_for'])->where('media_type', 'movie')->pluck('title')
                    ->union(collect($actor['known_for'])->where('media_type', 'tv')->pluck('name'))
                    ->implode(', ')
            ])->only([
                'name', 'id', 'profile_path', 'known_for'
            ]);
        });
    }
    public function previous(){
        return $this->page > 1 ? $this->page - 1 : null;
    }
    public function next(){
        return $this->page < 500 ? $this->page + 1 : null;
    }
}
