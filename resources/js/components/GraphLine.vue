<template>
    <div :id="this.name"></div>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                required: true,
            },
            title: {
                type: String,
                required: false,
                default: ''
            },
            endpoint: {
                type: String,
                required: true,
            },
            method: {
                type: String,
                required: false,
                default: "get"
            },
            poll: {
                required: false,
                default: null
            }
        },
        data() {
            return {
                status: 'ready',
                dates: undefined,
                data: '',
                minTickInterval: undefined,
            }
        },
        mounted() {
            this.init();
            if(this.pollingInterval != null) {
                setInterval(() => {
                    this.init();
                }, this.pollingInterval);
            }
        },
        methods: {
            init() {
                this.status = 'loading';
                this.fetchData().then(() => {
                    this.initChart();
                    Vue.nextTick(() => {
                        this.status = 'ready';
                    })
                }).catch(() => {
                    this.status = 'error';
                });
            },
            initChart() {
                    window.Highcharts.chart(this.name, {
                     chart: {
                        // type: 'spline',
                        backgroundColor: 'transparent'
                    },
                    title: {
                        text: this.name
                    },
                    
                    xAxis: {
                        categories: this.dates,
                        type: 'datetime',
                        minTickInterval: this.minTickInterval,
                        title: {
                            text: 'Date'
                        },
                        gridLineWidth: 0,
                        crosshair: false,
                        lineWidth: 0,
                        tickWidth: 0,
                        offset: 10,
                        labels: {
                            style: {
                                color: "#bbbbbb",
                                fontSize: "13px"
                            },
                            formatter: function () {
                                return new Date(this.value).toLocaleDateString();
                            }
                        }
                    },

                    yAxis: {
                        title: {
                            text: 'Data'
                        },
                        gridLineWidth: 0,
                        labels: {
                            style: {
                                color: "#bbbbbb"
                            }
                        }
                    },
                    legend: {
                        enabled: false
                    },
                    plotOptions: {
                         spline: {
                            marker: {
                                enabled: false,
                                symbol: 'circle',
                                radius: 2,
                                states: {
                                    hover: {
                                        enabled: true,
                                        lineWidthPlus: 0
                                    }
                                }
                            }
                        },
                        series: {
                            borderWidth: 0,
                            dataLabels: {
                                enabled: false
                            }
                        }
                    },
                    series: [{
                        name: 'Data',
                        data: this.data
                    }],
                    credits: {
                        enabled: false,
                    },
                });
            },
            fetchData() {
                return new Promise((resolve, reject) => {
                    axios[this.requestMethod](this.endpoint)
                    .then(response => {
                        this.resolveSuccessfulResponse(response);
                        resolve(); 
                    })
                    .catch(error => {
                        this.resolveFailedResponse(error);
                        reject();
                    });
                })
            },
            resolveSuccessfulResponse(response) {
                var data = _.orderBy(response.data.data.total, ['timestamp'], ['asc']);
                this.dates = this.parseDates(data, 'timestamp');
                this.data = _.map(data, "total");
                console.log(this.data);
                console.log(this.dates);
            },
            resolveFailedResponse(error) {
                this.dates = [];
            },
            dateToMilliseconds(object) {
                object.timestamp = new Date(object.timestamp).getTime();
                return object;
            },
            createSeriesFromObjectArray(objectArray) {
                return _.map(_.orderBy(_.map(objectArray, this.dateToMilliseconds), ['timestamp'], ['asc']), _.values);
            },
            parseDates(dataObject, key) {
                let dates = _.map(dataObject, key);
                for(var date in dates)
                    dates[date] = new Date(dates[date]).getTime();
                return dates;
            },
            capitalizeFirstLetter(str) {
                return str.charAt(0).toUpperCase() + str.slice(1);
            }
        },
        computed: {
            requestMethod() {
                return this.method.toLowerCase();
            },
            url() {
                var url = this.endpoint;
                
                return url;
            },
            pollingInterval() {
                return this.poll != null && this.poll != 'null' 
                    ? parseInt(this.poll) * 1000 
                    : null;
            }
        },
        watch: {
            dates() {
                if(this.dates != undefined && this.dates.length)
                    this.initChart();
            },
            series() {
                if(this.series.length)
                    this.initChart();
            },
            depth() {
                if(this.depth >= 0 && this.depth < 3)
                    this.init();
           }
        }
    }
</script>
