<?php

namespace App\Models;

use App\Http\Services\ImageService;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Http\Services\ValidationService;

class Blog extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,ValidationService,ImageService;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = ['id','article_in_en','article_in_fr'];
    protected $root = 'storage/blog';

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [];

    public function upsertInstance($request)
    {
        $blog = self::updateOrCreate(
            ['id' => $request->id],
            $request->all()
        );

        $blog->dimintions(['small' => '261x164','medium' => '500x500','large' => '1200x720'])
            ->fit()
            ->files($request->thumbnail)
            ->withSaveRelation('gallaries')
            ->usefor('thumbnail')
            ->compile();

        return self::result($blog,'success');
    }

    public function deleteInstance()
    {
        $this->delete();
        return $this->result('success',$this);
    }

    public function scopeFilter($query,$request)
    {
        return $query;
    }

    //Accessators


    public function getThumbnailAttribute()
    {
        return $this->gallaries()->where('use_for','thumbnail')->first();
    }

    // Relations

    public function gallaries()
    {
        return $this->morphMany(Gallary::class,'imageable');
    }

}
