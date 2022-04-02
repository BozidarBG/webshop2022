@extends('layouts.admin')

@section('title', 'dashboard')

@section('styles')

@endsection

@section('content')
    <div class="col-3 mb-3">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Today's report</h3>
            </div>
            <div class="card-bodyv p-3">
                <p>New orders: {{$order_count_today}}</p>
                <p>Total new orders: {{formatPrice($order_total_today)}}</p>
            </div>
        </div>
    </div>

    <div class="col-3 mb-3">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Yesterday's report</h3>
            </div>
            <div class="card-bodyv p-3">
                <p>Orders count: {{$order_count_yesterday}}</p>
                <p>Total orders value: {{formatPrice($order_total_yesterday)}}</p>
            </div>
        </div>
    </div>

    <div class="col-3 mb-3">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">This month's report</h3>
            </div>
            <div class="card-bodyv p-3">
                <p>Orders count: {{$order_count_this_month}}</p>
                <p>Total orders value: {{formatPrice($order_total_this_month)}}</p>
            </div>
        </div>
    </div>

    <div class="col-3 mb-3">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Previous month's report</h3>
            </div>
            <div class="card-bodyv p-3">
                <p>Orders count: {{$order_count_last_month}}</p>
                <p>Total orders value: {{formatPrice($order_total_last_month)}}</p>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="card card-success">
            <div class="card-header">
                <h3 class="card-title">Total sales (in millions) for 2021</h3>
            </div>
            <div class="card-bodyv p-3">
                <canvas id="totalsChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>

    <div class="col-12 mb-3">
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Total orders count for 2021</h3>
            </div>
            <div class="card-bodyv p-3">
                <canvas id="ordersChart" width="400" height="150"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="{{asset('chart.js/Chart.min.js')}}"></script>
    <script>
class DashboardChart{
    constructor() {
        this.months_arr=[];
        this.totals_arr=[];
        this.order_count_arr=[];
        this.backend_data=null;
        this.getDataFromBackend();
    }

    getDataFromBackend(){
        axios.get('/admin/get-chart-data').then((data)=>{
            //console.log(data.data)
            this.backend_data=data.data;
            this.getMonths(data.data);
            this.showTotalsChart();
            this.showOrdersChart();
        });
    }

    getMonths(data){
        let data_arr=Object.entries(data)[0][1];
        for(let i=0; i<data_arr.length; i++){
            this.months_arr.push(data_arr[i].month);
            this.totals_arr.push(data_arr[i].total/100000000);
            this.order_count_arr.push(data_arr[i].order_count);

        }
    }

    showTotalsChart(){
        const ctx = document.getElementById('totalsChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                //labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                labels: this.months_arr,
                datasets: [{
                    label: '# total sale per month',
                    data: this.totals_arr,
                    backgroundColor: ['red', 'green', 'blue', 'purple', 'orange', 'brown','red', 'green', 'blue', 'purple', 'orange', 'brown' ],
                    borderColor: [],
                    borderWidth: 1,
                    barPercentage: 0.7,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                },

            }
        });
    }

    showOrdersChart(){
        const ctx = document.getElementById('ordersChart').getContext('2d');
        const myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: this.months_arr,
                datasets: [{
                    label: '# total orders count per month',
                    data: this.order_count_arr,
                    backgroundColor: ['red', 'green', 'blue', 'purple', 'orange', 'brown','red', 'green', 'blue', 'purple', 'orange', 'brown' ],
                    borderColor: [],
                    borderWidth: 1,
                    barPercentage: 0.7,
                }]
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
}



new DashboardChart();

    </script>
@endsection
