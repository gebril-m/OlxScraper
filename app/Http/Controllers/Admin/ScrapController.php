<?php

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

    //To Scrap data from olx url For Test
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
    public function get_number_of_pagination(Request $request,$id)
    {
        $client=new Client;
        $page=$client->request('GET',$request->url);

        $pagination_pages=[];
        //Get Count and Current Page Number
        $count=$page->filter('.item')->count();
        $current_count=1;
        if ($count>0) {
            $count=(int)$page->filter('.item')->last()->previousAll()->filter(' a > span')->text('nodata');
            
                $current_count=(int)$page->filter('.current > span')->text('nodata');
                
                if ($current_count >=0) {
                    $sub_count=$count-($current_count-1);
                }

        }else{
             array_push($pagination_pages, $request->url);
        }
        
        //Cut string "?page=25"
        $a=substr($request->url, strpos($request->url, "page=") );
        $url=$a;
        if ($a != $request->url) {
            $url=str_replace($a, "", $request->url);
        }

        //Save Pagination page links 
        for ($i=$current_count; $i <$count ; $i++) { 
             array_push($pagination_pages, $url.'page='. $i);
         }

        //Check if the link is search link 
        $is_search=0;
        if (($searchUrl = strpos($request->url, "search")) !== FALSE) { 
                $is_search=1;
                $current_count=(int)substr($request->url, strpos($request->url, "page=")+5);
            }
         
        return [
            'count'=>$count,
            'url'=>$url,
            'current_count'=>$current_count,
            'is_search'=>$is_search,
            'pagination_pages'=>$pagination_pages
        ];
    }

    public function get_number_of_ads(Request $request,$id)
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

    public function store_ads(Request $request,$id)
    {
        
        $client=new Client;
        $page=$client->request('GET',$request->url);
        if ($page->filter('.lheight24')->text('nodata')=='لم نتمكن من العثور على شيء') {
            return null;
        }
        $id = get_string_between($request->url,'ID','.html');
        
        $phone=get_olx_phone_number($id);

        $data=[];
        $GLOBALS['data']['phone'] = $phone;
        $GLOBALS['data']['link'] = $request->url;

        //Title
        $GLOBALS['data']['title']=$page->filter('.offerheadinner > h1')->first()->text('nodata');
        if (!mb_check_encoding($GLOBALS['data']['title'])) {
            $GLOBALS['data']['title']=mb_strtoupper(mb_substr($GLOBALS['data']['title'], 0, 1));

        }
        

        //$GLOBALS['data']['title'] = \DB::connection()->getPdo()->quote(utf8_encode($GLOBALS['data']['title']));
        //dd($GLOBALS['data']['title']);

        //Price
        $GLOBALS['data']['details']=$page->filter('#textContent')->text('nodata');
        if (!mb_check_encoding($GLOBALS['data']['details'])) {
            
            $GLOBALS['data']['details'] = mb_strtoupper(mb_substr($GLOBALS['data']['details'], 0, 1));

        }


         //Price
        $GLOBALS['data']['price']=$page->filter('.offerbox > div > div > div > strong')->text('nodata');
        $GLOBALS['data']['price']=str_replace('ج.م', '', $GLOBALS['data']['price']);
        $GLOBALS['data']['price']=(int)str_replace(',', '', $GLOBALS['data']['price']);

        //Address
        $GLOBALS['data']['address']=$page->filter('.offerheadinner > p > span > .show-map-link > strong')->text('nodata');
        //Name
        $GLOBALS['data']['supplier_name']=$page->filter('.user-box__info__name')->text('nodata');
        //Join Date
        $GLOBALS['data']['join_date']=$page->filter('.user-box__info__age')->text('nodata');
        $GLOBALS['data']['join_date']=str_replace(',', '', $GLOBALS['data']['join_date']);

        //Date
        $GLOBALS['data']['advertisings_date']=$page->filter('.pdingleft10')->text('nodata');
        $GLOBALS['data']['advertisings_date'] = get_string_between($GLOBALS['data']['advertisings_date'],'تم إضافة الإعلان في','رقم الإعلان'
            );
        $GLOBALS['data']['advertisings_date']=str_replace(',', '', $GLOBALS['data']['advertisings_date']);
        //return get_valid_date_olx($GLOBALS['data']['advertisings_date']);
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
                if ($key == 'نوع الإعلان'  || $key == 'Ad Type') {
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


        
        $GLOBALS['data']['link']= $request->url;
        // $adversingdata['pagelink_id']= 1;
        $GLOBALS['data']['images']= json_encode($GLOBALS['data']['images']);
        if ($GLOBALS['data']['title']==null) {
            return null;
        }
        // $advertising=Advertising::create($GLOBALS['data']);
        //     return view('admin.scrap.tabs.row_prepend',compact('advertising'));

        if ($advertising=Advertising::where('title',$GLOBALS['data']['title'])->first()) {
            return null;
        }

        if (session()->get('check_phone')==1 && $advertising=Advertising::where('phone',$GLOBALS['data']['phone'])->first()) {
            return null;
        }else{
            $advertising=Advertising::create($GLOBALS['data']);
            return $advertising;
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

    //Check if exists in contact base
    public function toggole_check_if_exist_in_contact_base(Request $request)
    {
        
        session()->put('check_contact_base',(int)$request->contact_base);
        session()->put('check_phone',(int)$request->phone);
        session()->put('check_tab_exists',(int)$request->tab_exists);
        dd(session()->get('check_phone'));
        
    }

    public function change_following($tab_id,$id,$value)
    {
        $adversing=Advertising::find($id);
        $adversing->following=$value;
        $adversing->save();
        return view('admin.scrap.tabs.data_following',compact('adversing'));
    }
}
