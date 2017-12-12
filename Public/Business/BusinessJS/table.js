function polyline(other){
var dom = document.getElementById("main");
var myChart = echarts.init(dom);
var app = {};
option = null;
var symbolSize = 5;//圆点大小
var data = [];//模拟数据
var timeData = [];

$.each(other,function(key,value){
    data.push(value.total)
    timeData.push(date('Y-m-d',value.date))
})

var points = [];

option = {
        backgroundColor:{color:'#fff'},
        title: {
            text: '每天收藏用户',
            x: 'center'
        },
        tooltip: {
           trigger: 'axis',
           axisPointer: {
               animation: false
           }
       },
       legend: {
           x: 'left'
       },
        grid: {
            left: '3%',
            right: '8%',
            bottom: '3%',
            containLabel: true,
        },
        xAxis: {
            min: 0,
            max: 20,
            name:'日期',
            type: 'category',
            data:timeData,
            axisLine: {onZero: false}
        },
        yAxis: {
            // gridIndex: 1,
            name:'人数',
            type: 'value',
            axisLine: {onZero: false}
        },
        series: [
            {
            name:'人数',
            type:'line',
            symbolSize: 8,
            hoverAnimation: false,
                data: data
            }
        ],

};

/* var zr = myChart.getZr();


zr.on('click', function (params) {
    var pointInPixel = [params.offsetX, params.offsetY];
    var pointInGrid = myChart.convertFromPixel('grid', pointInPixel);

    if (myChart.containPixel('grid', pointInPixel)) {
        data.push(pointInGrid);

        myChart.setOption({
            series: [{
                id: 'a',
                data: data
            }]
        });
    }
});

zr.on('mousemove', function (params) {
    var pointInPixel = [params.offsetX, params.offsetY];
    zr.setCursorStyle(myChart.containPixel('grid', pointInPixel) ? 'copy' : 'default');
});
; */
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
}
function sexScale(boy,girl){
    var boy=boy;
    var girl=girl;
    var dom = document.getElementById("sexScale");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    app.title = '嵌套环形图';
    option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data:['男','女']
        },
        series: [
            {
                name:'男女比例',
                type:'pie',
                selectedMode: 'single',
                radius: [0, '30%'],

                label: {
                    normal: {
                        position: 'inner'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:[
                    {value:girl, name:'女'},
                    {value:boy, name:'男', selected:true}
                ]
            },
        ]
    };;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
}   

function ageScale(age){
    var dom = document.getElementById("ageScale");
    var myChart = echarts.init(dom);
    var app = {};
    option = null;
    app.title = '嵌套环形图';
    var age=age;
    var ageClass=[]
    var ageValue=[]
    var ageData=[]
    $.each(age,function(key,value){
        console.log(value)
        if(value!=0){
            ageClass.push(key);
            ageData.push({value:value})
        }
        
    })
    
    ageClass1=[]
    $.each(ageClass,function(key,value){
        ageClass1.push(value.split('_'));
    })
    $.each(ageClass1,function(key,value){
        console.log(ageClass1[key]);

        if(ageClass1[key][0]=='lt'){
            var keys='<'+ageClass1[key][1]+"岁"

            ageData[key].name=keys;
            ageClass1[key].push(keys);
        }else if(ageClass1[key][0]=='gt'){
            var keys='>'+ageClass1[key][1]+"岁"
            ageData[key].name=keys;
            ageClass1[key].push(keys);
        }else{
            var keys=ageClass1[key][0]+"到"+ageClass1[key][1]+"岁"
            ageData[key].name=keys;
            ageClass1[key].push(keys);
        }
    })
    console.log(ageData)
    option = {
        tooltip: {
            trigger: 'item',
            formatter: "{a} <br/>{b}: {c} ({d}%)"
        },
        legend: {
            orient: 'vertical',
            x: 'left',
            data:ageClass1
        },
        series: [
            {
                name:'年龄分布',
                type:'pie',
                selectedMode: 'single',
                radius: [0, '30%'],

                label: {
                    normal: {
                        position: 'inner'
                    }
                },
                labelLine: {
                    normal: {
                        show: false
                    }
                },
                data:ageData
            },
        ]
    };;
    if (option && typeof option === "object") {
        myChart.setOption(option, true);
    }
}
function areaDistributed(city){
    var dom = document.getElementById("areaDistributed");
    var city=city;
var myChart = echarts.init(dom);
var app = {};
option = null;
// var dataAxis = ['点', '击', '柱', '子', '或', '者', '两', '指', '在', '触', '屏', '上', '滑', '动', '能', '够', '自', '动', '缩', '放'];
// var data = [220, 182, 191, 234, 290, 330, 310, 123, 442, 321, 90, 149, 210, 122, 133, 334, 198, 123, 125, 220];
var dataAxis=[];
var data=[];
var yMax = 500;
$.each(city,function(key,value){
   
    dataAxis.push(city[key].name);
    data.push(city[key].total);
})

var dataShadow = [];

for (var i = 0; i < data.length; i++) {
    dataShadow.push(yMax);
}

option = {
    title: {
        text: '特性示例：渐变色 阴影 点击缩放',
        subtext: 'Feature Sample: Gradient Color, Shadow, Click Zoom'
    },
    xAxis: {
        data: dataAxis,
        axisLabel: {
            inside: true,
            textStyle: {
                color: '#fff'
            }
        },
        axisTick: {
            show: false
        },
        axisLine: {
            show: false
        },
        z: 10
    },
    yAxis: {
        axisLine: {
            show: false
        },
        axisTick: {
            show: false
        },
        axisLabel: {
            textStyle: {
                color: '#999'
            }
        }
    },
    dataZoom: [
        {
            type: 'inside'
        }
    ],
    series: [
        { // For shadow
            type: 'bar',
            itemStyle: {
                normal: {color: 'rgba(0,0,0,0.05)'}
            },
            barGap:'-100%',
            barCategoryGap:'40%',
            data: dataShadow,
            animation: false
        },
        {
            type: 'bar',
            itemStyle: {
                normal: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#83bff6'},
                            {offset: 0.5, color: '#188df0'},
                            {offset: 1, color: '#188df0'}
                        ]
                    )
                },
                emphasis: {
                    color: new echarts.graphic.LinearGradient(
                        0, 0, 0, 1,
                        [
                            {offset: 0, color: '#2378f7'},
                            {offset: 0.7, color: '#2378f7'},
                            {offset: 1, color: '#83bff6'}
                        ]
                    )
                }
            },
            data: data
        }
    ]
};

// Enable data zoom when user click bar.
var zoomSize = 6;
myChart.on('click', function (params) {
    console.log(dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)]);
    myChart.dispatchAction({
        type: 'dataZoom',
        startValue: dataAxis[Math.max(params.dataIndex - zoomSize / 2, 0)],
        endValue: dataAxis[Math.min(params.dataIndex + zoomSize / 2, data.length - 1)]
    });
});;
if (option && typeof option === "object") {
    myChart.setOption(option, true);
}
}