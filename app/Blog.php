<?php

namespace App;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    //
    protected $fillable = [
        'title',
        'content',
        'slug',
        'category_id'
    ];
    public function category() {
        return $this->belongsTo('App\Category');
    }
    public static function getUniqueSlugFromTitle($title) {
        
        $slug = Str::slug($title);
        $slug_base = $slug;
        
        $blog_found = Blog::where('slug', '=', $slug)->first();
        $counter = 1;
        while($blog_found) {
            
            $slug = $slug_base . '-' . $counter;
            $blog_found = Blog::where('slug', '=', $slug)->first();
            $counter++;
        }

        return $slug;
    }
}
