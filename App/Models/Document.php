<?php

namespace App\Models;

use App\Models\Navigation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Tag;

class Document extends Model
{
    use SoftDeletes;

    /**
     * @var array
     */
    protected $fillable = ['document_url', 'navigation_id', 'display_filename', 'tag_id', 'uploaded_by', 'status', 'visible_to_public', 'reference_no', 'dated', 'image_url', 'link_url', 'link_title'];


    /**
     * @param $query
     * @return mixed
     */
    public function scopeFilter($query)
    {

        if ($keyword = request('keyword')) {
            $query->where('display_filename', 'like', '%' . $keyword . '%');
            $query->orWhere('reference_no', 'like', '%' . $keyword . '%');
        }

        if ($navigation = request('navigation')) {
            $query->where('navigation_id', $navigation);
        }

        if ($section = request('section')) {
            $query->where('tag_id', $section);
        }

        if ($from = request('from')) {
            $query->whereDate('dated','>=', dateOf($from,'Y-m-d'));
        }

        if ($to = request('to')) {
            $query->whereDate('dated','<=', dateOf($to,'Y-m-d'));
        }
        if ($visible_to_public = request('visible_to_public')) {
            $query->when($visible_to_public == 'yes',function($sub){
                $sub->where('visible_to_public', _active());
            });
            $query->when($visible_to_public == 'no',function($sub){
                $sub->where('visible_to_public', _inactive());
            });
        }
        if ($status = request('status')) {
            $query->when($status == 'Active',function($sub){
                $sub->where('status', _active());
            });
            $query->when($status == 'InActive',function($sub){
                $sub->where('status', _inactive());
            });
        }
        if (isHud()){
             $query->where('status', _active())->where('visible_to_public', _active());
        }
        return $query;
    }

    /**
     * @param $id
     */
    public function getDocument($id) {

        $result = $this->with('navigation', 'employee','tag')->find($id);
        return $result;
    }

    /**
     * @return mixed
     */
    public static function getQueriedResult()
    {

        $page_length = getPagelength();

        list($sortfield, $sorttype) = getSorting();

        $result = static::with(['navigation','employee','tag'])->filter()->when(Auth::user()->user_type_id == _employeeUserTypeId(), function ($query) {
            $query->where('uploaded_by', Auth::user()->id);
        });

        $sortfield = ($sortfield == 'display_filename') ? 'name' : $sortfield;

        return $result->orderBy($sortfield, $sorttype)->get();
    }

    public static function getNavigationDocument($navigationId = '')
    {
        return static::with('navigation')->where('status',_active())
                        ->where('visible_to_public',_active())
                        ->when(request('section_id'),function($query){
                            $query->where('tag_id', request('section_id'));
                        })
                        ->when($navigationId ,function($query) use($navigationId){
                            $query->where('navigation_id',$navigationId);
                        })
                        ->get();
    }
    /**
     * @return mixed
     */
    public function navigation()
    {
        return $this->belongsTo(Navigation::class);
    }

    public function employee() {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function tag(){
        return $this->belongsTo(Tag::class);
    }
}
