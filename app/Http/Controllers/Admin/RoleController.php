<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $roles=Role::all();
        return view('admin.roles.index',compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions=Permission::all();
        return view('admin.roles.create',compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules=['name'=>'required|unique:roles,name'];
        $request->validate($rules);

        $role=Role::create(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        session()->flash('success','Role Created Successfully');
        return redirect(url('/roles'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role=Role::findOrFail($id);
        $permissions=Permission::all();
        return view('admin.roles.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules=['name'=>'required|unique:roles,name,'.$id];
        $request->validate($rules);

        $role=Role::find($id);
        $role->update(['name' => $request->name]);
        $role->syncPermissions($request->permissions);
        session()->flash('success','Role Updated Successfully');
        return redirect(url('/roles'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }









/*

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Goutte\Client;
use App\Http\Controllers\Controller;
use App\Models\Advertising;
use App\Models\Pagelink;

class ScrapController extends Controller
{
    public function index()
    {
        $advertisings=Advertising::all();
        return view('admin.scrap.index',compact('advertisings'));
    }

    //Show
    public function show($id)
    {
        $advertising=Advertising::findOrFail($id);
        $images=json_decode($advertising->images);
        return view('admin.scrap.show',compact('advertising','images'));
    }

    //Page Of Scarping
    public function olx_scraping_page()
    {
        $advertisings=Advertising::where('website_name','olx')->get();
        return view('admin.scrap.olx',compact('advertisings'));
    }

    //To Scrap data from olx url 
    public function get_data_olx(Request $request)
    {
        $client=new Client;
        $page=$client->request('GET',$request->url);        

        $GLOBALS['link']=19;
        if($page->filter('.ads__item > .ads__item__info > a')->count()>0){

            $data=$page->filter('.ads__item > .ads__item__info > a')->each(function($item){

                    $adversingdata=$this->get_data_olx_one($item->attr('href'));
                    if ($adversingdata != null) {
                        if ($adversingdata['title']==null) {
                            $adversingdata['title']=$item->text();
                        }
                       $adversingdata['link']= $item->attr('href');
                        // $adversingdata['pagelink_id']= 1;
                        $adversingdata['images']= json_encode($adversingdata['images']);

                        if ($adversing=Advertising::where('phone',$adversingdata['phone'])->first()) {
                        }else{
                            Advertising::create($adversingdata);
                        }
                    }
                    
            });

        }
        session()->flash('success','data retreived successfully');
        return back();
        
    }

    //To Scrap data from olx url of one Ads
    public function get_data_olx_one($url)
    {
        $client=new Client;
        $page=$client->request('GET',$url);
        if ($page->filter('.lheight24')->text('nodata')=='لم نتمكن من العثور على شيء') {
            return null;
        }
        $id = get_string_between($url,'ID','.html');
        
        $phone=get_olx_phone_number($id);

        $data=[];
        $GLOBALS['data']['phone'] = $phone;
        $GLOBALS['data']['link'] = $url;

        //Title
        $GLOBALS['data']['title']=$page->filter('.offerheadinner > h1')->first()->text('nodata');
        if (!mb_check_encoding($GLOBALS['data']['title'])) {
            $GLOBALS['data']['title']=null;
        }
        

        //$GLOBALS['data']['title'] = \DB::connection()->getPdo()->quote(utf8_encode($GLOBALS['data']['title']));
        //dd($GLOBALS['data']['title']);
        //Price
        $GLOBALS['data']['price']=$page->filter('.offerbox > div > div > div > strong')->text('nodata');

        //Address
        $GLOBALS['data']['address']=$page->filter('.offerheadinner > p > span > .show-map-link > strong')->text('nodata');
        //Name
        $GLOBALS['data']['supplier_name']=$page->filter('.user-box__info__name')->text('nodata');
        //Join Date
        $GLOBALS['data']['join_date']=$page->filter('.user-box__info__age')->text('nodata');

        //Date
        $GLOBALS['data']['advertisings_date']=$page->filter('.pdingleft10')->text('nodata');
        $GLOBALS['data']['advertisings_date'] = get_string_between($GLOBALS['data']['advertisings_date'],'تم إضافة الإعلان في','رقم الإعلان'
            );
        //Count Supplier Ads
        if($page->filter('.user-box__info > a')->count()>0){
            $user_url=$page->filter('.user-box__info > a')->attr('href');
            
            $GLOBALS['data']['supplier_count_ads']=$this->get_supplier_ads_count($user_url);
        }
        //Details
        $page->filter('.value')->each(function($item){
            //echo $item->previousAll()->text('nodata') . "<br>";
            //echo $item->filter('strong')->text('nodata') . "<br>";

            $key = $item->previousAll()->text('nodata');
            if ($key != 'المساحة (م٢)') {
                $value = $item->filter('strong > a')->text('nodata');
            }

            if (mb_check_encoding($item->filter('strong > a')->text('nodata'))) {
                if ($key == 'غرف نوم' || $key=='Bedrooms') {
                    $GLOBALS['data']['rooms']=$value;
                }
                if ($key == 'الحمامات'  || $key=='Bathrooms') {
                    $GLOBALS['data']['bath_rooms']=$value;
                }
                if ($key == 'نوع الإعلان') {
                    $GLOBALS['data']['type']=$value;
                }
                if ($key == 'النوع' || $key=='Type' ) {
                    $GLOBALS['data']['aqar_type']=$value;
                }
            }

            if (mb_check_encoding($item->filter('strong')->text('nodata'))) {

                if ($key == 'المساحة (م٢)' || $key=='Area (m²)') {
                    $GLOBALS['data']['area']=$item->filter('strong')->text('nodata');
                }
                if ($key == 'الطابق' || $key == 'Level') {
                    $GLOBALS['data']['floor']=$item->filter('strong')->text('nodata');
                }

            }
            
            
            
        });
        //Images
         $GLOBALS['data']['images']=[];
         if ($page->filter('.photo-glow > img')->count()>0) {
                $page->filter('.photo-glow > img')->each(function($item){
                    
                array_push($GLOBALS['data']['images'], $item->attr('src'));

            });
         }
         
        
        
        //echo $phone ."<br>";
        //echo (isset($GLOBALS['data']['price'])) ? $GLOBALS['data']['price'] : null ;
        //echo "<br>";
        //echo $GLOBALS['data']['title'] ."<br>";
        //echo $GLOBALS['data']['link'] ."<br>";
        //echo $GLOBALS['data']['address'] ."<br>";
        //echo $GLOBALS['data']['advertisings_date'] ."<br>";
        //echo $GLOBALS['data']['supplier_count_ads'] ."<br>";
        //echo $GLOBALS['data']['supplier_name'] ."<br><br><br>";


        return $GLOBALS['data'];
    }

    public function get_supplier_ads_count($url)
    {
        $data=null;
        $url2=null;
        $count_ads_last_page=null;
        $client=new Client;
        $page=$client->request('GET',$url);
        if ( $page->filter('.item')->count()>0 ) {
            //Count of pagination 
            $data=$page->filter('.item')->last()->previousAll()->filter(' a > span')->text('nodata');

            //Last Page Url at validation
            $url2=$page->filter('.item')->last()->previousAll()->filter(' a')->attr('href');

            //Count of Ads at last page in pagination
            $page=$client->request('GET',$url2);
            $count_ads_last_page=$page->filter('.ads__item')->count();
            if ($count_ads_last_page == null) {
                return null;
            }
            
            $count=(int)$data - 1;
            $count=$count * 45;
            $count=$count + $count_ads_last_page;
            return $count;


            //dd($page->filter('.item')->last());
        }
        $count_ads_first_page=$page->filter('.ads__item')->count();
        return $count_ads_first_page;
        
    }

    //AJAX Requets/////////////////////////////
    public function get_number_of_pagination(Request $request)
    {
        $client=new Client;
        $page=$client->request('GET',$request->url);
        
        $count=$page->filter('.item')->count();
        if ($count>0) {
            $count=(int)$page->filter('.item')->last()->previousAll()->filter(' a > span')->text('nodata');
        }
        return ['count'=>$count,'url'=>$request->url];
    }

    public function get_number_of_ads(Request $request)
    {
        $client=new Client;
        $page=$client->request('GET',$request->url);
        $count_ads_page=$page->filter('.ads__item')->count();
        $GLOBALS['ads_links']=[];
        $links=$page->filter('.ads__item > .ads__item__info > a')->each(function($item){
            $GLOBALS['ads_links'][]=$item->attr('href');
        });
        // return $GLOBALS['ads_links'];
        return [
            'count'=>$count_ads_page,
            'ads_links'=>$GLOBALS['ads_links']
        ];
    }

    public function store_ads(Request $request)
    {
        $client=new Client;
        $page=$client->request('GET',$request->url);
        $id = get_string_between($request->url,'ID','.html');
        
        $phone=get_olx_phone_number($id);

        $data=[];
        $GLOBALS['data']['phone'] = $phone;
        $GLOBALS['data']['link'] = $request->url;

        //Title
        $GLOBALS['data']['title']=$page->filter('.offerheadinner > h1')->first()->text('nodata');
        if (!mb_check_encoding($GLOBALS['data']['title'])) {
            $GLOBALS['data']['title']=null;
        }
        

        //$GLOBALS['data']['title'] = \DB::connection()->getPdo()->quote(utf8_encode($GLOBALS['data']['title']));
        //dd($GLOBALS['data']['title']);

        //Price
        $GLOBALS['data']['price']=$page->filter('.offerbox > div > div > div > strong')->text('nodata');

        //Address
        $GLOBALS['data']['address']=$page->filter('.offerheadinner > p > span > .show-map-link > strong')->text('nodata');
        //Name
        $GLOBALS['data']['supplier_name']=$page->filter('.user-box__info__name')->text('nodata');
        //Join Date
        $GLOBALS['data']['join_date']=$page->filter('.user-box__info__age')->text('nodata');

        //Date
        $GLOBALS['data']['advertisings_date']=$page->filter('.pdingleft10')->text('nodata');
        $GLOBALS['data']['advertisings_date'] = get_string_between($GLOBALS['data']['advertisings_date'],'تم إضافة الإعلان في','رقم الإعلان'
            );
        //Count Supplier Ads
        if($page->filter('.user-box__info > a')->count()>0){
            $user_url=$page->filter('.user-box__info > a')->attr('href');
            
            $GLOBALS['data']['supplier_count_ads']=$this->get_supplier_ads_count($user_url);
        }
        //Details
        $page->filter('.value')->each(function($item){
            

            $key = $item->previousAll()->text('nodata');
            if ($key != 'المساحة (م٢)') {
                $value = $item->filter('strong > a')->text('nodata');
            }
            if ($key == 'غرف نوم' || $key=='Bedrooms') {
                $GLOBALS['data']['rooms']=$value;
            }
            if ($key == 'الحمامات'  || $key=='Bathrooms') {
                $GLOBALS['data']['bath_rooms']=$value;
            }
            if ($key == 'المساحة (م٢)' || $key=='Area (m²)') {
                $GLOBALS['data']['area']=$item->filter('strong')->text('nodata');
            }
            if ($key == 'الطابق' || $key == 'Level') {
                $GLOBALS['data']['floor']=$item->filter('strong')->text('nodata');
            }
            if ($key == 'نوع الإعلان') {
                $GLOBALS['data']['type']=$value;
            }
            if ($key == 'النوع' || $key=='Type' ) {
                $GLOBALS['data']['aqar_type']=$value;
            }
            
            
        });
        //Images
         $GLOBALS['data']['images']=[];
         if ($page->filter('.photo-glow > img')->count()>0) {
                $page->filter('.photo-glow > img')->each(function($item){
                    
                array_push($GLOBALS['data']['images'], $item->attr('src'));

            });
         }


        
        $GLOBALS['data']['link']= $request->url;
        // $adversingdata['pagelink_id']= 1;
        $GLOBALS['data']['images']= json_encode($GLOBALS['data']['images']);

        if ($advertising=Advertising::where('phone',$GLOBALS['data']['phone'])->first()) {
            return null;
        }else{
            $advertising=Advertising::create($GLOBALS['data']);
            return view('admin.scrap.tabs.row_prepend',compact('advertising'));
        }
        
    }

    public function save_data_for_one_link(Request $request)
    {
        //dd($request->url);
        $client=new Client;
        $page=$client->request('GET',$request->url);        
        $GLOBALS['link']=19;
        if($page->filter('.ads__item > .ads__item__info > a')->count()>0){

            $data=$page->filter('.ads__item > .ads__item__info > a')->each(function($item){

                    $adversingdata=$this->get_data_olx_one($item->attr('href'));
                    if ($adversingdata != null) {
                        if ($adversingdata['title']==null) {
                            $adversingdata['title']=$item->text();
                        }
                       $adversingdata['link']= $item->attr('href');
                        // $adversingdata['pagelink_id']= 1;
                        $adversingdata['images']= json_encode($adversingdata['images']);

                        if ($adversing=Advertising::where('phone',$adversingdata['phone'])->first()) {
                        }else{
                            Advertising::create($adversingdata);
                        }
                    }
                    
            });

        }
        
        return ['status'=>'success'];
    }
}
*/




}

