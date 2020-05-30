<?php

namespace App\Http\Controllers;

use App\Models\News\News;
use App\Models\News\CarouselItem;
use App\Models\News\HomeNewControllerCert;
use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class HomeController extends Controller
{
    public function view()
    {
        //VATSIM online controllers
        $vatsim = new \Vatsimphp\VatsimData();
        $allPositions=[];
        $vatsim->setConfig('cacheOnly', false);
        $planes = null;
        $finalPositions = array();
        if ($vatsim->loadData())
            $centreControllers = $vatsim->searchCallsign('CZWG_');
            $winnipegControllers = $vatsim->searchCallsign('CYWG_');
            $portageControllers = $vatsim->searchCallsign('CYPG_');
            $standrewsControllers = $vatsim->searchCallsign('CYAV_');
            $saskatoonControllers = $vatsim->searchCallsign('CYXE_');
            $reginaControllers = $vatsim->searchCallsign('CYQR_');
            $thunderbayControllers = $vatsim->searchCallsign('CYQT_');
            $moosejawControllers = $vatsim->searchCallsign('CYMJ_');
            array_push($allPositions, $centreControllers->toArray(), $winnipegControllers->toArray(), $portageControllers->toArray(), $standrewsControllers->toArray(), $saskatoonControllers->toArray(), $reginaControllers->toArray(), $thunderbayControllers->toArray(), $moosejawControllers->toArray());

            foreach($allPositions as $controller){
                foreach($controller as $c)
                    if(!Str::endsWith($c['callsign'], '_ATIS'))
                        $finalPositions[] = $c;
            }
            
            Log::info($finalPositions);
            Log::info('cheese');
            $planes = $vatsim->getPilots()->toArray();

        //News
        $news = News::where('visible', true)->get()->sortByDesc('published')->take(3);
        $certifications = HomeNewControllerCert::all()->sortByDesc('timestamp')->take(6);
        $carouselItems = CarouselItem::all();

        //Get VATCAN news
        $vatcanNews = Cache::remember('news.vatcan', 21600, function () {
            $url = 'http://www.vatcan.ca/ajax/news';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $json = curl_exec($ch);
            error_log('Grabbing VATCAN news from API');
            Log::info('Grabbing VATCAN news from API '.date('Y-m-d H:i:s'));
            curl_close($ch);
            return json_decode($json);
        });
        return view('index', compact('finalPositions', 'news', 'vatcanNews', 'certifications', 'carouselItems', 'planes'));
    }
    
    public function map()
    {
        //VATSIM online controllers
        $vatsim = new \Vatsimphp\VatsimData();
        $vatsim->setConfig('cacheOnly', false);
        $allPositions=[];
        $planes = null;
        if ($vatsim->loadData()) {
            $centreControllers = $vatsim->searchCallsign('CZWG_');
            $winnipegControllers = $vatsim->searchCallsign('CYWG_');
            $portageControllers = $vatsim->searchCallsign('CYPG_');
            $standrewsControllers = $vatsim->searchCallsign('CYAV_');
            $saskatoonControllers = $vatsim->searchCallsign('CYXE_');
            $reginaControllers = $vatsim->searchCallsign('CYQR_');
            $thunderbayControllers = $vatsim->searchCallsign('CYQT_');
            $moosejawControllers = $vatsim->searchCallsign('CYMJ_');
            array_push($allPositions, $centreControllers->toArray(), $winnipegControllers->toArray(), $portageControllers->toArray(), $standrewsControllers->toArray(), $saskatoonControllers->toArray(), $reginaControllers->toArray(), $thunderbayControllers->toArray(), $moosejawControllers->toArray());

            foreach($allPositions as $controller){
                foreach($controller as $c)
                    if(!Str::endsWith($c['callsign'], '_ATIS'))
                        $finalPositions[] = $c;
            }
            $planes = $vatsim->getPilots()->toArray();
        }
        return view('map', compact('finalPositions', 'planes'));
    }
}