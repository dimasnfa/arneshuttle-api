<?php

namespace App\Http\Controllers;

use App\Models\SchedulePlan;
use Illuminate\Http\Request;
use Carbon\Carbon; 
use DB; 

class SchedulePlanController extends Controller
{
    public function index(Request $request)
    {
        //dd($request ->all());
        $contactDriver = $request->input('contact');
        $manifestCodes = $request->input('manifest');
        // dd($manifestCodes, $contactDriver, $request->user()->contact);
        
        $today = Carbon::today()->toDateString();
        // dd(now());
        
        // $schedulePlans = SchedulePlan::where('driver_data', 'LIKE', "%{$contactDriver}%")
        //     ->whereDate('created_at', 'like', '%'. $today .'%') 
        //     ->get();

        $penumpang = SchedulePlan::join('transaction_details', 'schedule_plans.trip_code', '=', 'transaction_details.tripcode')
        ->join('v_schedule_plans', 'schedule_plans.trip_code', '=', 'v_schedule_plans.original_tripcode')
        ->join('transactions','transactions.id', '=', 'transaction_details.transaction_id')
        ->join('outlets as a', 'transactions.depart', '=', 'a.code')
        ->join('outlets as b', 'transactions.arrival', '=', 'b.code')
        ->select('transaction_details.passenger_name','passenger_seat','passenger_ticket', 'a.name as asal', 'b.name as tujuan')
        ->where('schedule_plans.manifest_code', '=', $manifestCodes)
        ->get();

        $detailSchedule = SchedulePlan::select(
            'schedule_plans.trip_code',
            'v_schedule_plans.trip_code',
            'v_schedule_plans.original_tripcode',
            'v_schedule_plans.date',
            'v_schedule_plans.fuel',
            'v_schedule_plans.tol',
            'v_schedule_plans.driver_funds',
            'v_schedule_plans.additional_funds',
         )
        ->join('v_schedule_plans', 'schedule_plans.trip_code', 'v_schedule_plans.original_tripcode')
        ->where('schedule_plans.manifest_code', '=', $manifestCodes)
        ->first();

        $tripcode = $detailSchedule->trip_code;
        $part1 = substr($tripcode, 0, 3);
        $part2 = substr($tripcode, 3);
        $asal = DB::table('outlets')->select('outlets.name')->where('code', $part1)->first();
        $tujuan = DB::table('outlets')->select('outlets.name')->where('code', $part2)->first();

        
        // dd($tripcode, $part1, $part2, $asal, $tujuan);

        
        $packageTransaction = SchedulePlan::select('package_transaction_person.sender_phone as nomor_pengirim', 'package_transaction_person.sender_name as pengirim') 
        ->join('package_transaction', 'schedule_plans.trip_code', '=', 'package_transaction.trip_code',)
        ->join('package_transaction_person', 'package_transaction.id', '=', 'package_transaction_person.package_transaction_id',)
        ->select( 
        'package_transaction_person.recipient_phone', 
        'package_transaction_person.recipient_name', 
        'package_transaction_person.recipient_address',
        'package_transaction_person.sender_phone', 
        'package_transaction_person.sender_name', 
        'package_transaction_person.sender_address'
        )
        // ->join('v_schedule_plans', 'schedule_plans.trip_code', '=', 'v_schedule_plans.trip_code')
        // ->whereDate('v_schedule_plans.date', $today)
        // ->where('v_schedule_plans.etd', '>=', now())
        ->where('schedule_plans.manifest_code', '=', $manifestCodes)
        ->get();  

        // $data = DB::select("SELECT td.passenger_name FROM transaction_details as td join schedule_plans as sp on sp.trip_code = td.tripcode WHERE sp.manifest_code = 'MARNBTS2410171505'");
         
        return [
          'packageTransaction' => $packageTransaction,
          'detailSchedule' => $detailSchedule,
          'penumpang' => $penumpang,  
          'asal' => $asal,
          'tujuan' => $tujuan
        //   'data' => $data
       ];
    }

    public function history(Request $request)
    {
        //dd($request ->all());
        $contactDriver = $request->input('contact');
        $manifestCodes   = $request->input('manifest');
        
        $today = Carbon::today()->toDateString();

        $penumpang = SchedulePlan::join('transaction_details', 'schedule_plans.trip_code', '=', 'transaction_details.tripcode')
        ->select('schedule_plans.trip_code', 'transaction_details.tripcode', 'transaction_details.passenger_name')
        ->where('schedule_plans.driver_data', 'LIKE', $request->user()->contact)
        ->get(); 

        $detailSchedule = SchedulePlan::join('v_schedule_details', 'schedule_plans.trip_code', 'v_schedule_details.tripcode')
        ->select(
            'schedule_plans.trip_code',
            'v_schedule_details.tripcode',
            'v_schedule_details.depart',
            'v_schedule_details.arrival',
            'v_schedule_details.eta',
            'v_schedule_details.etd',
            'v_schedule_plans.original_tripcode',
            'v_schedule_plans.date',
            'v_schedule_plans.fuel',
            'v_schedule_plans.tol',
            'v_schedule_plans.driver_funds',
            'v_schedule_plans.additional_funds',
            'a.name as keberangkatan',
            'b.name as tujuan',
         )

        ->join('v_schedule_plans', 'schedule_plans.trip_code', 'v_schedule_plans.original_tripcode')
        ->join('outlets as a', 'v_schedule_details.depart', '=', 'a.code')
        ->join('outlets as b', 'v_schedule_details.arrival', '=', 'b.code')
        ->where('schedule_plans.driver_data', 'LIKE', "%{$contactDriver}%")
        ->get();


        $packageTransaction = SchedulePlan::where('schedule_plans.driver_data', 'LIKE', "%{$contactDriver}%")
        ->whereDate('schedule_plans.created_at', 'like', '%'. $today .'%')
        ->select('package_transaction_person.sender_phone as nomor_pengirim', ) 
        ->join('package_transaction', 'schedule_plans.trip_code', '=', 'package_transaction.trip_code')
        ->join('package_transaction_person', 'package_transaction.id', '=', 'package_transaction_person.package_transaction_id')
        ->get();
        
        return [
            'packageTransaction' => $packageTransaction,
            'detailSchedule' => $detailSchedule,
            'penumpang' => $penumpang,
       ];
    }

    public function manifest(Request $request)
    {
        $contactDriver = $request->input('contact');

        $manifestCodes = SchedulePlan::select('manifest_code')
            ->where('driver_data', 'LIKE', "%{$contactDriver}%")
            ->get();
 
        return $manifestCodes;
 
    }
  }   
  