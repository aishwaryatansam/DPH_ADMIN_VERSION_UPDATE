<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Excel;
use Illuminate\Contracts\Support\Responsable;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;

use Date,DateTime;

class OrdersExport implements FromQuery,WithMapping, WithHeadings
{
     use Exportable;


    private $writerType = Excel::CSV;
    
    private $headers = [
        'Content-Type' => 'text/csv',
    ];

    public function query()
    {       
        return Order::getExportQueriedResult();
    }

    public function headings(): array
    {
        return [
            
            'Order Id',
            'Order Date',
            'Session',
            'Session Code',
            'Item',
            'Quantity',
            'Quantity Type',
            'Unit Price',
            'Quantity Price',   
            'Total Order Amount',         
            'Customer Name',     
            'Customer Contact',                 
            'Payment Status',     
            'Payment Id',                 
        ];
    }
    
    /**
    * @return \Illuminate\Support\Collection
    */   
    public function map($order): array
    {	
        $return = array();
        foreach ($order->orderItems as $key => $Items) {
            $return[] = [
                $order->order_unique_id,            
                \Carbon\Carbon::parse($order->order_date)->format('d/m/Y'),
                $order->sessionMenu->sessionType->type_name ?? 'Not Found',
                $order->sessionMenu->session_code ?? 'Not Found',
                $Items->item->name,
                $Items->quantity,
                $Items->quantityType->name,
                $Items->amount_per_item,
                $Items->total_amount,
                $order->total_amount,
                $order->customer->name,
                $order->customer->contact_number,
                !empty($order->payment)?'Paid':'Pending',
                !empty($order->payment)?$order->payment->payment_unique_id:'--',                
            ]; 
        }

        return $return;
    	   	  
    }
}
