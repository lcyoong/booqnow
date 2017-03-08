<?php
namespace App\Traits;

use App\Comment;

trait CommentRelationship
{
  public function comments()
  {
    // return $this->hasMany(Comment::class, 'com_model_id')->where('com_model', '=', get_class($this))->orderBy('com_id', 'desc');
    return $this->morphMany('App\Comment', 'com_model')->orderBy('com_id', 'desc');
  }

  // public function saveComment($input)
  // {
  //   // $input['com_model'] = get_class($this);
  //
  //   $comment = new Comment($input);
  //
  //   $this->comments()->save($comment);
  // }

}
