<?php

namespace Rupam\BanglaSlug\Traits;

use Rupam\BanglaSlug\Facades\BanglaSlug;

trait HasBanglaSlug
{
    /**
     * Boot the trait to generate the slug automatically.
     */
    protected static function bootHasBanglaSlug()
    {
        static::saving(function ($model) {
            $slugField = $model->getSlugField();
            $sourceField = $model->getSlugSourceField();

            if (empty($model->{$slugField}) && !empty($model->{$sourceField})) {
                $baseSlug = BanglaSlug::make($model->{$sourceField});
                $slug = $baseSlug;
                $count = 1;

                // Ensure unique slug
                while (static::where($slugField, $slug)->where($model->getKeyName(), '!=', $model->getKey())->exists()) {
                    $slug = $baseSlug . config('bangla-slug.separator', '-') . $count++;
                }

                $model->{$slugField} = $slug;
            }
        });
    }

    /**
     * Get the name of the column that should be used for the slug.
     * Override this method in your model if your slug field is not 'slug'.
     *
     * @return string
     */
    public function getSlugField(): string
    {
        return 'slug';
    }

    /**
     * Get the name of the column that is the source of the slug.
     * Override this method in your model if your source field is not 'title'.
     *
     * @return string
     */
    public function getSlugSourceField(): string
    {
        return 'title';
    }
}
