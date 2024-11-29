<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\TaskFeedbacks;
use App\Models\User;

class TaskFeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
   

    public function index(Request $request)
    {
        //
        if($request->input('type')=='treeData'){        
            $id_task=$request->input('id_task');
            $res = $this->getAllFeedbackLevels(null,['id_task','=',$id_task]);
        }else{
            $res = TaskFeedbacks::with('create_by','id_task')->get()->toArray();
        }
        if($res){
            return response()->json(['success'=>true, 'data'=>$res]);
        }else{
            return response()->json(['success'=>true, 'data'=>[]]);
        }

    }

    public function getAllFeedbackLevels($parentId = null,$filters)
    {
        $filter=[['id_parent','=', $parentId]];
        array_push($filter,$filters);
       
        // Tìm kiếm tất cả feedbacks con của parentId.        
        $feedbacks = TaskFeedbacks::select('*')
            ->with('create_by:id,name')
            ->where($filter)
           
            // ->orderBy('created_at', 'desc')
            ->get()
            ->toArray();       
        // Duyệt qua từng feedback và lấy tất cả các level con của nó.
        foreach ($feedbacks as &$feedback) {
            $feedback['children'] = $this->getAllFeedbackLevels($feedback['id'],$filters);
        }

        return $feedbacks;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //
         
        try{
            $form= $request->post();                            
            $res = TaskFeedbacks::create($form);
            if($res){
                return response()->json(['success'=>true, 'mess'=>'Thêm mới thành công!']);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Thêm mới thất bại!']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        try{
            $res = TaskFeedbacks::find($id);
            if($res){
                return response()->json(['success'=>true, 'data'=>$res]);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Module đang tìm không tồn tại!']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
        try{
            $formData = $request->post();            
            $res = TaskFeedbacks::find($id)->update($formData);
            if($res){
                return response()->json(['success'=>true, 'mess'=>'Cập nhật dữ liệu thành công']);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Cập nhật thất bại!']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }
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
        try{
            $res = TaskFeedbacks::find($id)->delete();
            if($res){
                return response()->json(['success'=>true, 'mess'=>'Xóa dữ liệu thành công!']);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Xóa dữ liệu thất bại!']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }
    }
}
