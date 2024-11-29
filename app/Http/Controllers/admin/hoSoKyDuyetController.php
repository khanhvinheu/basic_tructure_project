<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\hoSoKyDuyets;

class hoSoKyDuyetController extends Controller
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
            $SortField='id';
            $SortType='DESC';
            @$formData['SortType']&&$SortType=@$formData['SortType']==1?'DESC':'ASC';
            @$formData['SortField']&&$SortField=@$formData['SortField'];
            @$formData['Column']&&$Column=@$formData['Column'];
            @$formData['PageLimit']&&$PageLimit=@$formData['PageLimit'];
            @$formData['Page']&&$Page=@$formData['Page'];
            $query=[];
            if(@$formData['TextSearch']){
                array_push($query,['thoiGianCap', 'LIKE' , "%" . @$formData['TextSearch'] . "%"]);
            }
            if(@$formData['Hidden']){
                array_push($query,['Hidden', @$formData['Hidden']]);
            }
            $res = hoSoKyDuyets::where($query)
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
            $res = hoSoKyDuyets::create($formData);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        try{
            $res = hoSoKyDuyets::find($id);
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
            $res = hoSoKyDuyets::find($id)->update($formData);
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
            $res = hoSoKyDuyets::find($id)->delete();
            if($res){
                return response()->json(['success'=>true, 'mess'=>'Xóa dữ liệu thành công!']);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Xóa dữ liệu thất bại!']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }
    }

    public function genCode(){
        $lastCode = hoSoKyDuyets::orderBy('maDot', 'desc')->first(); // lấy mã cuối cùng trong database      
        if (!$lastCode) {
            $number = 1;
        } else {
            $number = intval(substr($lastCode->maDot, -3)) + 1; // lấy số cuối cùng của mã và tăng giá trị lên 1
        }    
        $newCode = 'DC' . str_pad($number, 4, '0', STR_PAD_LEFT); // tạo mã mới dựa trên số đó và định dạng "ABCXXX"
        return $newCode;
    }
}
