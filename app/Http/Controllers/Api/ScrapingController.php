<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Goutte\Client;
use App\Models\Advertising;
use App\Http\Controllers\Api\ApiResponseHelper;
use App\Http\Resources\AdsResource;
use Symfony\Component\CssSelector\CssSelectorConverter;

class ScrapingController extends Controller
{
	use ApiResponseHelper;

	/*
		-This function get the number of olx pagination pages 
		-Get array of pagination pages urls
		-Get Count and Current Page Number
	*/
	public function get_number_of_pagination(Request $request)
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
             array_push($pagination_pages, $url.'?page='. $i);
         }

        //Check if the link is search link 
        $is_search=0;
        if (($searchUrl = strpos($request->url, "search")) !== FALSE) { 
                $is_search=1;
                $current_count=(int)substr($request->url, strpos($request->url, "&page=")+5);
            }
        $data=[
            'count'=>$count,
            'url'=>$url,
            'current_count'=>$current_count,
            'is_search'=>$is_search,
            'pagination_pages'=>$pagination_pages
        ];

        return $this->setCode(200)->setSuccess('Data Retrived Successfully')->setData($data)->send();
         
        return $data;
    }


    /*
		-This function for Getting number of ads for single page from pagination pages whic comes from function "get_number_of_pagination"
		- Getting array of Ads Links For Single page
    */

    public function get_number_of_ads(Request $request)
    {
 //    	$converter = new CssSelectorConverter();
 // $converter->toXPath('.listHandler > a > table > tbody > tr > td > .ads > .ads__item > .ads__item__info > a');

        $client=new Client;
        $page=$client->request('GET',$request->url);
        $count_ads_page=$page->filter('.ads__item')->count();
        $GLOBALS['ads_links']=[];
        $GLOBALS['ads'] = Advertising::where('id',0)->get();
        //return response()->json($GLOBALS['ads']);
        $links=$page->filter('.ads > .ads__item > .ads__item__info > a')->each(function($item){
            //$GLOBALS['ads_links'][]=$item->attr('href');
            $GLOBALS['ads_links'][]=$item->attr('title');
            //$current_ad=$this->store_ads_for_web($item->attr('href'));
            //$GLOBALS['ads']->push($current_ad);

        });
        //$firstAds=Advertising::where('link',$GLOBALS['ads_links'][0])->first();
        //$ads=Advertising::where('id','>=',$firstAds->id)->get();
        // return $GLOBALS['ads_links'];
        $data= [
            'count'=>$count_ads_page,
            'ads_links'=>$GLOBALS['ads_links'],
            //'ads'=>$ads
        ];
        return $this->setCode(200)->setSuccess('Data Retrived Successfully')->setData($data)->send();
    }


    /*
		-This is the mainly function to scrap and store Ads
		-This Get some required ads details from olx website
    */

    public function store_ads(Request $request)
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
            return $this->setCode(200)->setSuccess('Data Retrived Successfully')->setData($advertising)->send();
            return $advertising;
            return view('admin.scrap.tabs.row_prepend',compact('advertising'));
        }
        
    }

    public function store_ads_for_web($url)
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


        
        $GLOBALS['data']['link']= $url;
        // $adversingdata['pagelink_id']= 1;
        $GLOBALS['data']['images']= json_encode($GLOBALS['data']['images']);
        if ($GLOBALS['data']['title']==null) {
            return null;
        }
        // $advertising=Advertising::create($GLOBALS['data']);
        //     return view('admin.scrap.tabs.row_prepend',compact('advertising'));

        if ($advertising=Advertising::where('title',$GLOBALS['data']['title'])->first()) {
            return $advertising;
        }

        if (session()->get('check_phone')==1 && $advertising=Advertising::where('phone',$GLOBALS['data']['phone'])->first()) {
            return null;
        }else{
            $advertising=Advertising::create($GLOBALS['data']);
            return $this->setCode(200)->setSuccess('Data Retrived Successfully')->setData($advertising)->send();
            return $advertising;
            return view('admin.scrap.tabs.row_prepend',compact('advertising'));
        }
        
    }


    /* This Function For Getting the ads count of the owner */
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
    
}
