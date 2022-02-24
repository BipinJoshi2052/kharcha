<?php

namespace App\Http\Controllers;

use App\Models\Expense;

use Illuminate\Http\Request;

class KharchaController extends Controller
{
    public function index(){
        $users = [
            [
                'id' => 1,
                'name' => 'bipin'
            ],
            [
                'id' => 2,
                'name' => 'jewan'
            ],
            [
                'id' => 3,
                'name' => 'sandeep'
            ],
        ];

        $expenses = Expense::orderBy('id','desc')->get()->toArray();

        $final = [];
        $final2 = [];

        foreach ($users as $a => $item){
            $final2[$item['id']] = [];
            foreach ($users as $c => $i){
                if ($i['id'] != $item['id']){
                    $final2[$item['id']][$i['id']] = 0;
                }
            }
        }

        foreach($expenses as $a => $expense){
            $total_divide_by = 0;
            
            $divide_by = explode(',',$expense['others']);
            $total_divide_by = count($divide_by)+1; //1 is creator

            $amount = $expense['amount'];

            $per_person = $amount/$total_divide_by;

            foreach ($users as $a => $item){
                if ($expense['paid_by'] == $item['id']) {
                   $paid_by_name = $item['name'];
                }                
            }
            $others = [];
            foreach($divide_by as $a => $person_id){
                if(array_key_exists($person_id,$final2)){
                    if(array_key_exists($expense['paid_by'],$final2[$person_id])){
                        foreach ($users as $a => $item){
                            if ($person_id == $item['id']) {
                               $others[] = ucwords($item['name']);
                            }                
                        }
                        $final2[$person_id][$expense['paid_by']] = $final2[$person_id][$expense['paid_by']]+$per_person;
                    }
                    
                }
            }
            $single_expense = [
                'id' => $expense['id'],
                'paid_by' => $paid_by_name,
                'item' => $expense['item'],
                'others' => implode(',',$others),
                'amount' => $expense['amount'],
                'per_person' => $per_person,
                'date' => $expense['created_at'],
            ];
            array_push($final,$single_expense);
        }
        $expenses = $final;

        $final3 =  [];
        // dd($final2);

        foreach($final2 as $a => $b){            
            foreach($b as $c => $d){
                
                // $a = 1;
                // $c =2;

                $person12 = $final2[$a][$c];
                $person21 = $final2[$c][$a];

                // echo 'Person '. $a.$c .' '.$person12;
                // echo '<br>';
                // echo 'Person '. $c.$a .' '.$person21;
                // echo '<br>';
                // echo '<br>';
                // $person12 - $person21;

                if($person12 > $person21){
                    $final3[$a][$c] = ($person12 - $person21);
                }else{                    
                    $final3[$c][$a] = ($person21 - $person12);
                }

                // if($c != $a){
                    
                // }
            }
            // foreach(final2 as $c => $d){
            //     if($c != $a){

            //     }
            // }
        }
        // dd($final3);
        // dd($final2);
        return view('expense',compact('expenses','users','final2'));
    }

    public function add(Request $request){
        $expense = Expense::create(
            [
                
            'paid_by' => $request->paid_by,
            'others' => (isset($request->divide_to))?implode(',',$request->divide_to):null,
            'amount' => $request->amount,
            'item' => $request->item,
            ]

        );
        return redirect()->back()->with('success','Expense Added');
        dd($request->all());
    }
}
