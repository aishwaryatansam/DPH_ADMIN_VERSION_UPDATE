<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'division_head_name_one',
        'division_head_name_two',
        'division_head_name_three',
        'division_head_image_one',
        'division_head_image_two',
        'division_head_image_three',
        'division_head_status_one',
        'division_head_status_two',
        'division_head_status_three',
        'designation_id_one',
        'designation_id_two',
        'designation_id_three',
        'parent_division_id',
        'division_icon',
        'order_no',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
        'updated_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Scope a query to filter records based on a keyword.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFilter($query)
    {
        if ($keyword = request('keyword')) {
            $query->where('name', 'like', '%' . $keyword . '%')
            ->orWhere('division_head_name_one', 'like', '%' . $keyword . '%')
            ->orWhere('division_head_name_two', 'like', '%' . $keyword . '%')
            ->orWhere('division_head_name_three', 'like', '%' . $keyword . '%');
        }
        return $query;
    }

    /**
     * Get queried result with sorting and pagination.
     *
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator
     */
    public static function getQueriedResult()
    {
        $page_length = getPagelength();
        list($sortfield, $sorttype) = getSorting();

        $result = static::with('parent_division')->filter();

        $sortfield = ($sortfield == 'name') ? 'name' : $sortfield;

        return $result->orderBy($sortfield, $sorttype)->paginate($page_length);
    }

    /**
     * Define a relationship with the parent division.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent_division()
    {
        return $this->belongsTo(Division::class, 'parent_division_id')->select('id', 'name');
    }

    /**
     * Get division data based on status and optional parent division ID.
     *
     * @param  int|null  $parent_division_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getDivisionData($parent_division_id = null)
    {
        $divisions = static::where(['status' => _active()]);

        if ($parent_division_id) {
            $divisions = $divisions->where('parent_division_id', $parent_division_id);
        } else {
            $divisions = $divisions->where('parent_division_id', _inactive());
        }

        return $divisions->orderBy('name', 'asc')->get();
    }
}
