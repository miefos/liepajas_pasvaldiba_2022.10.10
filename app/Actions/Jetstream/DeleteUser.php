<?php

namespace App\Actions\Jetstream;

use Laravel\Jetstream\Contracts\DeletesUsers;
use Symfony\Component\HttpFoundation\Response;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param  mixed  $user
     * @return void
     */
    public function delete($user)
    {
        if ($errMsg = $user->userIsNotDeletable()) {
            die($errMsg);
        }

        $user->deleteProfilePhoto();
        $user->tokens->each->delete();
        $user->delete();
    }
}
