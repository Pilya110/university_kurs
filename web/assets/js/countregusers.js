var chart = AmCharts.makeChart("chartdiv", {
  "type": "serial",
  "theme": "light",
  "marginRight": 70,
  "dataProvider": [{
    "country": "Январь",
    "visits": 3025,
    "color": "#FF0F00"
  }, {
    "country": "Февраль",
    "visits": 1882,
    "color": "#FF6600"
  }, {
    "country": "Март",
    "visits": 1809,
    "color": "#FF9E01"
  }, {
    "country": "Апрель",
    "visits": 1322,
    "color": "#FCD202"
  }, {
    "country": "Июнь",
    "visits": 1122,
    "color": "#F8FF01"
  }, {
    "country": "Июль",
    "visits": 1114,
    "color": "#B0DE09"
  }, {
    "country": "Август",
    "visits": 984,
    "color": "#04D215"
  }, {
    "country": "Сентябрь",
    "visits": 711,
    "color": "#0D8ECF"
  }, {
    "country": "Октябрь",
    "visits": 665,
    "color": "#0D52D1"
  }, {
    "country": "Ноябрь",
    "visits": 580,
    "color": "#2A0CD0"
  }, {
    "country": "Декабрь",
    "visits": 443,
    "color": "#8A0CCF"
  }],
  "valueAxes": [{
    "axisAlpha": 0,
    "position": "left",
    "title": "Число пользователей"
  }],
  "startDuration": 1,
  "graphs": [{
    "balloonText": "<b>[[category]]: [[value]]</b>",
    "fillColorsField": "color",
    "fillAlphas": 0.9,
    "lineAlpha": 0.2,
    "type": "column",
    "valueField": "visits"
  }],
  "chartCursor": {
    "categoryBalloonEnabled": false,
    "cursorAlpha": 0,
    "zoomable": false
  },
  "categoryField": "country",
  "categoryAxis": {
    "gridPosition": "start",
    "labelRotation": 45
  },
  "export": {
    "enabled": true
  }

});