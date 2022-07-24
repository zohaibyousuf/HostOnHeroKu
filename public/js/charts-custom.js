/*global $, document, LINECHARTEXMPLE*/
$(document).ready(function () {

    'use strict';

    var brandPrimary = 'rgba(51, 179, 90, 1)';

    var LINECHARTEXMPLE   = $('#lineChartExample'),
        PIECHARTEXMPLE    = $('#pieChartExample'),
        BARCHARTEXMPLE    = $('#barChartExample'),
        RADARCHARTEXMPLE  = $('#radarChartExample'),
        POLARCHARTEXMPLE  = $('#polarChartExample');

    var SALECHART    = $('#saleChart');

    if (SALECHART.length > 0) {
        var yearly_sale_amount = SALECHART.data('sale_chart_value');
        var yearly_purchase_amount = SALECHART.data('purchase_chart_value');

        var saleChart = new Chart(SALECHART, {
            type: 'line',
            data: {
                labels: ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"],
                datasets: [
                    {
                        label: "Purchase Amount",
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: "rgba(51, 179, 90, 0.38)",
                        borderColor: brandPrimary,
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 1,
                        pointBorderColor: brandPrimary,
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: brandPrimary,
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [ yearly_purchase_amount[0], yearly_purchase_amount[1],
                                yearly_purchase_amount[2], yearly_purchase_amount[3],
                                yearly_purchase_amount[4], yearly_purchase_amount[5],
                                yearly_purchase_amount[6], yearly_purchase_amount[7],
                                yearly_purchase_amount[8], yearly_purchase_amount[9],
                                yearly_purchase_amount[10], yearly_purchase_amount[11] ],
                        spanGaps: false
                    },
                    {
                        label: "Sale Amount",
                        fill: true,
                        lineTension: 0.3,
                        backgroundColor: "rgba(75,192,192,0.4)",
                        borderColor: "rgba(75,192,192,1)",
                        borderCapStyle: 'butt',
                        borderDash: [],
                        borderDashOffset: 0.0,
                        borderJoinStyle: 'miter',
                        borderWidth: 1,
                        pointBorderColor: "rgba(75,192,192,1)",
                        pointBackgroundColor: "#fff",
                        pointBorderWidth: 1,
                        pointHoverRadius: 5,
                        pointHoverBackgroundColor: "rgba(75,192,192,1)",
                        pointHoverBorderColor: "rgba(220,220,220,1)",
                        pointHoverBorderWidth: 2,
                        pointRadius: 1,
                        pointHitRadius: 10,
                        data: [ yearly_sale_amount[0], yearly_sale_amount[1],
                                yearly_sale_amount[2], yearly_sale_amount[3],
                                yearly_sale_amount[4], yearly_sale_amount[5],
                                yearly_sale_amount[6], yearly_sale_amount[7],
                                yearly_sale_amount[8], yearly_sale_amount[9],
                                yearly_sale_amount[10], yearly_sale_amount[11] ],
                        spanGaps: false
                    }
                ]
            }
        });
    }

    var pieChartExample = new Chart(PIECHARTEXMPLE, {
        type: 'doughnut',
        data: {
            labels: [
                "First",
                "Second",
                "Third"
            ],
            datasets: [
                {
                    data: [300, 50, 100],
                    borderWidth: [1, 1, 1],
                    backgroundColor: [
                        brandPrimary,
                        "rgba(75,192,192,1)",
                        "#FFCE56"
                    ],
                    hoverBackgroundColor: [
                        brandPrimary,
                        "rgba(75,192,192,1)",
                        "#FFCE56"
                    ]
                }]
            }
    });

    var pieChartExample = {
        responsive: true
    };

    var BESTSELLER    = $('#bestSeller');
    if (BESTSELLER.length > 0) {
        var sold_qty = BESTSELLER.data('sold_qty');
        var product_info = BESTSELLER.data('product');
        var bestSeller = new Chart(BESTSELLER, {
            type: 'bar',
            data: {
                labels: [ product_info[0], product_info[1], product_info[2]],
                datasets: [
                    {
                        label: "Sale Qty",
                        backgroundColor: [
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)',
                            'rgba(51, 179, 90, 0.6)'
                        ],
                        borderColor: [
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)',
                            'rgba(51, 179, 90, 1)'
                        ],
                        borderWidth: 1,
                        data: [ 
                                sold_qty[0], sold_qty[1],
                                sold_qty[2], 0],
                    }
                ]
            }
        });
    }

    var polarChartExample = new Chart(POLARCHARTEXMPLE, {
        type: 'polarArea',
        data: {
            datasets: [{
                data: [
                    11,
                    16,
                    7
                ],
                backgroundColor: [
                    "rgba(51, 179, 90, 1)",
                    "#FF6384",
                    "#FFCE56"
                ],
                label: 'My dataset' // for legend
            }],
            labels: [
                "First",
                "Second",
                "Third"
            ]
        }
    });

    var polarChartExample = {
        responsive: true
    };


    var radarChartExample = new Chart(RADARCHARTEXMPLE, {
        type: 'radar',
        data: {
            labels: ["Eating", "Drinking", "Sleeping", "Designing", "Coding", "Cycling"],
            datasets: [
                {
                    label: "My First dataset",
                    backgroundColor: "rgba(179,181,198,0.2)",
                    borderWidth: 2,
                    borderColor: "rgba(179,181,198,1)",
                    pointBackgroundColor: "rgba(179,181,198,1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(179,181,198,1)",
                    data: [65, 59, 90, 81, 56, 55]
                },
                {
                    label: "My Second dataset",
                    backgroundColor: "rgba(51, 179, 90, 0.2)",
                    borderWidth: 2,
                    borderColor: "rgba(51, 179, 90, 1)",
                    pointBackgroundColor: "rgba(51, 179, 90, 1)",
                    pointBorderColor: "#fff",
                    pointHoverBackgroundColor: "#fff",
                    pointHoverBorderColor: "rgba(51, 179, 90, 1)",
                    data: [28, 48, 40, 19, 96, 27]
                }
            ]
        }
    });
    var radarChartExample = {
        responsive: true
    };



});
