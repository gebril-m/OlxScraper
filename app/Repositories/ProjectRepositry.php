<?php

namespace App\Repositories;

use App\Models\Project;


/**
 * Class AdsRepository
 * @package App\Repositories
 * @version June 10, 2020, 12:55 pm UTC
*/

class ProjectRepositry 
{
    

    public function model()
    {
        return Project::class;
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
        if (isset($input['image'])) {
            $input['image']=image_upload($input['image'],'projects');
        }
        $project=Project::create($input);
        session()->flash('success','Project Created Successfully');
        return $project;
    }

    
    public function update($input, $id)
    {
       $project=Project::find($id);
       if (isset($input['image'])) {
            //Remove Old Image
            if (file_exists(public_path('upload/projects/'.$project->image))) {
                unlink(public_path('upload/projects/'.$project->image));
            }
            //Upload Image
            $input['image']=image_upload($input['image'],'projects');
        }
       $project->update($input);
       session()->flash('success','Project Updated Successfully');
        return $project;
    }

    public function find($id)
    {
       $project=Project::find($id);
       return $project;
    }

    /**
     * List all ads for the api
     * 
     */
    public function all(){
        $projects=Project::all();
        return $projects;
    }

    public function delete($id)
    {
        $project=Project::find($id);
        //Remove Old Image
        if (file_exists(public_path('upload/projects/'.$project->image))) {
            unlink(public_path('upload/projects/'.$project->image));
        }
        session()->flash('success','Project Deleted Successfully');
        $project->delete();
    }
}
