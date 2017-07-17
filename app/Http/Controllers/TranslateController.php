<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TranslateController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function test(){
        return view('admin.translate.index');
    }

    public function set( Request $request){
        $input = $request->all();
        $resources = resource_path();
        $langs = ['ro','ru'];
        foreach($langs as $keylang)
        {
            $path = $resources.'/lang/'.$keylang.'/v.php';
            if( file_exists( $path )){
                $array = [];
                $string = "<?php ".PHP_EOL;
                $string .= "return [".PHP_EOL;
                foreach( $input as $key=>$item ){
                    $l=explode('_',$key);
                    if( $key == '_token' ||($keylang!=$l[0]) ) continue;
                    $key=substr($key,3);
                    $array[$key]= $item;
                    $string.="\t'".$key."' => '".str_replace("'","\'",$item)."',".PHP_EOL;
                }
                $string.="];";
                file_put_contents($path, $string);
            }
        }

        return redirect()->back();
    }

}
