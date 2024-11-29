<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\admin\OptionsProduct;
use App\Services\QueryService;
use Illuminate\Http\Request;
use App\Models\admin\Orders;
use App\Models\admin\OrderMembers;
use App\Models\admin\OrderProducts;
use Illuminate\Support\Str;
use DB;
use GuzzleHttp\Client;

class OrderController extends Controller
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
            $search = $request->get('search', '');
            $betweenDate = $request->get('updated_at', []);
            $queryService = new QueryService(new Orders());
            $queryService->select = [];
            $queryService->filter = $filter;
            $queryService->columnSearch = 'order_code';
            $queryService->withRelationship = ['member','Detail','Detail.image','Detail.color'];
            $queryService->search = $search;
            $request->input('phone_number') && $queryService->searchRelationship = $request->input('phone_number');
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
    public function create(Request $request)
    {
        // 
        DB::beginTransaction();
        try{
            $formData = $request->post();
            $paramMember=[
                'name'=>$formData['Name'],
                'phone_number'=>$formData['PhoneNumber'],
                'email'=>$formData['Email'],
                'location_text'=>$formData['LocationText'],
                'province'=>$formData['Province'],
                'district'=>$formData['District'],
                'commune'=>$formData['Commune'],
                'note'=>$formData['Note'],
            ];
            $orderMember= new OrderMembers();
            $orderMember->fill($paramMember);
            $orderMember->save();


            $paramOrder=[
                'order_code'=> 'HADO-'.Str::random(32),
                'payment_methods'=>$formData['PaymentMethods'],
                'payment_status'=>1,
                'pack_status'=>1,
                'pack_status'=>1,
                'check_status'=>1,
                'id_member'=>$orderMember->id,
            ];

            $order= new Orders();
            $order->fill($paramOrder);
            $order->save();

            $paramOrderDetail=[];

            $dataCart = json_decode($formData['dataCart'],true);
            foreach ($dataCart as $index=> $value){
                $dataPayment = $value['payment'];
                $param =[
                    'product_id'=>$value['id'],
                    'product_name'=>$value['name'],
                    'product_color'=>$dataPayment['id_color'],
                    'product_size'=>$dataPayment['id_size'],
//                    'product_size'=>$dataPayment['size']['title'],
                    'quantity'=>$dataPayment['total'],
                    'price'=>$dataPayment['price'],
                    'price_total'=>$dataPayment['total'] * $dataPayment['price'],
                    'id_order'=>$order->id
                ];

                $checkQuantity = OptionsProduct::where([
                    ['id_product','=',$value['id']],
                    ['id_color','=',$dataPayment['id_color']],
//                    ['id_size','=',$dataPayment['id_size']]
                ])->first();

                if($dataPayment['total'] > $checkQuantity['total']){
                    DB::rollback();
                    return response()->json(['success'=>false, 'mess'=>'Sory, sản phẩm đã hết hàng, Vui lòng quay lại sau, hoặc liên hệ trực tiếp shop']);
                }else{
                    OptionsProduct::find($checkQuantity->id)->update([
                        'total'=> ($checkQuantity->total - $dataPayment['total'])
                    ]);;
                }
                array_push($paramOrderDetail,$param);
            }
            $orderProduct= new OrderProducts();
            $orderProduct->insert($paramOrderDetail);
            if($orderMember &&$order && $orderProduct){
                DB::commit();
                // $this->sendMessage();
                return response()->json(['success'=>true, 'mess'=>'Thêm mới thành công!','order_code'=>$order->order_code]);
            }else{
                return response()->json(['success'=>false, 'mess'=>'Thêm mới thất bại!']);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return $this->jsonError($e);
        }


    }

    public function sendMess(){
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://hooks.slack.com/services/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',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>'{
                "text": "Đã có đơn hàng được tạo",
                "channel": "C0541TD0TBP",
                "username": "HadoVN"
            }',
            CURLOPT_HTTPHEADER => array(
                'Content-type: application/json'
            ),
        ));

        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }

    public function sendMessage() { 
        // Set up the Guzzle client 
        $client = new Client(); 
        // Make a POST request to the Slack webhook URL with the message data 
        $response = $client->post('https://hooks.slack.com/services/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', 
            [ 'json' => [ 'text' => 'Don hang moi duoc tao']]); 
        // Check if the request was successful 
        if ($response->getStatusCode() == 200) { 
            return response()->json(['success' => true]); 
        } else { 
            return response()->json(['success' => false]); 
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
            $res = Orders::find($id)->update($formData);
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
            $res = Orders::find($id)->delete();
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
