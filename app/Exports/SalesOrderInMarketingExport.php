<?php

namespace App\Exports;

use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View as ViewView;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class SalesOrderInMarketingExport implements FromView, ShouldAutoSize
{
    use Exportable;
    private $query;
    private $request;
    private $fc_type;
    public function __construct($request){

        $this->request = $request;
        $this->fc_type = $request->fc_type;
        $startDate = empty($this->request->fd_sodatesysinput_start) ? null : date('Y-m-d H:i:s', strtotime($this->request->fd_sodatesysinput_start));
        $endDate = empty($this->request->fd_sodatesysinput_end) ? null : date('Y-m-d H:i:s', strtotime($this->request->fd_sodatesysinput_end));

        if($this->fc_type == 'STATUS'){
            $fc_sostatus = $this->request->fc_sostatus;
            ini_set('memory_limit', '2048M'); // 2GB
            set_time_limit(360);
            $this->query = DB::select("SELECT c.fc_divisioncode, 
                    b.fc_salescode, concat(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile ,
                    b.fc_membercode, concat(c.fc_membername1, ' ', c.fc_membername2) as membername,
                    concat(c.fc_memberaddress1, ' ', c.fc_memberaddress2) as memberaddress, 
                    c.fc_membertypebusiness, c.fc_member_branchtype,
                    b.fc_sotype, b.fd_sodatesysinput, b.fd_soexpired, a.fc_sono, fn_sodetail,s.fc_namelong,
                    case when b.fc_sostatus = 'CC' 
                        then 'SO CANCELED'
                        when b.fc_sostatus = 'C'
                        then 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                        when b.fc_sostatus = 'F'
                        then 'COMPLETED APPROVAL, WAITING DO'
                        when b.fc_sostatus = 'P'
                        then 'SO STILL PENDING OR PARTIALY INPUT'
                        when b.fc_sostatus = 'CL'
                        then 'SO CLOSED'
                        when b.fc_sostatus = 'DD'
                        then 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                        when b.fc_sostatus = 'WA'
                        then 'SO IS WAITING FOR APPROVAL'
                        when b.fc_sostatus = 'C'
                        then 'SO IS WAITING FOR APPROVAL'
                    end as status_so,       
                    a.fn_sorownum, a.fc_stockcode, 
                    a.fn_so_qty, a.fm_so_price, a.fn_so_value,
                    a.fn_do_qty, 
                    case when a.fn_so_qty = a.fn_do_qty then 'item complete'
                        when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty > 0)then 'item waiting for completion'
                        when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty = 0)then 'no progress item'
                    end as status_qty
            from t_sodtl a	   
            left outer join t_somst b on a.fc_sono = b.fc_sono
            left outer join t_customer c on b.fc_membercode = c.fc_membercode
            left outer join t_sales d on b.fc_salescode = d.fc_salescode 
            LEFT OUTER JOIN t_stock s ON a.fc_stockcode = s.fc_stockcode
            where (b.fd_sodatesysinput >= '$startDate')
            and (b.fd_sodatesysinput <= '$endDate')
            and (b.fc_sostatus = '$fc_sostatus')
            order by b.fc_membercode, b.fc_sotype, b.fc_sono, a.fn_sorownum");
        }else if($this->fc_type == 'CUSTOMER'){
            ini_set('memory_limit', '2048M'); // 2GB
            set_time_limit(360);
            $this->query = DB::select("SELECT c.fc_divisioncode, 
                    b.fc_salescode, concat(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile ,
                    b.fc_membercode, concat(c.fc_membername1, ' ', c.fc_membername2) as membername,
                    concat(c.fc_memberaddress1, ' ', c.fc_memberaddress2) as memberaddress, 
                    c.fc_membertypebusiness, c.fc_member_branchtype,
                    b.fc_sotype, b.fd_sodatesysinput, b.fd_soexpired, a.fc_sono, fn_sodetail,s.fc_namelong,
                    case when b.fc_sostatus = 'CC' 
                        then 'SO CANCELED'
                        when b.fc_sostatus = 'C'
                        then 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                        when b.fc_sostatus = 'F'
                        then 'COMPLETED APPROVAL, WAITING DO'
                        when b.fc_sostatus = 'P'
                        then 'SO STILL PENDING OR PARTIALY INPUT'
                        when b.fc_sostatus = 'CL'
                        then 'SO CLOSED'
                        when b.fc_sostatus = 'DD'
                        then 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                        when b.fc_sostatus = 'WA'
                        then 'SO IS WAITING FOR APPROVAL'
                        when b.fc_sostatus = 'C'
                        then 'SO IS WAITING FOR APPROVAL'
                    end as status_so,       
                    a.fn_sorownum, a.fc_stockcode, 
                    a.fn_so_qty, a.fm_so_price, a.fn_so_value,
                    a.fn_do_qty, 
                    case when a.fn_so_qty = a.fn_do_qty then 'item complete'
                        when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty > 0)then 'item waiting for completion'
                        when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty = 0)then 'no progress item'
                    end as status_qty
            from t_sodtl a	   
            left outer join t_somst b on a.fc_sono = b.fc_sono
            left outer join t_customer c on b.fc_membercode = c.fc_membercode
            left outer join t_sales d on b.fc_salescode = d.fc_salescode 
            LEFT OUTER JOIN t_stock s ON a.fc_stockcode = s.fc_stockcode
            WHERE (b.fd_sodatesysinput >= ?)
            AND (b.fd_sodatesysinput <= ?)
            and (b.fc_membercode = ?)
            ORDER BY b.fc_sostatus, b.fc_sotype, b.fc_sono, a.fn_sorownum", [$startDate, $endDate, $this->request->fc_membercode]);
        }else if($this->fc_type == 'SALES'){
            ini_set('memory_limit', '2048M'); // 2GB
            set_time_limit(360);
            $this->query = DB::select("SELECT c.fc_divisioncode, 
                    b.fc_salescode, concat(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile ,
                    b.fc_membercode, concat(c.fc_membername1, ' ', c.fc_membername2) as membername,
                    concat(c.fc_memberaddress1, ' ', c.fc_memberaddress2) as memberaddress, 
                    c.fc_membertypebusiness, c.fc_member_branchtype,
                    b.fc_sotype, b.fd_sodatesysinput, b.fd_soexpired, a.fc_sono, fn_sodetail,s.fc_namelong,
                    case when b.fc_sostatus = 'CC' 
                        then 'SO CANCELED'
                        when b.fc_sostatus = 'C'
                        then 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                        when b.fc_sostatus = 'F'
                        then 'COMPLETED APPROVAL, WAITING DO'
                        when b.fc_sostatus = 'P'
                        then 'SO STILL PENDING OR PARTIALY INPUT'
                        when b.fc_sostatus = 'CL'
                        then 'SO CLOSED'
                        when b.fc_sostatus = 'DD'
                        then 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                        when b.fc_sostatus = 'WA'
                        then 'SO IS WAITING FOR APPROVAL'
                        when b.fc_sostatus = 'C'
                        then 'SO IS WAITING FOR APPROVAL'
                    end as status_so,       
                    a.fn_sorownum, a.fc_stockcode, 
                    a.fn_so_qty, a.fm_so_price, a.fn_so_value,
                    a.fn_do_qty, 
                    case when a.fn_so_qty = a.fn_do_qty then 'item complete'
                        when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty > 0)then 'item waiting for completion'
                        when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty = 0)then 'no progress item'
                    end as status_qty
            from t_sodtl a	   
            left outer join t_somst b on a.fc_sono = b.fc_sono
            left outer join t_customer c on b.fc_membercode = c.fc_membercode
            left outer join t_sales d on b.fc_salescode = d.fc_salescode 
            LEFT OUTER JOIN t_stock s ON a.fc_stockcode = s.fc_stockcode
            where (b.fd_sodatesysinput >= ?)
            and (b.fd_sodatesysinput <= ?)
            and (d.fc_salescode  = ?)
            order by b.fc_membercode, b.fc_sotype, b.fc_sono, a.fn_sorownum", [$startDate, $endDate, $this->request->fc_salescode]);
        }else{
            ini_set('memory_limit', '2048M'); // 2GB
            set_time_limit(360);
            $this->query = DB::select("SELECT c.fc_divisioncode, 
                        b.fc_salescode, concat(d.fc_salesname1, ' [', d.fn_saleslevel, '] ') as sales_profile ,
                        b.fc_membercode, concat(c.fc_membername1, ' ', c.fc_membername2) as membername,
                        concat(c.fc_memberaddress1, ' ', c.fc_memberaddress2) as memberaddress, 
                        c.fc_membertypebusiness, c.fc_member_branchtype,
                        b.fc_sotype, b.fd_sodatesysinput, b.fd_soexpired, a.fc_sono, fn_sodetail,s.fc_namelong,
                        case when b.fc_sostatus = 'CC' 
                            then 'SO CANCELED'
                            when b.fc_sostatus = 'C'
                            then 'SO FINISHED, CHECK CUSTOMER PAYMENT'
                            when b.fc_sostatus = 'F'
                            then 'COMPLETED APPROVAL, WAITING DO'
                            when b.fc_sostatus = 'P'
                            then 'SO STILL PENDING OR PARTIALY INPUT'
                            when b.fc_sostatus = 'CL'
                            then 'SO CLOSED'
                            when b.fc_sostatus = 'DD'
                            then 'ALL ITEM HAVE BEEN PROCESSED FOR DELIVERY AND WAITING FOR INVOICING'
                            when b.fc_sostatus = 'WA'
                            then 'SO IS WAITING FOR APPROVAL'
                            when b.fc_sostatus = 'C'
                            then 'SO IS WAITING FOR APPROVAL'
                        end as status_so,       
                        a.fn_sorownum, a.fc_stockcode, 
                        a.fn_so_qty, a.fm_so_price, a.fn_so_value,
                        a.fn_do_qty, 
                        case when a.fn_so_qty = a.fn_do_qty then 'item complete'
                            when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty > 0)then 'item waiting for completion'
                            when (a.fn_so_qty > a.fn_do_qty) and (a.fn_do_qty = 0)then 'no progress item'
                        end as status_qty
                from t_sodtl a	   
                left outer join t_somst b on a.fc_sono = b.fc_sono
                left outer join t_customer c on b.fc_membercode = c.fc_membercode
                left outer join t_sales d on b.fc_salescode = d.fc_salescode
                LEFT OUTER JOIN t_stock s ON a.fc_stockcode = s.fc_stockcode
                where (b.fd_sodatesysinput >= '$startDate')
                and (b.fd_sodatesysinput <= '$endDate')
                order by b.fc_membercode, b.fc_sotype, b.fc_sono, a.fn_sorownum");
        }
    }

    public function view(): ViewView{
        return view('apps.excel.report_progress_sales',[
            'dataQuery' => $this->query,
        ]);
    }
}
