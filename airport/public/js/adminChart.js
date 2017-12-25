//图表1，拆线图
var canalDataArr = ['403','702','403','702','1500','550','800','800'];
var week = [];
for (var i =0;i<canalDataArr.length;i++){
    week.push('第'+(i+1)+'周');
}
var progress = document.getElementById('animationProgress');
var config = {
    type: 'line',
    data: {
        labels: week,
        datasets: [{
            label: '每周用户数量(单位：人)',
            fill: false,
                   borderColor: 'green',
                   backgroundColor: 'green',
            data: canalDataArr
        }]
    },
    options: {
        title:{
            display:true,
            text: "萧山机场每周用户数量分析曲线表"
        }
    }
};

function chart1() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx, config);
}
chart1();

var areaDataArr = ['300','500','100','400','200'];
var config2 = {
    type: 'doughnut',
    data: {
        datasets: [{
            data: areaDataArr,
            backgroundColor: [
                '#db2828',
                'orange',
                'yellow',
                '#009A44',
                '#2185d0'
            ],
            label: 'Dataset 1'
        }],
        labels: [
            "杭州",
            "嘉兴",
            "宁波",
            "温州",
            "金华"
        ]
    },
    options: {
        responsive: true,
        legend: {
            position: 'top',
        },
        title: {
            display: true,
            text: '萧山机场用户分页饼状图'
        },
        animation: {
            animateScale: true,
            animateRotate: true
        }
    }
};

function chart2() {
    var ctx = document.getElementById("canvas2").getContext("2d");
    window.myDoughnut = new Chart(ctx, config2);
}
chart2();

// //获取php传递过来的json数据
// //var allData = $json_data ;
// //var canalData = $json_canal_week_pv_array;
// //var restaurantData = $restaurant_each_array;
// //hzShopData = $hz_shop_uv_array,jhShopData = $jh_shop_uv_array,
//
// var canalDataArr = [];
// for (var i = 0; i < canalData.length; i++) {
//     canalDataArr.push(canalData[i]["count(*)"]);
// }
// console.log(canalDataArr);
//
// //批量生成表格的函数
// function makeTable(elem, data) {
//     var table = document.createElement('table');
//     YU.addClassName(table, 'yu-table');
//     for (var i = 0; i < data.length; i++) {
//         var tr = document.createElement('tr');
//         for (var j = 0; j < data[0].length; j++) {
//             var td = document.createElement('td');
//             td.innerHTML = data[i][j];
//             tr.appendChild(td);
//         }
//         elem.appendChild(table).appendChild(tr);
//     }
// }
// //传递要插入表格的元素和数据
// makeTable(YU.$('redBox'), allData['red']);
// makeTable(YU.$('canalBox'), allData['canal']);
// makeTable(YU.$('restaurantBox'), allData['restaurant']);
//
// //图表1，游船竞技
// var week = [];
// for (var i =0;i<canalDataArr.length;i++){
//     week.push('第'+(i+1)+'周');
// }
// //    var MONTHS = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
// var progress = document.getElementById('animationProgress');
// var config = {
//     type: 'line',
//     data: {
//         labels: week,
//         datasets: [{
//             label: ' 每周 PV总量',
//             fill: false,
//             borderColor: window.chartColors.red,
//             backgroundColor: window.chartColors.red,
//             data: canalDataArr
//         }]
//     },
//     options: {
//         title:{
//             display:true,
//             text: "大运河天下和游船竞技游戏每周pv量曲线表"
//         }
//     }
// };
//
// function chart1() {
//     var ctx = document.getElementById("canvas").getContext("2d");
//     window.myLine = new Chart(ctx, config);
// }
// chart1();
//
//
// console.log(window.Chart.prototype);
//
//
// //图表2，喜从天降
// console.log(restaurantData);
// var restaurantName = [],restaurantPv = [];
// for (var i=0;i<restaurantData.length;i++){
//     restaurantName.push(restaurantData[i]['nickname']);
//     restaurantPv.push(restaurantData[i]['counts']);
// }
//
// var barChartData = {
//     labels: restaurantName,
//     datasets: [{
//         label: '单店PV总量',
//         backgroundColor: [
//             window.chartColors.red,
//             window.chartColors.orange,
//             window.chartColors.yellow,
//             window.chartColors.green,
//             window.chartColors.blue,
//             window.chartColors.purple,
//             window.chartColors.red,
//             window.chartColors.red,
//             window.chartColors.orange,
//             window.chartColors.yellow
//         ],
//         yAxisID: "y-axis-1",
//         data: restaurantPv
//     }]
//
// };
// function chart2(){
//     var ctx2 = document.getElementById("canvas2").getContext("2d");
//     window.myBar = new Chart(ctx2, {
//         type: 'bar',
//         data: barChartData,
//         options: {
//             responsive: true,
//             title:{
//                 display:true,
//                 text:"喜从天降每家餐厅消费者参与的PV总量"
//             },
//             tooltips: {
//                 mode: 'index',
//                 intersect: true
//             },
//             scales: {
//                 yAxes: [{
//                     type: "linear", // only linear but allow scale type registration. This allows extensions to exist solely for log scale for instance
//                     display: true,
//                     position: "left",
//                     id: "y-axis-1"
//                 }]
//             }
//         }
//     });
// }
// chart2();
//
//
//
//
// //图表3，红包活动
// var hzShop = [[],[]],jhShop = [[],[]];
// for (var i=0;i<hzShopData.length;i++){
//     hzShop[0].push(hzShopData[i]['shop_name']);
//     hzShop[1].push(hzShopData[i]['counts']);
// }
// for (var i=0;i<jhShopData.length;i++){
//     jhShop[0].push(jhShopData[i]['shop_name']);
//     jhShop[1].push(jhShopData[i]['counts']);
// }
// makeTable(YU.$('hzBox'), hzShop);
// makeTable(YU.$('jhBox'), jhShop);
