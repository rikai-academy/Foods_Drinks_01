<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use App\Models\OrderProduct;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\OrderExport;
use App\Services\ManagerOrderService;
use DB;

class ManagerOrderController extends Controller
{
    protected $managerOrderService;

    public function __construct(ManagerOrderService $managerOrderService)
    {
        $this->managerOrderService = $managerOrderService;
    }

  public function index(ManagerOrderService $managerOrderService)
    {
        $data = $managerOrderService->getDatetime();
        $list_orders = Order::orderBy('id','desc')->get();
        return view('admin.order.index',$data,compact('list_orders'));
    }

    public function getOrderAllTime()
    {
        $data = Order::JoinUserSelectOrder()->orderBy('orders.id','desc')->paginate();
        return json_encode($data);
    }

    public function getOrderByDateTime(Request $request)
    {
        $data = Order::JoinUserSelectOrder()->ByDateTime($request->datetime)->orderBy('orders.id','desc')->paginate();
        return json_encode($data);
    }

    public function getOrderLastWeek(Request $request)
    {
        $data = Order::JoinUserSelectOrder()->LastWeek($request->start_week,$request->end_week)->orderBy('orders.id','desc')->paginate();
        return json_encode($data);
    }

    public function filterByDate(Request $request)
    {
        $inputDate1 = str_replace( substr( $request->inputDate1,  10, 1), " ", $request->inputDate1 );
        $inputDate2 = str_replace( substr( $request->inputDate2,  10, 1), " ", $request->inputDate2 );
        $data = Order::JoinUserSelectOrder()->filterByDate($inputDate1,$inputDate2)->orderBy('orders.id','desc')->paginate();
        return json_encode($data);
    }

    public function getOrderByStatus(Request $request)
    {
        $data = Order::JoinUserSelectOrder()->ByStatus($request->status_order)->orderBy('orders.id','desc')->paginate();
        return json_encode($data);
    }

    public function show($id_order)
    {
       $getOrderById = Order::ShowOrder($id_order)->first();
       return json_encode($getOrderById);
    }

    public function getListProductOrder($id_order)
    {
       $data = Product::JoinOrderProductAndImage()->SelectProductOrder()->WhereProductOrder($id_order)->paginate();
       return json_encode($data);
    }

    public function edit($id_oder)
    {
        return json_encode($id_oder);
    }

    public function update(Request $request, $id_oder)
    {
        Order::find($id_oder)->update($request->all());
        if($request->has('btn_confirm')){
            toast(__('custom.Confirm order successful'),'success');
            $message = __('custom.message_mail_order_confirm_success');
        }
        else{
            toast(__('custom.Cancel order successful'),'success');
            $message = __('custom.message_mail_order_confirm_fail');
        }

        # Send mail
        $this->managerOrderService->sendMailToUser($id_oder, $message);

        return redirect()->back();
    }

    public function destroy($id_order)
    {
        DB::beginTransaction();
        try {
            Order::destroy($id_order);
            DB::commit();
            alert()->success(__('custom.Notification'),__('custom.Delete Order successful'));

        }
        catch(Exception $ex){
            DB::rollBack();
            toast(__('custom.Delete Order failure'),'error');
        }
        return redirect()->back();
    }

    public function export(){
        return Excel::download(new OrderExport, 'order.xlsx');
    }
}
