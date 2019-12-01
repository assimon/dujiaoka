(function (root, factory) {
    if (typeof define === 'function' && define.amd) {
        // AMD. Register as an anonymous module.
        define(['exports', 'echarts'], factory);
    } else if (typeof exports === 'object' && typeof exports.nodeName !== 'string') {
        // CommonJS
        factory(exports, require('echarts'));
    } else {
        // Browser globals
        factory({}, root.echarts);
    }
}(this, function (exports, echarts) {
    var log = function (msg) {
        if (typeof console !== 'undefined') {
            console && console.error && console.error(msg);
        }
    };
    if (!echarts) {
        log('ECharts is not Loaded');
        return;
    }
    echarts.registerTheme('shine', {
        "color": [
            "#c12e34",
            "#e6b600",
            "#0098d9",
            "#2b821d",
            "#005eaa",
            "#339ca8",
            "#cda819",
            "#32a487"
        ],
        "backgroundColor": "rgba(0,0,0,0)",
        "textStyle": {},
        "title": {
            "textStyle": {
                "color": "#333333"
            },
            "subtextStyle": {
                "color": "#aaaaaa"
            }
        },
        "line": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 1
                }
            },
            "lineStyle": {
                "normal": {
                    "width": 2
                }
            },
            "symbolSize": 4,
            "symbol": "emptyCircle",
            "smooth": false
        },
        "radar": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 1
                }
            },
            "lineStyle": {
                "normal": {
                    "width": 2
                }
            },
            "symbolSize": 4,
            "symbol": "emptyCircle",
            "smooth": false
        },
        "bar": {
            "itemStyle": {
                "normal": {
                    "barBorderWidth": 0,
                    "barBorderColor": "#ccc"
                },
                "emphasis": {
                    "barBorderWidth": 0,
                    "barBorderColor": "#ccc"
                }
            }
        },
        "pie": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "scatter": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "boxplot": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "parallel": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "sankey": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "funnel": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "gauge": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                },
                "emphasis": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            }
        },
        "candlestick": {
            "itemStyle": {
                "normal": {
                    "color": "#c12e34",
                    "color0": "#2b821d",
                    "borderColor": "#c12e34",
                    "borderColor0": "#2b821d",
                    "borderWidth": 1
                }
            }
        },
        "graph": {
            "itemStyle": {
                "normal": {
                    "borderWidth": 0,
                    "borderColor": "#ccc"
                }
            },
            "lineStyle": {
                "normal": {
                    "width": 1,
                    "color": "#aaaaaa"
                }
            },
            "symbolSize": 4,
            "symbol": "emptyCircle",
            "smooth": false,
            "color": [
                "#c12e34",
                "#e6b600",
                "#0098d9",
                "#2b821d",
                "#005eaa",
                "#339ca8",
                "#cda819",
                "#32a487"
            ],
            "label": {
                "normal": {
                    "textStyle": {
                        "color": "#eeeeee"
                    }
                }
            }
        },
        "map": {
            "itemStyle": {
                "normal": {
                    "areaColor": "#dddddd",
                    "borderColor": "#eeeeee",
                    "borderWidth": 0.5
                },
                "emphasis": {
                    "areaColor": "rgba(230,182,0,1)",
                    "borderColor": "#dddddd",
                    "borderWidth": 1
                }
            },
            "label": {
                "normal": {
                    "textStyle": {
                        "color": "#c12e34"
                    }
                },
                "emphasis": {
                    "textStyle": {
                        "color": "rgb(193,46,52)"
                    }
                }
            }
        },
        "geo": {
            "itemStyle": {
                "normal": {
                    "areaColor": "#dddddd",
                    "borderColor": "#eeeeee",
                    "borderWidth": 0.5
                },
                "emphasis": {
                    "areaColor": "rgba(230,182,0,1)",
                    "borderColor": "#dddddd",
                    "borderWidth": 1
                }
            },
            "label": {
                "normal": {
                    "textStyle": {
                        "color": "#c12e34"
                    }
                },
                "emphasis": {
                    "textStyle": {
                        "color": "rgb(193,46,52)"
                    }
                }
            }
        },
        "categoryAxis": {
            "axisLine": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisTick": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisLabel": {
                "show": true,
                "textStyle": {
                    "color": "#333"
                }
            },
            "splitLine": {
                "show": false,
                "lineStyle": {
                    "color": [
                        "#ccc"
                    ]
                }
            },
            "splitArea": {
                "show": false,
                "areaStyle": {
                    "color": [
                        "rgba(250,250,250,0.3)",
                        "rgba(200,200,200,0.3)"
                    ]
                }
            }
        },
        "valueAxis": {
            "axisLine": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisTick": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisLabel": {
                "show": true,
                "textStyle": {
                    "color": "#333"
                }
            },
            "splitLine": {
                "show": true,
                "lineStyle": {
                    "color": [
                        "#ccc"
                    ]
                }
            },
            "splitArea": {
                "show": false,
                "areaStyle": {
                    "color": [
                        "rgba(250,250,250,0.3)",
                        "rgba(200,200,200,0.3)"
                    ]
                }
            }
        },
        "logAxis": {
            "axisLine": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisTick": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisLabel": {
                "show": true,
                "textStyle": {
                    "color": "#333"
                }
            },
            "splitLine": {
                "show": true,
                "lineStyle": {
                    "color": [
                        "#ccc"
                    ]
                }
            },
            "splitArea": {
                "show": false,
                "areaStyle": {
                    "color": [
                        "rgba(250,250,250,0.3)",
                        "rgba(200,200,200,0.3)"
                    ]
                }
            }
        },
        "timeAxis": {
            "axisLine": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisTick": {
                "show": true,
                "lineStyle": {
                    "color": "#333"
                }
            },
            "axisLabel": {
                "show": true,
                "textStyle": {
                    "color": "#333"
                }
            },
            "splitLine": {
                "show": true,
                "lineStyle": {
                    "color": [
                        "#ccc"
                    ]
                }
            },
            "splitArea": {
                "show": false,
                "areaStyle": {
                    "color": [
                        "rgba(250,250,250,0.3)",
                        "rgba(200,200,200,0.3)"
                    ]
                }
            }
        },
        "toolbox": {
            "iconStyle": {
                "normal": {
                    "borderColor": "#06467c"
                },
                "emphasis": {
                    "borderColor": "#4187c2"
                }
            }
        },
        "legend": {
            "textStyle": {
                "color": "#333333"
            }
        },
        "tooltip": {
            "axisPointer": {
                "lineStyle": {
                    "color": "#cccccc",
                    "width": 1
                },
                "crossStyle": {
                    "color": "#cccccc",
                    "width": 1
                }
            }
        },
        "timeline": {
            "lineStyle": {
                "color": "#005eaa",
                "width": 1
            },
            "itemStyle": {
                "normal": {
                    "color": "#005eaa",
                    "borderWidth": 1
                },
                "emphasis": {
                    "color": "#005eaa"
                }
            },
            "controlStyle": {
                "normal": {
                    "color": "#005eaa",
                    "borderColor": "#005eaa",
                    "borderWidth": 0.5
                },
                "emphasis": {
                    "color": "#005eaa",
                    "borderColor": "#005eaa",
                    "borderWidth": 0.5
                }
            },
            "checkpointStyle": {
                "color": "#005eaa",
                "borderColor": "rgba(49,107,194,0.5)"
            },
            "label": {
                "normal": {
                    "textStyle": {
                        "color": "#005eaa"
                    }
                },
                "emphasis": {
                    "textStyle": {
                        "color": "#005eaa"
                    }
                }
            }
        },
        "visualMap": {
            "color": [
                "#1790cf",
                "#a2d4e6"
            ]
        },
        "dataZoom": {
            "backgroundColor": "rgba(47,69,84,0)",
            "dataBackgroundColor": "rgba(47,69,84,0.3)",
            "fillerColor": "rgba(167,183,204,0.4)",
            "handleColor": "#a7b7cc",
            "handleSize": "100%",
            "textStyle": {
                "color": "#333333"
            }
        },
        "markPoint": {
            "label": {
                "normal": {
                    "textStyle": {
                        "color": "#eeeeee"
                    }
                },
                "emphasis": {
                    "textStyle": {
                        "color": "#eeeeee"
                    }
                }
            }
        }
    });
}));
