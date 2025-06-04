<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

public function view(?User $user, Post $post)
{
    // \Log::info('PostPolicy@view called', [
    //     'user_id' => optional($user)->id,
    //     'post_owner_id' => $post->user_id,
    //     'is_archived' => $post->is_archived,
    //     'is_owner' => ((int) optional($user)->id === (int) $post->user_id),
    // ]);

    if (is_null($user)) {
        return !$post->is_archived;
    }

    if ((int) $user->id === (int) $post->user_id) {
        return true;
    }

    return !$post->is_archived;
}





    public function create(User $user)
    {
        return true;
    }

    public function update(User $user, Post $post)
    {
        return (int) $user->id === (int) $post->user_id;
    }

    public function delete(User $user, Post $post)
    {
        return (int) $user->id === (int) $post->user_id;
    }

    public function archive(User $user, Post $post)
    {
        return (int) $user->id === (int) $post->user_id;
    }

    public function save(User $user)
    {
        return true;
    }
}
