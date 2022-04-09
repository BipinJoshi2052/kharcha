<html lang="en">
    <head>
    <title>Kharcha</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script> -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <style>
        form{
            padding: 15px 20px 15px 20px;
            box-shadow: 0 1px 2.94px 0.06px rgb(4 26 55 / 16%);
            background: linear-gradient(to bottom, #33ccff 0%, #ff99cc 100%);
            border-radius: 2%;
        }
        .card{
            border: none;
        }
        .card-body{
            /* border: 2px solid #61abff; */
            background: linear-gradient(to top right, #33ccff 0%, #ff99cc 100%);
            box-shadow:  linear-gradient(to bottom, #ff99cc 0%, #ff99cc 100%);
        }
        table th{
            background: linear-gradient(to top, #33ccff 0%, #ff99cc 100%);
        }
    </style>
    </head>
    <body>
        <div class="container mt-5">
            <div class="row">
            <div class="col-md-12 col-lg-5">
                <form method="POST" action="{{route('kharcha-add')}}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="select"><strong>Paid By</strong> </label>
                        <select required name="paid_by" class="form-control" id="select">
                            @foreach ($users as $a => $item)
                              <option value="{{$item['id']}}">{{ucwords($item['name'])}}</option>                                      
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="amount"><strong>Amount</strong></label>
                        <input required name="amount" type="number" class="form-control" id="amount" Placeholder="Amount">
                    </div>
                    <div class="form-group">
                        <label for="item"><strong>Item</strong></label>
                        <input required name="item" type="text" class="form-control" id="item" Placeholder="Item">
                    </div>
                    <div class="form-group">
                        <label><strong>Divide To</strong></label>
                        @foreach ($users as $a => $item)
                            <div class="form-check">
                                <input name="divide_to[]" class="form-check-input" type="checkbox" value="{{$item['id']}}" id="flexCheckDefault-{{$a}}">
                                <label class="form-check-label" for="flexCheckDefault-{{$a}}">
                                    {{ucwords($item['name'])}}
                                </label>
                            </div>                           
                        @endforeach
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                </form>
            </div> 
            <div class="col-md-12 col-lg-7">
                <div class="row">     
                    @foreach ($users as $a => $item)      
                        <div class="card col-md-12 col-lg-6 mt-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ucwords($item['name'])}}   to</h5>
                                @foreach ($users as $c => $i)
                                    @if ($i['id'] != $item['id'])                                    
                                        <h6 class="card-subtitle mb-2 text-muted">{{ucwords($i['name'])}} : {{$final2[$item['id']][$i['id']]}}</h6>
                                    @endif                         
                                @endforeach
                            </div>
                        </div>                                  
                    @endforeach
                </div>
            </div>
            </div>  
        
        <br>

        <table class="table table-bordered">
        <thead>
            <tr>
                <th width="10px">SN</th>
                <th width="10px">Paid By</th>
                <th width="40px">Divisible To</th>
                <th>Item</th>
                <th width="10px">Amount</th>
                <th >Per Person</th>
                <th >Date</th>
            </tr>
        </thead>
        <tbody>
            @php
                $total=0;
            @endphp
            @foreach ($expenses as $b => $expense)
                @php
                    $total = $total+$expense['amount'];
                @endphp
                <tr class="success">
                    <th>{{$b+1}}</th>
                    <td>{{ucwords($expense['paid_by'])}}</td>
                    <td>{{$expense['others']}}</td>
                    <td>{{ucwords($expense['item'])}}</td>
                    <td>{{$expense['amount']}}</td>
                    <td>{{$expense['per_person']}}</td>
                    <td>{{date('D ,d M ,Y',strtotime($expense['date']))}}</td>
                </tr>
            @endforeach
        </tbody>
        </table>
        
        </div>
    </body>
</html>