<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\formChk;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Laravel\Facades\Image;


class AdminConfigController extends Controller
{
    public function ConfigDashboard($id){
        $Userdetail = DB::table('user_details')
        ->where('user_id','=',$id)
        ->get();
        return view('admin.ConfigDashboard',['id'=>$id],compact('Userdetail'));
    }

    public function InsertConfig(Request $request,$id){

        if ($request->hasFile('file_um')) {
            $file_input_um = $request->file('file_um');
            $imageName = 'UM_'.time().'-'.$file_input_um->getClientOriginalName();
            $upload_location = 'upload/';
            $full_path_um = $upload_location . $imageName;
            $file_input_um->move($upload_location, $imageName);
        }else{
            $full_path_um = '0';
        }

        if ($request->hasFile('file_brochure')) {
            $file_input_bc = $request->file('file_brochure');
            $imageName = 'BC_'.time().'-'.$file_input_bc->getClientOriginalName();
            $upload_location = 'upload/';
            $full_path_bc = $upload_location . $imageName;
            $file_input_bc->move($upload_location, $imageName);
        }else{
            $full_path_bc = '0';
        }

        if ($request->hasFile('file_roadmap')) {
            $file_input_rm = $request->file('file_roadmap');
            $imageName = 'RM_'.time().'-'.$file_input_rm->getClientOriginalName();
            $upload_location = 'upload/';
            $full_path_rm = $upload_location . $imageName;
            $file_input_rm->move($upload_location, $imageName);
        }else{
            $full_path_rm = '0';
        }

        DB::table('setting_agents')
        ->insert([
            'user_id'=>$id,
            'vid_company'=>$request->vid_company,
            'vid_um'=>$request->vid_um,
            'file_um'=>$full_path_um,
            'file_brochure'=>$full_path_bc,
            'file_roadmap'=>$full_path_rm,
            'created_at' => Carbon::now()
        ]);
        return redirect()->route('admin_UserDetail',['id'=>$id])->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function ConfigForm($id){
        $agent = DB::table('user_details')
        ->where('user_id','=',$id)
        ->get();

         $agent_form = DB::table('agent_form_lists')->select('form_id')->where('agent_id','=',$id);

        $form_list = DB::table('form_chks')
        ->whereNotIn('form_id', $agent_form)
        ->get();

        $form_agent_list = DB::table('form_chks')
        ->leftJoin('agent_form_lists','form_chks.form_id','=','agent_form_lists.form_id')
        ->select('form_chks.form_name','agent_form_lists.*')
        ->where('agent_form_lists.agent_id','=',$id)
        ->get();

        return view('admin.ConfigForm',['id'=>$id],compact('form_list','agent','form_agent_list'));
    }

    public function InsertConfigForm(Request $request,$id){

        foreach ($request->form_chk as $key => $value) {
            DB::table('agent_form_lists')->insert([
                'agent_id'=>$id,
                'form_id'=>$value,
                'agentform_status'=>'1',   
                'created_at' => Carbon::now()
            ]);
        } 

        return redirect()->route('admin_ConfigForm',['id'=>$id])->with('success','บันทึกเรียบร้อยแล้ว');      
    }

    public function UnlistForm(Request $request)
    {
        $form_id = $request->form_id;
        $agent_id = $request->agent_id;
        DB::table('agent_form_lists')->where('form_id','=',$form_id)
        ->where('agent_id','=',$agent_id)
        ->delete();

        DB::table('agent_form_pers')->where('form_id','=',$form_id)
        ->where('agent_id','=',$agent_id)
        ->delete();

        return redirect()->route('admin_ConfigForm',['id'=>$agent_id])->with('success','ดำเนินการสำเร็จ');      
    }
}
