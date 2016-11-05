<?php
namespace Lusong\Geocode\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;

class GeocodeController extends Controller
{
    /**
     * Show the application welcome screen to the user.
     *
     * @return Response
     */
    public function index()
    {
        // dd(Config::get("contact.message"));
        // return view('geocode::geocode');
         $url="http://restapi.amap.com/v3/geocode/geo?key=389880a06e3f893ea46036f030c94700&output=json&address=北京市海淀区互联网金融中心";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        $output = curl_exec($ch);
        curl_close($ch);
        $data=json_decode($output);
        $codes=$data->geocodes;
        $code=$codes[0]->location.",";
        $contract=explode(',',$code,-1);
        return json_encode(array('lat'=>$contract[1],'lng'=>$contract[0]));
    }
}