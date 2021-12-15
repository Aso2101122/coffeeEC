var ctx = document.getElementById("myRadarChart");
var myRadarChart = new Chart(ctx, {
    //グラフの種類
    type: 'radar',
    //データの設定
    data: {
        //データ項目のラベル
        labels: ["苦味", "甘味", "酸味", "香り", "コク"],
        //データセット
        datasets: [
            {
                //グラフ全体のラベル
                label: "",
                //背景色
                backgroundColor: "rgba(174, 119, 2,1)",
                //枠線の色
                borderColor: "rgba(99, 68, 0,1)",
                //結合点の背景色
                pointBackgroundColor: "rgba(99, 68, 0,1)",
                //結合点の枠線の色
                pointBorderColor: "#fff",
                //結合点の背景色（ホバ時）
                pointHoverBackgroundColor: "#fff",
                //結合点の枠線の色（ホバー時）
                pointHoverBorderColor: "rgba(200,112,126,1)",
                //点の半径
                radius: 4,
                //結合点より外でマウスホバーを認識する範囲（ピクセル単位）
                hitRadius: 15,
                //グラフのデータ
                data: taste
            }
        ]
    },
    options: {
        title: {
            display: false,
        },
        // レスポンシブ指定
        responsive: true,
        scale: {
            pointLabels:{
                fontSize: 14
            },
            ticks: {
                // 最小値の値を0指定
                beginAtZero:true,
                min: 0,
                // 最大値を指定
                max: 5,
                // 目盛の間隔
                stepSize: 1,
                display: false
            }
        },
        //凡例設定
        legend: {
            //表示設定非表示
            display:false
        },
        //ツールチップ設定
        tooltips: {
                displayColors: false
        },
        layout: {                             //レイアウト
            padding: {                          //余白設定
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        },
        scaleLabel: {
            fontSize: 30
        }
    },
    // plugins: [dataLabelPlugin]
});

// // Define a plugin to provide data labels
// Chart.plugins.register({
//     afterDatasetsDraw: function (chart, easing) {
//         // To only draw at the end of animation, check for easing === 1
//         var ctx = chart.ctx;
//
//         chart.data.datasets.forEach(function (dataset, i) {
//             var meta = chart.getDatasetMeta(i);
//             if (!meta.hidden) {
//                 meta.data.forEach(function (element, index) {
//                     // Draw the text in black, with the specified font
//                     ctx.fillStyle = 'rgb(0, 0, 0)';
//
//                     var fontSize = 16;
//                     var fontStyle = 'normal';
//                     var fontFamily = 'Helvetica Neue';
//                     ctx.font = Chart.helpers.fontString(fontSize, fontStyle, fontFamily);
//
//                     // Just naively convert to string for now
//                     var dataString = dataset.data[index].toString();
//
//                     // Make sure alignment settings are correct
//                     ctx.textAlign = 'center';
//                     ctx.textBaseline = 'middle';
//
//                     var padding = 5;
//                     var position = element.tooltipPosition();
//                     ctx.fillText(dataString, position.x, position.y - (fontSize / 2) - padding);
//                 });
//             }
//         });
//     }
// });