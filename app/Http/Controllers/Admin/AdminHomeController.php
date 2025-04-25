<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Models\form_choice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\formChk;

class AdminHomeController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('role:admin');
    }

    public function index()
    {
        $form_list = DB::table('form_chks')
        ->where('form_status','=','1')
        ->get();

        $branch_list = DB::table('branch_names')
        ->get();

        return view('admin.dashboard',compact('form_list','branch_list'));
    }

    public function list_form(){
        $list_form = formChk::all();   
        return view('admin.list_form',compact('list_form'));
    }

    public function create_form(){

        $form_type = DB::table('form_types')
        ->get();

        return view('admin.create_form',compact('form_type'));
    }

    public function insert_form(Request $request){
        $form_id = Str::upper(Str::random(15)); 
        $id = Auth::user()->id;
        
        DB::table('form_chks')->insert([
            'user_id' => $id,
            'form_id' => $form_id,
            'form_name' => $request->form_name,
            'form_type' =>$request->form_type,
            'form_category' => $request->form_category,
            'created_at' => Carbon::now()
        ]);

        foreach ($request->category_name as $key => $value) {
            $category_id = Str::upper(Str::random(12)); 
            DB::table('form_categories')->insert([
                'form_id'=>$form_id,
                'category_id'=>$category_id,
                'category_name'=>$value,
                'created_at' => Carbon::now()
            ]);
        }

        return redirect()->route('admin_form')->with('success', 'สร้างฟอร์มเรียบร้อยแล้ว');
    }

    public function formDetail($id){
        $formDetail = DB::table('form_categories')
        ->where('form_categories.form_id','=',$id)
        ->get();

        $formName = DB::table('form_chks')
        ->where('form_id','=',$id)
        ->get();

        return view('admin.formDetail',['id'=>$id],compact('formDetail','formName'));
    }

    public function formDetailChoice($id){
        $category_choice = DB::table('form_choices')
        ->where('category_id','=',$id)
        ->get();    
        
        $categoryName = DB::table('form_categories')
        ->where('category_id','=',$id)
        ->get();

        return view('admin.formDetailChoice',['id'=>$id],compact('category_choice','categoryName'));
    }
  
    public function formPreview($id){
        $formPreview = DB::table('form_chks')
        ->select('form_chks.form_id','form_chks.form_name','form_categories.category_id','form_categories.category_name')
        ->join('form_categories','form_chks.form_id','=','form_categories.form_id')        
        ->where('form_chks.form_id','=',$id)
        ->get();
        
        $formName = DB::table('form_chks')
        ->where('form_id','=',$id)
        ->get();

        return view('admin.formPreview',compact('formPreview','formName'));
    }

    //CRUDข้อตรวจ

    
    public function add_chk_choice($id){
        $form_chk = DB::table('form_chks')
        ->join('form_categories','form_chks.form_id','=','form_categories.form_id')
        ->where('form_categories.category_id','=',$id)
        ->get();
        return view('admin.add_choice',compact('form_chk'));
    }

    public function insert_choice(Request $request,$id){

        $form_id = $request->form_id;
        foreach ($request->addmore as $key => $value) {
            DB::table('form_choices')->insert([
                'form_id' => $form_id,
                'category_id' => $id,
                'form_choice' =>$value,
                'created_at' => Carbon::now()
            ]);
        }       
        return redirect()->route('admin_formDetail',['id'=>$form_id])->with('success','บันทึกเรียบร้อยแล้ว');
    
    }

    public function formChoiceEdit($id){

        $ChoiceEdit = DB::table('form_choices')
        ->join('form_categories','form_choices.category_id','=','form_categories.category_id')
        ->where('form_choices.id','=',$id)
        ->get();

        return view('admin.formChoiceEdit',['id'=>$id],compact('ChoiceEdit'));
    }

    public function formChoiceEditPic($id){

        $ChoiceEdit = DB::table('form_choices')
        ->join('form_categories','form_choices.category_id','=','form_categories.category_id')
        ->where('form_choices.id','=',$id)
        ->get();

        return view('admin.formChoiceEditPic',['id'=>$id],compact('ChoiceEdit'));
    }

    public function formChoiceUpdate(Request $request,$id){
        $cate_id = $request->cate_id;

        DB::table('form_choices')->where('id','=',$id)
        ->update([
            'form_choice' => $request->choiceEdit,
            'updated_at' => Carbon::now()
        ]);

        $category_choice = DB::table('form_choices')
        ->where('category_id','=',$cate_id)
        ->get();    
        
        $categoryName = DB::table('form_categories')
        ->where('category_id','=',$cate_id)
        ->get();

        return redirect()->route('admin_formDetailChoice',['id'=>$cate_id])
        ->with('category_choice', $category_choice)
        ->with('categoryName', $categoryName)
        ->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function formChoiceUpdatePic(Request $request,$id){
        $cate_id = $request->cate_id;
        $request->validate([
            'img_choice' => 'required|image|mimes:jpeg,png,jpg|max:5048',
        ]);

        $imageName = time() . '.' . $request->img_choice->extension();  
        $request->img_choice->move(public_path('file'), $imageName);

        DB::table('form_choices')->where('id','=',$id)
        ->update([
            'choice_img' => $imageName,
            'updated_at' => Carbon::now()
        ]);

        $category_choice = DB::table('form_choices')
        ->where('category_id','=',$cate_id)
        ->get();    
        
        $categoryName = DB::table('form_categories')
        ->where('category_id','=',$cate_id)
        ->get();

        return redirect()->route('admin_formDetailChoice',['id'=>$cate_id])
        ->with('category_choice', $category_choice)
        ->with('categoryName', $categoryName)
        ->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function formChoiceDelete($id,$cid)
    {
        DB::table('form_choices')->where('id','=',$id)
        ->delete();

        $category_choice = DB::table('form_choices')
        ->where('category_id','=',$cid)
        ->get();    
        
        $categoryName = DB::table('form_categories')
        ->where('category_id','=',$cid)
        ->get();

        return redirect()->route('admin_formDetailChoice',['id'=>$cid])
        ->with('category_choice', $category_choice)
        ->with('categoryName', $categoryName)
        ->with('success','ลบข้อมูลเรียบร้อยแล้ว');
    }

    //CRUDหมวดหมู่

    public function formCategoryEdit($id){

        $CategoryEdit = DB::table('form_categories')
        ->join('form_chks','form_chks.form_id','=','form_categories.form_id')
        ->where('form_categories.category_id','=',$id)
        ->get();

        return view('admin.formCategoryEdit',['id'=>$id],compact('CategoryEdit'));
    }

    public function formCategoryUpdate(Request $request,$id){
        $form_id = $request->form_id;

        DB::table('form_categories')->where('category_id','=',$id)
        ->update([
            'category_name' => $request->category_name,
            'updated_at' => Carbon::now()
        ]);

        return redirect()->route('admin_formDetail',['id'=>$form_id])->with('success','บันทึกเรียบร้อยแล้ว');
    }

    public function formCategoryDelete($cid,$form_id)
    {

        DB::table('form_categories')->where('category_id','=',$cid)
        ->delete();

        DB::table('form_choices')->where('category_id','=',$cid)
        ->delete();
         
        $formName = DB::table('form_chks')
        ->where('form_id','=',$form_id)
        ->get();

        return redirect()->route('admin_formDetail',['id'=>$form_id])
        ->with('formDetail', $formName)
        ->with('success','ลบข้อมูลเรียบร้อยแล้ว');
    }

    //รายงานสาขา
    public function ReportBranch ($id)
    {        
        $branch_name = DB::table('branch_names')
        ->where('id_branch','=',$id)
        ->first();

        $form_branch = DB::table('agent_form_lists')
        ->select('form_chks.form_id','form_chks.form_name','agent_form_lists.agent_id')
        ->join('form_chks','agent_form_lists.form_id','=','form_chks.form_id')
        ->where('agent_form_lists.agent_id','=',$id)
        ->where('agent_form_lists.agentform_status','=','1')
        ->groupBy('form_chks.form_id')
        ->orderBy('form_chks.id','ASC')
        ->get();

        $user_list = DB::table('user_details')
        ->join('user_forms','user_details.user_id','=','user_forms.user_id')
        ->where('user_details.user_dep','=',$id)
        ->orderBy('user_details.created_at','DESC')
        ->get();

        return view('admin.ReportBranch',['id'=>$id],compact('branch_name','user_list','form_branch'));
    }

    public function ReportStdChk ($branch,$form)
    {
        $branch_name = DB::table('branch_names')
        ->where('id_branch','=',$branch)
        ->first();

        $form_name = DB::table('form_chks')
        ->where('form_id','=',$form)
        ->first();
        
        $record_data = DB::table('chk_records')
            ->join('form_chks', 'chk_records.form_id', '=', 'form_chks.form_id')
            ->join('user_details', 'chk_records.user_id', '=', 'user_details.user_id')
            ->join('form_types','form_chks.form_type','=','form_types.id')
            ->select('chk_records.round_chk', 'form_chks.form_name','form_chks.form_type', 'user_details.fullname', 'chk_records.created_at','form_types.form_type_name')
            ->where('chk_records.form_id', '=', $form)
            ->where('chk_records.agent_id', '=', $branch)
            ->groupBy('chk_records.round_chk')
            ->orderBy('chk_records.created_at','DESC')
            ->get();

        return view('admin.ReportStdChk',['branch'=>$branch,'form'=>$form],compact('branch_name','form_name','record_data'));
    }

    public function StdChkDetail($round,$type)
    {

        $formview = DB::table('chk_records')
        ->join('form_choices', 'chk_records.choice_id', '=', 'form_choices.id')
        ->select('chk_records.choice_id', 'chk_records.choice_remark', 'chk_records.user_chk', 'chk_records.created_at', 'form_choices.form_choice', 'form_choices.choice_img')
        ->where('chk_records.round_chk', '=', $round)
        ->get();

    $formchk_date = DB::table('chk_records')
        ->select('chk_records.created_at', 'chk_records.round_chk')
        ->where('chk_records.round_chk', '=', $round)
        ->orderBy('id', 'asc')
        ->limit(1)
        ->get();
      
        if($type == '4')
        {
            $form_id = DB::table('detail_records')
            ->where('round_chk', '=', $round)
            ->value('form_id_chk');

            $formName = DB::table('form_chks')
            ->where('form_id', '=', $form_id)
            ->get();

            $car_data = DB::table('detail_records')
            ->join('user_details', 'detail_records.std_id', '=', 'user_details.user_id')
            ->join('users', 'detail_records.user_id', '=', 'users.user_id')
            ->join('branch_names','detail_records.user_dep','=','branch_names.id_branch')
            ->where('detail_records.round_chk', '=', $round)
            ->get();
        }else
        {
         
        $car_data = DB::table('chk_record_forms')
            ->join('form_car_datas', 'chk_record_forms.car_id', '=', 'form_car_datas.id')
            ->join('user_details', 'chk_record_forms.user_id', '=', 'user_details.user_id')
            ->join('form_chks', 'form_car_datas.form_id', '=', 'form_chks.form_id')
            ->select('form_car_datas.car_plate', 'form_car_datas.car_province', 'form_car_datas.car_type', 'form_chks.form_name', 'chk_record_forms.car_mileage','user_details.fullname')
            ->where('chk_record_forms.round_chk', '=', $round)
            ->get();

        }

       
        return view('admin.ReportStdDetail', ['round' => $round], compact('formview', 'formchk_date', 'car_data'));
    }


}
