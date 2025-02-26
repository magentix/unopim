<?php

namespace Magentix\Cms\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Magentix\Cms\Contracts\Page as PageContract;
use Webkul\HistoryControl\Contracts\HistoryAuditable as HistoryContract;
use Webkul\HistoryControl\Traits\HistoryTrait;
use Webkul\User\Models\Admin;

class Page extends Model implements HistoryContract, PageContract
{
    use HistoryTrait;

    protected array $auditExclude = ['id'];

    protected array $historyTags = ['page'];

    protected $table = 'cms_pages';

    protected $fillable = [
        'title',
        'content',
        'code',
        'slug',
        'group',
        'status',
        'locale',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'user_id');
    }

    protected function slug(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^a-z0-9-\/]+/', '-', strtolower($value)),
        );
    }

    protected function code(): Attribute
    {
        return Attribute::make(
            set: fn (string $value) => preg_replace('/[^a-z0-9_]+/', '_', strtolower($value)),
        );
    }
}
