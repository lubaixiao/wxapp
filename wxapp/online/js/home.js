$(document).ready(function () {
    var ctx = document.getElementById("myChart");
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ["文章总数", "文章发布数", "文章待审核数", "视频总数", "视频发布数", "视频待审核数", "微信接口发问量"],
            datasets: [
                {
                    label: "信息柱形图",
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(113, 90, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255,99,132,1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(99, 102, 75, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1,
                    data: [100, 80, 20, 10, 8, 2, 1000]
                }
            ]
        },
        options: {
            scales: {
                xAxes: [{
                        stacked: false
                    }],
                yAxes: [{
                        stacked: false
                    }]
            }
        }
    });
    var ctx = document.getElementById("myChart2");
    new Chart(ctx, {
        type: "radar",
        data: {
            labels: ["公共必修", "公共选修", "社会实践", "专业必修", "专业选修", "实训项目", "毕业设计"],
            datasets: [
                {
                    label: "我的学分",
                    backgroundColor: "rgba(179,181,198,0.2)",
                    borderColor: "rgba(179,181,198,1)",
                    pointBackgroundColor: "rgba(179,181,198,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(179,181,198,1)",
                    data: [65, 59, 90, 81, 56, 55, 40]
                },
                {
                    label: "毕业标准学分",
                    backgroundColor: "rgba(255,99,132,0.2)",
                    borderColor: "rgba(255,99,132,1)",
                    pointBackgroundColor: "rgba(255,99,132,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(255,99,132,1)",
                    data: [65, 58, 90, 81, 56, 55, 50]
                }
            ]
        },
        options: {
            scale: {
                reverse: false,
                ticks: {
                    beginAtZero: true
                }
            }
        }
    });
});
