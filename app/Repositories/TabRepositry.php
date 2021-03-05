<?php

namespace App\Repositories;

use App\Models\Tab;


/**
 * Class AdsRepository
 * @package App\Repositories
 * @version June 10, 2020, 12:55 pm UTC
*/

class TabRepository 
{
    

    public function model()
    {
        return Tab::class;
    }

    /**
     * Create model record
     *
     * @param array $input
     *
     * @return Ad
     */
    public function create($input)
    {
        $tab=Tab::create($input);
        return $tab;
    }

    
    public function update($input, $id)
    {
       $tab=Tab::find($id);
       $tab->update($input);
       return $tab;
    }

    /**
     * List all ads for the api
     * 
     */
    public function list(){
        
    }
}
