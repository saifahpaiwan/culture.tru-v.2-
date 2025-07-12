<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 

class MenuCortroller extends Controller
{
    public function menulist()
    {
        $data = array();
        return view('backend.menu.list', compact('data'));
    } 

    public function savemenuitems(Request $request)
    {
        if(isset($request)){
            $row=[];
            $data = array(
                'name'       => $request->menu_name,  
                'slug'       => $request->menu_slug,  
                'ip_address' => $request->ip(),
                'created_at' => new \DateTime(),
            );
            $get_id = DB::table('menus')->insertGetId($data);
            if(isset($get_id)){
                $row = DB::table('menus')->where('id', $get_id)->first();
            }
            return $row;
        } 
    }

    public function savemenu(Request $request)
    {    
        $arr = json_decode($request->output); 
        $itmes=[];  
         
        if(isset($arr) && count($arr)>0){
            foreach($arr as $key=>$row){  
                $Qry1 = DB::table('menus')->where('id', $row->id)->first();    
                $itmes[$key]['id'] = $Qry1->id;
                $itmes[$key]['content'] = '<div class="d-flex"> <div class="mr-auto contentID-'.$Qry1->id.'"> ID : '.$Qry1->id.' '.$Qry1->name.' [URL : '.$Qry1->slug.']</div> <div>  
                <a href="javascript:void(0)" data-id="' .$Qry1->id. '" class="Cupdate" data-name="' .$Qry1->name. '" data-slug="' .$Qry1->slug. '" style="height: unset;font-size: 16px; margin: 0 5px;"><i class="mdi mdi-pencil"></i></a>
                <a href="javascript:void(0)" data-id="' .$Qry1->id. '" class="Cdelete" style="height: unset;font-size: 16px; margin: 0 5px;"><i class="mdi mdi-close"></i></a>  
                </div> </div>';  
                if(isset($row->children) && count($row->children)>0){
                    foreach($row->children as $key2=>$row2){
                        $Qry2 = DB::table('menus')->where('id', $row2->id)->first(); 
                        $itmes[$key]['children'][$key2]['id'] = $Qry2->id;
                        $itmes[$key]['children'][$key2]['content'] = '<div class="d-flex"> <div class="mr-auto contentID-'.$Qry2->id.'"> ID : '.$Qry2->id.' '.$Qry2->name.' [URL : '.$Qry2->slug.']</div> <div>  
                        <a href="javascript:void(0)" data-id="' .$Qry2->id. '" class="Cupdate" data-name="' .$Qry2->name. '" data-slug="' .$Qry2->slug. '" style="height: unset;font-size: 16px; margin: 0 5px;"><i class="mdi mdi-pencil"></i></a>
                        <a href="javascript:void(0)" data-id="' .$Qry2->id. '" class="Cdelete" style="height: unset;font-size: 16px; margin: 0 5px;"><i class="mdi mdi-close"></i></a>   
                        </div> </div>';  
                    }
                }
            }
        } 

        $count = DB::table('menu_mgs')->count();
        if($count==0){
            $data = array(
                'list'      => json_encode($itmes),  
                'created_at' => new \DateTime(),
            );
            DB::table('menu_mgs')->insert($data);
        } else if($count==1){
            $data = array(
                'list'      => json_encode($itmes),  
                'updated_at' => new \DateTime(),
            );
            DB::table('menu_mgs')
            ->where('menu_mgs.id', 1)
            ->update($data);
        } 
        return DB::table('menu_mgs')->select('list')->where('id', 1)->get();
    }

    public function getdatamenu()
    {
        return DB::table('menu_mgs')->select('list')->where('id', 1)->get();
    }

    public function updateMenu(Request $request)
    {
        if(isset($request->id)){
            $data = array(
                'name'       => $request->menu_name,  
                'slug'       => $request->menu_slug,  
                'ip_address' => $request->ip(),
                'updated_at' => new \DateTime(),
            );
            return DB::table('menus')->where('id', $request->id)
            ->update($data);
        } 
    }

    public function deleteMenu(Request $request)
    {
        if(isset($request->id)){
            return DB::table('menus')->where('id', $request->id)
            ->delete();
        } 
    }
 
}
