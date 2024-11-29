<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\Banners;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try{
            $formData = $request->post();
            $PageLimit=20;
            $Page=1;
            $Column=['*'];
            $SortField='Id';
            $SortType='DESC';
            @$formData['SortType']&&$SortType=@$formData['SortType']==1?'DESC':'ASC';
            @$formData['SortField']&&$SortField=@$formData['SortField'];
            @$formData['Column']&&$Column=@$formData['Column'];
            @$formData['PageLimit']&&$PageLimit=@$formData['PageLimit'];
            @$formData['Page']&&$Page=@$formData['Page'];
            $query=[];
            if(@$formData['TextSearch']){
                array_push($query,['title', 'LIKE' , "%" . @$formData['TextSearch'] . "%"]);
            }
            if(@$formData['Hidden']){
                array_push($query,['Hidden', @$formData['Hidden']]);
            }
            $res = Banners::where($query)
                ->orderBy($SortField, $SortType)
                ->paginate($PageLimit, $Column, 'Page',$Page)
                ->toArray();
            if($res){
                return response()->json([
                    'success'=> true,
                    'data'=>$res['data'],
                    'total'=>$res['total'],
                    'itemFrom'=>$res['from'],
                    'itemTo'=>$res['to'],
                    'totalPage'=>$res['last_page'],
                ]);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

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
        try{
            $formData = $request->post();
            // $request->validate([
            //     'image' => 'required|mimes:png,PNG,jpg,JPG|max:2048',
            // ]);
            $file = $request->file('image');
            if($file){
                $formData['path']= $this->upoadFile($file);
            }
            $res = Banners::create($formData);
            if($res){
                return response()->json(['success'=>true, 'mess'=>'Thêm mới thành công!']);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Thêm mới thất bại!']);
            }

         }catch(\Exception $e){
             return response()->json(['success'=>false, 'mess'=>$e]);
         }
    }

    // uploadFile
    public function upoadFile($file){
        $fileName ='banner_'.time().'.'.$file->extension();
        if($file->move(public_path('uploads/banners'), $fileName)){
            return '/uploads/banners/'.$fileName;
        }
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
            $res = Banners::find($id);
            if($res){
                return response()->json(['success'=>true, 'data'=>$res]);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Danh mục đang tìm không tồn tại!']);
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
            $file = $request->file('image');
            if($file){
                $formData['path']= $this->upoadFile($file);
            }
            $res = Banners::find($id)->update($formData);
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
            $res = Banners::find($id)->delete();
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
