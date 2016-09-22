<?php

namespace Sharenjoy\Cmsharenjoy\Core\Scopes;

use Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ScopeInterface;

class ContentLanguageScope implements ScopeInterface {
    
    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (Request::segment(1) == config('cmsharenjoy.access_url')) {
            if (session()->has('cmsharenjoy.language')) {
                $builder->whereLanguage(session('cmsharenjoy.language'));
            }
        } else {
            if (session()->has('content-language')) {
                $builder->whereLanguage(session('content-language'));
            }
        }
    }

    /**
     * Remove the scope from the given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function remove(Builder $builder, Model $model)
    {
        //
    }

}