<?php

namespace Conner\Tagging\Model;

use Conner\Tagging\TaggingUtility;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

/**
 * @mixin Model
 * @mixin Builder
 *
 * @property string id
 * @property string slug
 * @property string name
 * @property-read Collection|Tag[] tags
 */
class TagGroup extends Model
{
    protected $table = 'tagging_tag_groups';

    public $timestamps = false;

    protected $fillable = ['name'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->connection = config('tagging.connection');
    }

    /**
     * Get suggested tags
     */
    public function tags()
    {
        $model = TaggingUtility::tagModelString();

        return $this->hasMany($model, 'tag_group_id');
    }

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = TaggingUtility::normalize($value);
    }
}
