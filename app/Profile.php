<?php

namespace App;
use App\User;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
   protected $guarded = [];
   public function user()
   {
    return $this->belongsTo(User::class);
   }
   public function profileImage()
   {
        $imagePath =  ($this->image) ? $this->image : 'profile/N3YznR75gOnhrQxhD8fMdO9OZNy5oHMUtnQn0nT7.jpg';
        return '/storage/'. $imagePath;
   }
   public function followers() {
       return $this->belongsToMany(User::class);
   }
}
