<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\admin\danhSachCapChungChiHocViens;
use App\Models\admin\hoSoKyDuyets;
use App\Services\QueryService;
use Illuminate\Support\Str;
use File;
use Carbon\Carbon;

class danhSachCapChungChiHocVienController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //
        try {
            $filter=[];
            $request->input('pack_status')&& array_push($filter,['pack_status','=',$request->input('pack_status')]);
            $limit = $request->get('limit', 25);
            $ascending = (int) $request->get('ascending', 0);
            $orderBy = $request->get('orderBy', '');
            $search = $request->get('TextSearch', '');
            $columnSearch = $request->get('columnSearch', ['hoTen','maChungChi']);
            $betweenDate = $request->get('updated_at', []);
            $queryService = new QueryService(new danhSachCapChungChiHocViens());
            $queryService->select = [];
            $queryService->filter = $filter;
            $queryService->columnSearch =$columnSearch;
            $queryService->withRelationship = ['dotCap','khoaHoc','hoSoDuyet','hoSoDuyet.nguoiKyDuyet'];
            $queryService->search = $search;
            $queryService->betweenDate = $betweenDate;
            $queryService->limit = $limit;
            $queryService->ascending = $ascending;
            $queryService->orderBy = $orderBy;
            $query = $queryService->queryTable();
            $query = $query->paginate($limit);
            $product = $query->toArray();
            return $this->jsonTable($product);
        } catch (\Exception $e) {
            return $this->jsonError($e);
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
            $file = $request->file('file0');
            if($file){
                $formData['image']= $this->upload($file);
            }     
            $res = danhSachCapChungChiHocViens::create($formData);
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
        try{            
            $res = danhSachCapChungChiHocViens::where('id', $id)
            ->with('dotCap')
            ->with('khoaHoc')
            ->with('hoSoDuyet')
            ->first();            
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
            $file = $request->file('file0');
            if($file){
                $formData['image']= $this->upload($file);
            }
            if(@$formData['image']=='null'){                
                $formData['image']='';
            }       
            if (@$formData['delete_image']) {              
                if(file_exists((public_path($formData['delete_image'])))){
                    File::delete(public_path($formData['delete_image']));
                }
            }     
                    
            $res = danhSachCapChungChiHocViens::find($id)->update($formData);
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
            $res = danhSachCapChungChiHocViens::find($id)->delete();
            if($res){
                return response()->json(['success'=>true, 'mess'=>'Xóa dữ liệu thành công!']);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Xóa dữ liệu thất bại!']);
            }
        }catch(\Exception $e){
            return response()->json(['success'=>false, 'mess'=>$e]);
        }
    }

    public function upload($file){
        $randomString = Str::random(10); 
        $fileName ='anh34'.explode('.',$file->getClientOriginalName())[0].time().$randomString.'.'.$file->extension();
        if($file->move(public_path('uploads/anh34'), $fileName)){
            return '/uploads/anh34/'.$fileName;
        }
    }

    public function genCode(){
        $lastCode = danhSachCapChungChiHocViens::orderBy('maChungChi', 'desc')->first(); // lấy mã cuối cùng trong database      
        if (!$lastCode) {
            $number = 1;
        } else {
            $number = intval(substr($lastCode->maChungChi, -3)) + 1; // lấy số cuối cùng của mã và tăng giá trị lên 1
        }    
        $newCode = '' . str_pad($number, 5, '0', STR_PAD_LEFT); // tạo mã mới dựa trên số đó và định dạng "ABCXXX"
        return $newCode;
    }

    public function genCodeSoVaoSo(){
        $lastCode = hoSoKyDuyets::orderBy('maHoSo', 'desc')->first(); // lấy mã cuối cùng trong database      
        if (!$lastCode) {
            $number = 1;
        } else {
            $number = intval(substr($lastCode->maHoSo, -3)) + 1; // lấy số cuối cùng của mã và tăng giá trị lên 1
        }  
        $yearNow =  Carbon::now()->year;  
        $newCode = $yearNow.'/ĐT' . str_pad($number, 4, '0', STR_PAD_LEFT); // tạo mã mới dựa trên số đó và định dạng "ABCXXX"
        return $newCode;
    }
    public function kyDuyet(Request $request, $id){            
        $formData=$request->input();       
        $dataFind= hoSoKyDuyets::where('maHoSo', $id)->first();      
        $formDataUpdate=[
            "maHoSoKyDuyet"=>''
        ]; 
        if(!$dataFind){
            $resHS = hoSoKyDuyets::create($formData);
            $resHS &&  $formDataUpdate['maHoSoKyDuyet']= $resHS->maHoSo;            
        }else{        
            $idHoSo = $dataFind->toArray();    
            $formDataUpdate['maHoSoKyDuyet']=$idHoSo['maHoSo'];
        }          

        $res = danhSachCapChungChiHocViens::find($id)->update($formDataUpdate);
        if($res){
            return response()->json(['success'=>true, 'mess'=>'Cập nhật dữ liệu thành công']);
        }else{
            return response()->json(['success'=>false, 'mess'=>'Cập nhật thất bại!']);
        }
    }


}
