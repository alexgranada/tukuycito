(function ($) {
    "use strict";
//------------------------------------------------------------------------------------------------------------------
// Sales Analytics Chart
//------------------------------------------------------------------------------------------------------------------

if($('#saleAnalytics').length) {
  var saleAnalyticsoptions = {
      series: [{
          name: 'Stock',
          color: '#3836f3',
          data: [31, 40, 28, 51, 42, 109, 100]
      }, {
          name: 'Order',
          color: '#FFC500',
          data: [11, 32, 45, 32, 34, 52, 41]
      }],
      chart: {
          height: 400,
          type: 'area',
          toolbar: {
              show: false
          },
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          width: 1,
          curve: 'smooth'
      },
      xaxis: {
          fill: '#4c5258',
          type: 'datetime',
          categories: ["2024-12-19T00:00:00.000Z", "2024-12-20T00:00:00.000Z", "2024-12-21T00:00:00.000Z", "2024-12-22T00:00:00.000Z", "2024-12-23T00:00:00.000Z", "2024-12-24T00:00:00.000Z", "2024-12-25T00:00:00.000Z"],
          labels: {
              format: 'dddd',
              style: {
                  colors: '#747474',
                  fontSize: '12px',
                  fontWeight: 400,
              },
          },
          axisBorder: {
              show: false,
          },
          axisTicks: {
              show: false,
          },
      },
      yaxis: {
          labels: {
          style: {
            colors: '#747474',
            fontSize: '12px',
            fontWeight: 400,
            
          },
        },
      },
      grid: {
          borderColor: '#eee',
          strokeDashArray: 2,
          xaxis: {
              lines: {
                  show: true,
              }
          },
          padding: {
              bottom: 15
          }
      },
      responsive: [{
          breakpoint: 479,
          options: {
              chart: {
                  height: 250,
              },
          },
      }]
  };
  var saleAnalytics = new ApexCharts(document.querySelector("#saleAnalytics"), saleAnalyticsoptions);
  saleAnalytics.render();
}
//------------------------------------------------------------------------------------------------------------------
// reniview-status
//------------------------------------------------------------------------------------------------------------------

if($('#revenue').length) {
  var revenueoptions = {
    series: [{
    color: '#3836f3',
    name: 'Session Duration',
    data: [420, 550, 850, 220, 650, 700, 140, 550, 920, 410, 200, 600]
  }, {
    color: '#FFC500',
    name: 'Total Visit',
    data: [170, 850, 101, 90, 250, 300, 130, 580, 120, 440, 900, 690]
  }],
    chart: {
    type: 'bar',
    height: 350,
    toolbar: {
      show: false
    }
  },
  plotOptions: {
    bar: {
      horizontal: false,
      columnWidth: '70%',
      endingShape: 'rounded'
    },
  },
  dataLabels: {
    enabled: false
  },
  legend: {
      show: true,
      fontSize: '12px',
      fontWeight: 300,
      
      labels: {
          colors: '#747474',
      },
      position: 'bottom',
      horizontalAlign: 'center', 	
  },
  yaxis: {
      labels: {
      style: {
        colors: '#747474',
        fontSize: '12px',
        fontWeight: 400,
        
      },
    },
  },
  stroke: {
    show: true,
    width: 2,
    colors: ['transparent']
  },
  xaxis: {
      fill: '#4c5258',
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      labels: {
          style: {
              colors: '#747474',
              fontSize: '12px',
              fontWeight: 400,
          },
      },
  },
  fill: {
    colors:['#eee'],
  },
  };

  var chart = new ApexCharts(document.querySelector("#revenue"), revenueoptions);
  chart.render();
}

    
//------------------------------------------------------------------------------------------------------------------
// total-earning
//------------------------------------------------------------------------------------------------------------------
if($('#earning').length) {
    var earningoptions = {
        series: [{
        data: [20, 100, 40, 30, 50, 80, 33],
        colors: ['#3836f3'],
      }],
        chart: {
        height: 350,
        type: 'radar',
      },
      dataLabels: {
        enabled: true
      },
      plotOptions: {
        radar: {
          size: 140,
          polygons: {
            strokeColors: '#3836f3',
            fill: {
              colors: ['#ffffff', '#ffffff']
            }
          }
        }
      },
      markers: {
        size: 4,
        colors: ['#ffffff'],
        strokeColor: '#3836f3',
        strokeWidth: 2,
      },
      tooltip: {
        y: {
          formatter: function (val) {
            return "$ " + val + " thousands"
          }
        }
      },
      xaxis: {
        categories: ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'],
        labels: {
            style: {
                fontSize: '12px',
                fontWeight: 500,
            },
        },
      },
      yaxis: {
        tickAmount: 7,
        labels: {
          formatter: function(val, i) {
            if (i % 2 === 0) {
              return val
            } else {
              return ''
            }
          },
          style: {
            colors: '#3836f3',
            fontSize: '12px',
            fontWeight: 400,
        },
        }
      }
      };

      var chart = new ApexCharts(document.querySelector("#earning"), earningoptions);
      chart.render();
}


//------------------------------------------------------------------------------------------------------------------
// chart1
//------------------------------------------------------------------------------------------------------------------
if($('#chart1').length) {
	var e = {
		series: [{
			name: "Customers",
			data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
		}],
		chart: {
			type: "line",
			height: 65,
			toolbar: {
				show: !1
			},
			zoom: {
				enabled: !1
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .12,
				color: "#3836f3"
			},
			sparkline: {
				enabled: !0
			}
		},
		markers: {
			size: 0,
			colors: ["#3836f3"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 3,
			curve: "smooth"
		},
		colors: ["#3836f3"],
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			theme: "dark",
			fixed: {
				enabled: !1
			},
			x: {
				show: !1
			},
			y: {
				title: {
					formatter: function(e) {
						return ""
					}
				}
			},
			marker: {
				show: !1
			}
		}
	};

  var chart = new ApexCharts(document.querySelector("#chart1"), e).render();
}


//------------------------------------------------------------------------------------------------------------------
// chart2
//------------------------------------------------------------------------------------------------------------------
if ($('#chart2').length){
  var	e = {
      series: [{
        name: "Store Visitores",
        data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
      }],
      chart: {
        type: "line",
        height: 65,
        toolbar: {
          show: !1
        },
        zoom: {
          enabled: !1
        },
        dropShadow: {
          enabled: !0,
          top: 3,
          left: 14,
          blur: 4,
          opacity: .12,
          color: "#FFC500"
        },
        sparkline: {
          enabled: !0
        }
      },
      markers: {
        size: 0,
        colors: ["#FFC500"],
        strokeColors: "#fff",
        strokeWidth: 2,
        hover: {
          size: 7
        }
      },
      dataLabels: {
        enabled: !1
      },
      stroke: {
        show: !0,
        width: 3,
        curve: "smooth"
      },
      colors: ["#FFC500"],
      xaxis: {
        categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
      },
      fill: {
        opacity: 1
      },
      tooltip: {
        theme: "dark",
        fixed: {
          enabled: !1
        },
        x: {
          show: !1
        },
        y: {
          title: {
            formatter: function(e) {
              return ""
            }
          }
        },
        marker: {
          show: !1
        }
      }
  };
  var chart2 = new ApexCharts(document.querySelector("#chart2"), e).render();
}


//------------------------------------------------------------------------------------------------------------------
// chart3
//------------------------------------------------------------------------------------------------------------------
if ($('#chart3').length){
  var	e = {
		series: [{
			name: "Store Visitores",
			data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
		}],
		chart: {
			type: "line",
			height: 65,
			toolbar: {
				show: !1
			},
			zoom: {
				enabled: !1
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .12,
				color: "#E52727"
			},
			sparkline: {
				enabled: !0
			}
		},
		markers: {
			size: 0,
			colors: ["#E52727"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 3,
			curve: "smooth"
		},
		colors: ["#E52727"],
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			theme: "dark",
			fixed: {
				enabled: !1
			},
			x: {
				show: !1
			},
			y: {
				title: {
					formatter: function(e) {
						return ""
					}
				}
			},
			marker: {
				show: !1
			}
		}
	};
  var chart3 = new ApexCharts(document.querySelector("#chart3"), e).render();
}

//------------------------------------------------------------------------------------------------------------------
// chart4
//------------------------------------------------------------------------------------------------------------------
if ($('#chart4').length){
  var options = {
    series: [44, 55, 41],
    chart: {
    type: 'donut',
    height: 477,
  },
  labels: ['In Progress', 'Complete', 'Not Started'],
  plotOptions: {
    pie: {
      startAngle: -90,
      endAngle: 270
    }
  },
  dataLabels: {
    enabled: false
  },
  fill: {
    type: 'gradient',
  },
  legend: {
    position: 'bottom',
    horizontalAlign: 'center',
    fontSize: '14px',
    markers: {
        width: 10,
        height: 10,
        offsetX: -2,
    },
    height: 0,
    offsetY: 0,
},
  colors: ['#3836f3', '#22c55e' , '#FFC500'],
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
  };

  var chart4 = new ApexCharts(document.querySelector("#chart4"), options);
  chart4.render();
}



//------------------------------------------------------------------------------------------------------------------
// chart5
//------------------------------------------------------------------------------------------------------------------

if ($('#chart5').length){
  var options = {
    series: [{
    name: 'Web Design',
    data: [44, 55, 41, 37, 22, 43, 21]
  }, {
    name: 'Gellary',
    data: [53, 32, 33, 52, 13, 43, 32]
  }, {
    name: 'Photography',
    data: [12, 17, 11, 9, 15, 11, 20]
  }, {
    name: 'Digital',
    data: [9, 7, 5, 8, 6, 9, 4]
  }, {
    name: 'Marketing',
    data: [25, 12, 19, 32, 25, 24, 10]
  }],
    chart: {
    type: 'bar',
    height: 450,
    stacked: true,
  },
  colors: ['#3836f3', '#22c55e' , '#FFC500' , '#E52727' , '#5b5b98'],

  plotOptions: {
    bar: {
      horizontal: true,
      dataLabels: {
        total: {
          enabled: true,
          offsetX: 0,
          style: {
            fontSize: '13px',
            fontWeight: 900
          }
        }
      }
    },
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  xaxis: {
    categories: [2024, 2025, 2026, 2027, 2028, 2029, 2030],
    labels: {
      formatter: function (val) {
        return val + "K"
      }
    }
  },
  yaxis: {
    title: {
      text: undefined
    },
  },
  tooltip: {
    y: {
      formatter: function (val) {
        return val + "K"
      }
    }
  },
  fill: {
    opacity: 1
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left',
    offsetX: 40
  }
  };
  var chart5 = new ApexCharts(document.querySelector("#chart5"), options);
  chart5.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart6
//------------------------------------------------------------------------------------------------------------------
if ($('#chart6').length){
  var options = {
    series: [
    {
      name: 'Q1 Budget',
      group: 'budget',
      data: [44000, 55000, 41000, 67000, 22000, 43000]
    },
    {
      name: 'Q1 Actual',
      group: 'actual',
      data: [48000, 50000, 40000, 65000, 25000, 40000]
    },
    {
      name: 'Q2 Budget',
      group: 'budget',
      data: [13000, 36000, 20000, 8000, 13000, 27000]
    },
    {
      name: 'Q2 Actual',
      group: 'actual',
      data: [20000, 40000, 25000, 10000, 12000, 28000]
    }
  ],
    chart: {
    type: 'bar',
    height: 550,
    stacked: true,
  },
  stroke: {
    width: 1,
    colors: ['#fff']
  },
  dataLabels: {
    formatter: (val) => {
      return val / 1000 + 'K'
    }
  },
  plotOptions: {
    bar: {
      horizontal: false
    }
  },
  xaxis: {
    categories: [
      'Online advertising',
      'Sales Training',
      'Print advertising',
      'Catalogs',
      'Meetings',
      'Public relations'
    ]
  },
  fill: {
    opacity: 1
  },
  colors: ['#3836f3', '#22c55e', '#FFC500', '#E52727'],
  yaxis: {
    labels: {
      formatter: (val) => {
        return val / 1000 + 'K'
      }
    }
  },
  legend: {
    position: 'top',
    horizontalAlign: 'left'
  }
  };

  var chart = new ApexCharts(document.querySelector("#chart6"), options);
  chart.render();

}


//------------------------------------------------------------------------------------------------------------------
// chart7
//------------------------------------------------------------------------------------------------------------------
if ($('#chart7').length){  
  var options = {
    series: [44, 55, 13, 43, 22],
    chart: {
    type: 'pie',
    height: 427,
  },
  legend: {
    position: 'bottom',
    horizontalAlign: 'center',
    fontSize: '14px',
    markers: {
        width: 10,
        height: 10,
        offsetX: -2,
    },
    height: 50,
    offsetY: 0,
},
  labels: ['Documentation', 'Project Management', 'Coding', 'Construction', 'Other'],
  colors: ['#3836f3', '#22c55e' , '#FFC500' , '#E52727' , '#5b5b98'],
  responsive: [{
    breakpoint: 480,
    options: {
      chart: {
        width: 200
      },
      legend: {
        position: 'bottom'
      }
    }
  }]
  };
  var chart = new ApexCharts(document.querySelector("#chart7"), options);
  chart.render();

}


//------------------------------------------------------------------------------------------------------------------
// chart8
//------------------------------------------------------------------------------------------------------------------
if ($('#chart8').length){
  var m = {
		series: [{
			name: "audience",
			data: [14, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5]
		}],
		chart: {
			foreColor: "#9ba7b2",
			height: 310,
			type: "area",
			zoom: {
				enabled: !1
			},
			toolbar: {
				show: !0
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .1
			}
		},
		stroke: {
			width: 5,
			curve: "smooth"
		},
		xaxis: {
			//type: "datetime",
			categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']
		},
		fill: {
			type: "gradient",
			gradient: {
				shade: "light",
				gradientToColors: ["#3836f3"],
				shadeIntensity: 1,
				type: "vertical",
				opacityFrom: .7,
				opacityTo: .2,
				stops: [0, 100, 100, 100]
			}
		},
		markers: {
			size: 5,
			colors: ["#3836f3"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		dataLabels: {
			enabled: !1
		},
		colors: ["#3836f3"],
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		}
	};
	new ApexCharts(document.querySelector("#chart8"), m).render();
}



//------------------------------------------------------------------------------------------------------------------
// chart9
//------------------------------------------------------------------------------------------------------------------
if ($('#chart9').length){
  e = {
    series: [{
      name: "Total Users",
      data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
    }],
    chart: {
      type: "bar",
      height: 100,
      toolbar: {
        show: !1
      },
      zoom: {
        enabled: !1
      },
      dropShadow: {
        enabled: !0,
        top: 3,
        left: 14,
        blur: 4,
        opacity: .12,
        color: "#3836f3"
      },
      sparkline: {
        enabled: !0
      }
    },
    markers: {
      size: 0,
      colors: ["#3836f3"],
      strokeColors: "#fff",
      strokeWidth: 2,
      hover: {
        size: 7
      }
    },
    plotOptions: {
      bar: {
        horizontal: !1,
        columnWidth: "30%",
        endingShape: "rounded"
      }
    },
    dataLabels: {
      enabled: !1
    },
    stroke: {
      show: !0,
      width: 0,
      curve: "smooth"
    },
    colors: ["#3836f3"],
    xaxis: {
      categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
    },
    fill: {
      opacity: 1
    },
    tooltip: {
      theme: "dark",
      fixed: {
        enabled: !1
      },
      x: {
        show: !1
      },
      y: {
        title: {
          formatter: function(e) {
            return ""
          }
        }
      },
      marker: {
        show: !1
      }
    }
  };
  new ApexCharts(document.querySelector("#chart9"), e).render();
}



//------------------------------------------------------------------------------------------------------------------
// chart10
//------------------------------------------------------------------------------------------------------------------
if ($('#chart10').length){
  e = {
		series: [{
			name: "Page Views",
			data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
		}],
		chart: {
			type: "bar",
			height: 100,
			toolbar: {
				show: !1
			},
			zoom: {
				enabled: !1
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .12,
				color: "#ffc500"
			},
			sparkline: {
				enabled: !0
			}
		},
		markers: {
			size: 0,
			colors: ["#ffc500"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "30%",
				endingShape: "rounded"
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 0,
			curve: "smooth"
		},
		colors: ["#ffc500"],
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			theme: "dark",
			fixed: {
				enabled: !1
			},
			x: {
				show: !1
			},
			y: {
				title: {
					formatter: function(e) {
						return ""
					}
				}
			},
			marker: {
				show: !1
			}
		}
	};
	new ApexCharts(document.querySelector("#chart10"), e).render(); 
}


//------------------------------------------------------------------------------------------------------------------
// chart11
//------------------------------------------------------------------------------------------------------------------
if ($('#chart11').length){
  e = {
		series: [{
			name: "Avg. Session Duration",
			data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
		}],
		chart: {
			type: "bar",
			height: 100,
			toolbar: {
				show: !1
			},
			zoom: {
				enabled: !1
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .12,
				color: "#22c55e"
			},
			sparkline: {
				enabled: !0
			}
		},
		markers: {
			size: 0,
			colors: ["#22c55e"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "30%",
				endingShape: "rounded"
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 0,
			curve: "smooth"
		},
		colors: ["#22c55e"],
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			theme: "dark",
			fixed: {
				enabled: !1
			},
			x: {
				show: !1
			},
			y: {
				title: {
					formatter: function(e) {
						return ""
					}
				}
			},
			marker: {
				show: !1
			}
		}
	};
	new ApexCharts(document.querySelector("#chart11"), e).render();
}

//------------------------------------------------------------------------------------------------------------------
// chart12
//------------------------------------------------------------------------------------------------------------------
if ($('#chart12').length){
  e = {
		series: [{
			name: "Avg. Session Duration",
			data: [240, 160, 671, 414, 555, 257, 901, 613, 727, 414, 555, 257]
		}],
		chart: {
			type: "bar",
			height: 100,
			toolbar: {
				show: !1
			},
			zoom: {
				enabled: !1
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .12,
				color: "#e52727"
			},
			sparkline: {
				enabled: !0
			}
		},
		markers: {
			size: 0,
			colors: ["#e52727"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "30%",
				endingShape: "rounded"
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 0,
			curve: "smooth"
		},
		colors: ["#e52727"],
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			theme: "dark",
			fixed: {
				enabled: !1
			},
			x: {
				show: !1
			},
			y: {
				title: {
					formatter: function(e) {
						return ""
					}
				}
			},
			marker: {
				show: !1
			}
		}
	};
	new ApexCharts(document.querySelector("#chart12"), e).render();
}


//------------------------------------------------------------------------------------------------------------------
// chart13
//------------------------------------------------------------------------------------------------------------------
if ($('#chart13').length){ 
  var options = {
    series: [{
    name: 'view',
    data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3]
  }],
    chart: {
    height: 350,
    type: 'bar',
  },
  plotOptions: {
    bar: {
      borderRadius: 2,
      dataLabels: {
        position: 'top',
      },
    }
  },
  dataLabels: {
    enabled: true,
    formatter: function (val) {
      return val + "%";
    },
    offsetY: -20,
    style: {
      fontSize: '12px',
      colors: ["#3836f3"]
    }
  },
  
  xaxis: {
    categories: ["10-20", "21-30", "31-40", "41-50", "51-60", "71-80", "81-90", "91-100"],
    position: 'top',
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false
    },
    crosshairs: {
      fill: {
        type: 'gradient',
        gradient: {
          colorFrom: '#3836f3',
          colorTo: '#3836f3',
          stops: [0, 100],
          opacityFrom: 0.4,
          opacityTo: 0.5,
        }
      }
    },
    tooltip: {
      enabled: true,
    }
  },
  yaxis: {
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: false,
      formatter: function (val) {
        return val + "%";
      }
    }
  },
  };
  var chart = new ApexCharts(document.querySelector("#chart13"), options);
  chart.render();
}



//------------------------------------------------------------------------------------------------------------------
// chart14
//------------------------------------------------------------------------------------------------------------------
if ($('#world-map').length){
  $(function(){
    $('#world-map').vectorMap({
      map: 'world_mill_en',
      scaleColors: ['#E52727', '#E52727'],
      selectedColor: "#c9dfaf",
      normalizeFunction: 'polynomial',
      hoverOpacity: 0.7,
      hoverColor: false,
      backgroundColor: "transparent",
      borderColor: "#E52727",
      borderWidth: 1,
      zoomOnScroll: !1,
      color: "#E52727",
      markerStyle: {
        initial: {
          r: 9,
          fill: "#22c55e",
          "fill-opacity": 1,
          stroke: "#22c55e",
          "stroke-width": 1,
          "stroke-opacity": .4
        }
      },
      series: {
        regions: [{
          values: {
            BD: "#0d6efd",
            US: "#3836f3",
            RU: "#E52727",
            AU: "#FFC500"
          }
        }]
      },
     markers: [{
       latLng: [23, 90],
       name: "I Love My Bangladesh"
     }],
    });
  });
} 


//------------------------------------------------------------------------------------------------------------------
// chart15
//------------------------------------------------------------------------------------------------------------------

if ($('#chart15').length){ 
  var options = {
    series: [{
      name: "Other",
      data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
    },
    {
      name: "Female",
      data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
    },
    {
      name: 'Male',
      data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
    }
  ],
    chart: {
    height: 340,
    type: 'line',
    zoom: {
      enabled: false
    },
  },
  colors: ['#FFC500', '#E52727' , '#3836f3' ,],
  dataLabels: {
    enabled: false
  },
  stroke: {
    width: [5, 7, 5],
    curve: 'straight',
    dashArray: [0, 8, 5]
  },
  legend: {
    tooltipHoverFormatter: function(val, opts) {
      return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + '</strong>'
    }
  },
  markers: {
    size: 0,
    hover: {
      sizeOffset: 6
    }
  },
  xaxis: {
    categories: ['jan', 'feb', 'mar', 'apr', 'may', 'jun', 'july', 'aug', 'sep',
      'oct', 'nav', 'dec'
    ],
  },
  tooltip: {
    y: [
      {
        title: {
          formatter: function (val) {
            return val + " (month)"
          }
        }
      },
      {
        title: {
          formatter: function (val) {
            return val + "(month)"
          }
        }
      },
      {
        title: {
          formatter: function (val) {
            return val;
          }
        }
      }
    ]
  },
  grid: {
    borderColor: '#f1f1f1',
  }
  };
  var chart = new ApexCharts(document.querySelector("#chart15"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart16
//------------------------------------------------------------------------------------------------------------------

if($('#chart16').length) {
  var balanceOverviewoptions = {
      series: [{
          name: 'Stock',
          color: '#3836f3',
          data: [31, 40, 28, 51, 42, 109, 100, 40, 28, 51, 42, 109]
      }, {
          name: 'Order',
          color: '#FFC500',
          data: [11, 32, 45, 32, 34, 52, 41, 32, 45, 32, 34, 52]
      }],
      chart: {
          height: 340,
          type: 'bar',
          stacked: true,
          toolbar: {
              show: false
          },
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          width: 0,
          curve: 'smooth'
      },
      xaxis: {
          fill: '#FFFFFF',
          type: 'datetime',
          categories: ["2022-12-19T00:00:00.000Z", "2022-12-20T00:00:00.000Z", "2022-12-21T00:00:00.000Z", "2022-12-22T00:00:00.000Z", "2022-12-23T00:00:00.000Z", "2022-12-24T00:00:00.000Z", "2022-12-25T00:00:00.000Z", "2022-12-26T00:00:00.000Z", "2022-12-27T00:00:00.000Z", "2022-12-28T00:00:00.000Z", "2022-12-29T00:00:00.000Z", "2022-12-30T00:00:00.000Z"],
          labels: {
              datetimeFormatter: {
                  month: 'MMMM',
              }
          },
          axisBorder: {
              show: false,
          },
          axisTicks: {
              show: false,
          },
      },
      grid: {
          borderColor: '#eee',
          strokeDashArray: 3,
          xaxis: {
              lines: {
                  show: true,
              }
          },
          padding: {
              bottom: 15
          }
      },
      responsive: [{
          breakpoint: 1199,
          options: {
              chart: {
                  height: 365,
              },
          },
      },{
          breakpoint: 991,
          options: {
              chart: {
                  height: 300,
              },
          },
      },{
          breakpoint: 479,
          options: {
              chart: {
                  height: 250,
              },
          },
      }]
  };
  var balanceOverview = new ApexCharts(document.querySelector("#chart16"), balanceOverviewoptions);
  balanceOverview.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart17
//------------------------------------------------------------------------------------------------------------------

if($('#chart17').length) {
  var saleAnalyticsoptions = {
      series: [{
          name: 'Tasks Created',
          color: '#FFC500',
          data: [31, 40, 28, 51, 42, 109, 100]
      }, {
          name: 'Tasks Solved',
          color: '#22c55e',
          data: [11, 32, 45, 32, 34, 52, 41]
      }],
      chart: {
          height: 450,
          type: 'area',
          toolbar: {
              show: false
          },
      },
      dataLabels: {
          enabled: false
      },
      stroke: {
          width: 1,
          curve: 'smooth'
      },
      xaxis: {
          fill: '#4c5258',
          type: 'datetime',
          categories: ["2024-12-19T00:00:00.000Z", "2024-12-20T00:00:00.000Z", "2024-12-21T00:00:00.000Z", "2024-12-22T00:00:00.000Z", "2024-12-23T00:00:00.000Z", "2024-12-24T00:00:00.000Z", "2024-12-25T00:00:00.000Z"],
          labels: {
              format: 'dddd',
              style: {
                  colors: '#747474',
                  fontSize: '12px',
                  fontWeight: 400,
              },
          },
          axisBorder: {
              show: false,
          },
          axisTicks: {
              show: false,
          },
      },
      yaxis: {
          labels: {
          style: {
            colors: '#747474',
            fontSize: '12px',
            fontWeight: 400,
            
          },
        },
      },
      grid: {
          borderColor: '#eee',
          strokeDashArray: 2,
          xaxis: {
              lines: {
                  show: true,
              }
          },
          padding: {
              bottom: 15
          }
      },
      responsive: [{
          breakpoint: 479,
          options: {
              chart: {
                  height: 250,
              },
          },
      }]
  };
  var saleAnalytics = new ApexCharts(document.querySelector("#chart17"), saleAnalyticsoptions);
  saleAnalytics.render();
}


//------------------------------------------------------------------------------------------------------------------
// chart18
//------------------------------------------------------------------------------------------------------------------

if($('#chart18').length) {
  var options = {
    series: [{
      data: [11, 32, 45, 32, 34, 52, 41]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#22c55e'],
  };
  var chart = new ApexCharts(document.querySelector("#chart18"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart19
//------------------------------------------------------------------------------------------------------------------

if($('#chart19').length) {
  var options = {
    series: [{
      data: [11, 32, 45, 32, 34, 52, 80]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#3836f3'],
  };
  var chart = new ApexCharts(document.querySelector("#chart19"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart20
//------------------------------------------------------------------------------------------------------------------

if($('#chart20').length) {
  var options = {
    series: [{
      data: [11, 32, 45, 80, 34, 52, 41]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#FFC500'],
  };
  var chart = new ApexCharts(document.querySelector("#chart20"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart21
//------------------------------------------------------------------------------------------------------------------

if($('#chart21').length) {
  var options = {
    series: [{
      data: [80, 32, 45, 32, 34, 52, 41]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#E52727'],
  };
  var chart = new ApexCharts(document.querySelector("#chart21"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart22
//------------------------------------------------------------------------------------------------------------------

if($('#chart22').length) {
  e = {
		chart: {
			height: 180,
			type: "radialBar",
			toolbar: {
				show: !1
			}
		},
		plotOptions: {
			radialBar: {
				hollow: {
					margin: 0,
					size: "78%",
					background: "transparent",
					image: void 0,
					imageOffsetX: 0,
					imageOffsetY: 0,
					position: "front",
					dropShadow: {
						enabled: !1,
						top: 3,
						left: 0,
						blur: 4,
						color: "rgba(0, 169, 255, 0.85)",
						opacity: .65
					}
				},
				track: {
					margin: 0,
					dropShadow: {
						enabled: !1,
						top: -3,
						left: 0,
						blur: 4,
						color: "rgba(0, 169, 255, 0.85)",
						opacity: .65
					}
				},
				dataLabels: {
					showOn: "always",
					name: {
						offsetY: -8,
						show: !0,
						color: "#6c757d",
						fontSize: "15px"
					},
					value: {
						formatter: function(e) {
							return e + "%"
						},
						color: "#000",
						fontSize: "25px",
						show: !0,
						offsetY: 10
					}
				}
			}
		},
		fill: {
			type: "gradient",
			gradient: {
				shade: "light",
				type: "horizontal",
				shadeIntensity: .5,
				gradientToColors: ["#3836f3"],
				inverseColors: !1,
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 100]
			}
		},
		colors: ["#3836f3"],
		series: [60],
		stroke: {
			lineCap: "round"
		},
		labels: ["Budget"]
	};
	new ApexCharts(document.querySelector("#chart22"), e).render();
}


//------------------------------------------------------------------------------------------------------------------
// chart23
//------------------------------------------------------------------------------------------------------------------

if($('#chart23').length) {
  e = {
		chart: {
			height: 180,
			type: "radialBar",
			toolbar: {
				show: !1
			}
		},
		plotOptions: {
			radialBar: {
				hollow: {
					margin: 0,
					size: "78%",
					background: "transparent",
					image: void 0,
					imageOffsetX: 0,
					imageOffsetY: 0,
					position: "front",
					dropShadow: {
						enabled: !1,
						top: 3,
						left: 0,
						blur: 4,
						color: "rgba(0, 169, 255, 0.85)",
						opacity: .65
					}
				},
				track: {
					margin: 0,
					dropShadow: {
						enabled: !1,
						top: -3,
						left: 0,
						blur: 4,
						color: "rgba(0, 169, 255, 0.5)",
						opacity: .65
					}
				},
				dataLabels: {
					showOn: "always",
					name: {
						offsetY: -8,
						show: !0,
						color: "#6c757d",
						fontSize: "15px"
					},
					value: {
						formatter: function(e) {
							return e + "%"
						},
						color: "#000",
						fontSize: "25px",
						show: !0,
						offsetY: 10
					}
				}
			}
		},
		fill: {
			type: "gradient",
			gradient: {
				shade: "light",
				type: "horizontal",
				shadeIntensity: .5,
				gradientToColors: ["#E52727"],
				inverseColors: !1,
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 100]
			}
		},
		colors: ["#E52727"],
		series: [68],
		stroke: {
			lineCap: "round",
			width: "5"
		},
		labels: ["Profit"]
	};
	new ApexCharts(document.querySelector("#chart23"), e).render();
}



//------------------------------------------------------------------------------------------------------------------
// chart24
//------------------------------------------------------------------------------------------------------------------

if($('#chart24').length) {
  e = {
		chart: {
			height: 180,
			type: "radialBar",
			toolbar: {
				show: !1
			}
		},
		plotOptions: {
			radialBar: {
				hollow: {
					margin: 0,
					size: "78%",
					background: "transparent",
					image: void 0,
					imageOffsetX: 0,
					imageOffsetY: 0,
					position: "front",
					dropShadow: {
						enabled: !1,
						top: 3,
						left: 0,
						blur: 4,
						color: "rgba(0, 169, 255, 0.85)",
						opacity: .65
					}
				},
				track: {
					margin: 0,
					dropShadow: {
						enabled: !1,
						top: -3,
						left: 0,
						blur: 4,
						color: "rgba(0, 169, 255, 0.85)",
						opacity: .65
					}
				},
				dataLabels: {
					showOn: "always",
					name: {
						offsetY: -8,
						show: !0,
						color: "#6c757d",
						fontSize: "15px"
					},
					value: {
						formatter: function(e) {
							return e + "%"
						},
						color: "#000",
						fontSize: "25px",
						show: !0,
						offsetY: 10
					}
				}
			}
		},
		fill: {
			type: "gradient",
			gradient: {
				shade: "light",
				type: "horizontal",
				shadeIntensity: .5,
				gradientToColors: ["#FFC500"],
				inverseColors: !1,
				opacityFrom: 1,
				opacityTo: 1,
				stops: [0, 100]
			}
		},
		colors: ["#FFC500"],
		series: [45],
		stroke: {
			lineCap: "round"
		},
		labels: ["In Progress"]
	};
	new ApexCharts(document.querySelector("#chart24"), e).render();
}


//------------------------------------------------------------------------------------------------------------------
// chart25
//------------------------------------------------------------------------------------------------------------------

if($('#chart25').length) {
  e = {
    series: [{
      name: "other",
      data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
      },
    ],
		chart: {
			foreColor: "#9ba7b2",
			type: "area",
			height: 270,
			toolbar: {
				show: !1
			},
			zoom: {
				enabled: !1
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .12,
				color: "#0d6efd"
			},
			sparkline: {
				enabled: !1
			}
		},
		markers: {
			size: 0,
			colors: ["#0d6efd"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		},
		plotOptions: {
			bar: {
				horizontal: !1,
				columnWidth: "30%",
				endingShape: "rounded"
			}
		},
		dataLabels: {
			enabled: !1
		},
		stroke: {
			show: !0,
			width: 3,
			curve: "smooth"
		},
		colors: ["#0d6efd"],
		xaxis: {
			categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"]
		},
		fill: {
			opacity: 1
		},
		tooltip: {
			theme: "dark",
			fixed: {
				enabled: !1
			},
			x: {
				show: !0
			},
			y: {
				formatter: function(e) {
					return " " + e + " "
				}
			},
			marker: {
				show: !1
			}
		}
	};
	new ApexCharts(document.querySelector("#chart25"), e).render();
}

//------------------------------------------------------------------------------------------------------------------
// chart26
//------------------------------------------------------------------------------------------------------------------


if($('#chart26').length) {
  var options = {
    series: [{
    name: "Y",
    data: [{
      x: '2024/01/01',
      y: 300
    }, {
      x: '2024/04/01',
      y: 430
    }, {
      x: '2024/07/01',
      y: 448
    }, {
      x: '2024/10/01',
      y: 470
    }, {
      x: '2025/01/01',
      y: 540
    }, {
      x: '2025/04/01',
      y: 580
    }, {
      x: '2025/07/01',
      y: 690
    }, {
      x: '2025/10/01',
      y: 690
    }]
  }],
    chart: {
    type: 'bar',
    height: 400
  },
  colors: ["#3836f3"],
  yaxis: {
    categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
    labels: {
      formatter: function (val) {
        return "$" + val
      }
    }
  },
  xaxis: {
    type: 'category',
    group: {
      style: {
        fontSize: '12px',
        fontWeight: 700
      },
      groups: [
        { title: '2024', cols: 4 },
        { title: '2025', cols: 4 }
      ]
    }
  },
  };
  
  var chart = new ApexCharts(document.querySelector("#chart26"), options);
  chart.render();
}
//------------------------------------------------------------------------------------------------------------------
// chart27
//------------------------------------------------------------------------------------------------------------------

if($('#chart27').length) {

  var options = {
    series: [{
    name: 'Avarage',
    type: 'column',
    data: [440, 505, 414, 671, 227, 413, 201, 352, 752, 320, 257, 160]
  }, {
    name: 'Service',
    type: 'line',
    data: [236, 426, 35, 27, 43, 225, 17, 111, 22, 22, 542, 16]
  }],
    chart: {
    height: 400,
    type: 'line',
    zoom: {
      enabled: false
    }
  },
  colors:['#22c55e',"#FFC500"],
  stroke: {
    width: [0, 4]
  },
  dataLabels: {
    enabled: true,
    enabledOnSeries: [1]
  },
  yaxis: {
    categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
    labels: {
      formatter: function (val) {
        return "$" + val
      }
    }
  },
  };

  var chart = new ApexCharts(document.querySelector("#chart27"), options);
  chart.render();
}


//------------------------------------------------------------------------------------------------------------------
// chart28
//------------------------------------------------------------------------------------------------------------------
if ($('#chart28').length){
  var m = {
		series: [{
			name: "User",
			data: [14, 3, 10, 9, 29, 19, 22, 9, 12, 7, 19, 5]
		}],
		chart: {
			foreColor: "#9ba7b2",
			height: 310,
			type: "area",
			zoom: {
				enabled: !1
			},
			toolbar: {
				show: !0
			},
			dropShadow: {
				enabled: !0,
				top: 3,
				left: 14,
				blur: 4,
				opacity: .1
			}
		},
		stroke: {
			width: 5,
			curve: "smooth"
		},
		xaxis: {
			//type: "datetime",
			categories: ['JAN', 'FEB', 'MAR', 'APR', 'MAY', 'JUN', 'JUL', 'AUG', 'SEP', 'OCT', 'NOV', 'DEC']
		},
		fill: {
			type: "gradient",
			gradient: {
				shade: "light",
				gradientToColors: ["#3836f3"],
				shadeIntensity: 1,
				type: "vertical",
				opacityFrom: .7,
				opacityTo: .2,
				stops: [0, 100, 100, 100]
			}
		},
		markers: {
			size: 5,
			colors: ["#3836f3"],
			strokeColors: "#fff",
			strokeWidth: 2,
			hover: {
				size: 7
			}
		},
		dataLabels: {
			enabled: !1
		},
		colors: ["#3836f3"],
		grid: {
			show: true,
			borderColor: 'rgba(0, 0, 0, 0.15)',
			strokeDashArray: 4,
		}
	};
	new ApexCharts(document.querySelector("#chart28"), m).render();
}



//------------------------------------------------------------------------------------------------------------------
// chart29
//------------------------------------------------------------------------------------------------------------------

if($('#chart29').length) {
  var options = {
    series: [{
      name: "Total User",
      data: [11, 32, 45, 32, 34, 52, 41]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#22c55e'],
  };
  var chart = new ApexCharts(document.querySelector("#chart29"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart30
//------------------------------------------------------------------------------------------------------------------

if($('#chart30').length) {
  var options = {
    series: [{
      name: "Daily User",
      data: [11, 32, 45, 32, 34, 52, 80]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#3836f3'],
  };
  var chart = new ApexCharts(document.querySelector("#chart30"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart31
//------------------------------------------------------------------------------------------------------------------

if($('#chart31').length) {
  var options = {
    series: [{
      name: "Page views",
      data: [11, 32, 45, 80, 34, 52, 41]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#FFC500'],
  };
  var chart = new ApexCharts(document.querySelector("#chart31"), options);
  chart.render();
}

//------------------------------------------------------------------------------------------------------------------
// chart32
//------------------------------------------------------------------------------------------------------------------

if($('#chart32').length) {
  var options = {
    series: [{
      name: "Bounce Rate",
      data: [80, 32, 45, 32, 34, 52, 41]
  }],
    chart: {
    type: 'area',
    height: 80,
    sparkline: {
      enabled: true
    },
  },
  stroke: {
    curve: 'straight'
  },
  fill: {
    opacity: 0.3,
  },
  yaxis: {
    min: 0
  },
  colors: ['#E52727'],
  };
  var chart = new ApexCharts(document.querySelector("#chart32"), options);
  chart.render();
}


})(jQuery);