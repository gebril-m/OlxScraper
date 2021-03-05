<?php

namespace App\Repositories;

use App\User;


/**
 * Class AdsRepository
 * @package App\Repositories
 * @version June 10, 2020, 12:55 pm UTC
*/

class UserRepository 
{
    
    function save($data) {

        $user = User::create($data);
        return $user;
    }

    function findAll() {
        $users = User::orderBy('id', 'desc')->get();
        return $users;
    }

    function findById($id) {
        $user=User::find($id);
        return $user;
    }
    
    function findByPhone($phone) {
        $user=User::where('phone',$phone)->first();
        return $user;
    }

    function findByEmail($email) {
        $user=User::where('email',$email)->first();
        return $user;
    }

    function update($id, $data) {
        $user=User::where('id',$id)->update($data);
        return $user;
    }

    function delete($id) {
        User::destroy($id);
        return true;
    }
    
    
}
