function drawStorageCharts() {
  var data = [["Wyoming",131,"red",24.3,2.324],["Idaho",318,"red",27.1,2.029],["New Mexico",413,"blue",25.4,2.006],["Arkansas",548,"red",24.6,1.879],["Oklahoma",683,"red",24.9,1.821],["Texas",4326,"red",27.8,1.72],["Oregon",654,"blue",22.8,1.707],["Washington",1102,"blue",23.6,1.639],["Kansas",466,"red",25.0,1.633],["North Dakota",108,"red",22.3,1.606],["Nebraska",292,"red",25.1,1.599],["Colorado",792,"blue",24.4,1.575],["Nevada",421,"blue",25.8,1.559],["Utah",428,"red",31.2,1.549],["South Dakota",125,"red",24.6,1.535],["Mississippi",444,"red",26.0,1.496],["Tennessee",939,"red",23.7,1.48],["North Carolina",1408,"blue",24.3,1.477],["Louisiana",664,"red",25.0,1.465],["Alabama",698,"red",24.0,1.46],["Missouri",857,"red",23.9,1.431],["South Carolina",653,"red",23.7,1.412],["Georgia",1297,"red",26.3,1.339],["Iowa",399,"blue",23.7,1.31],["Arizona",773,"red",26.3,1.209],["Florida",2247,"blue",21.9,1.195],["Wisconsin",676,"blue",23.2,1.189],["Ohio",1338,"blue",23.5,1.16],["Michigan",1144,"blue",23.6,1.157],["Minnesota",585,"blue",23.9,1.103],["Alaska",78,"red",26.3,1.098],["California",3930,"blue",25.5,1.055],["Kentucky",453,"red",23.5,1.044],["Virginia",823,"blue",23.4,1.029],["Delaware",85,"blue",23.4,0.947],["West Virginia",174,"red",21.2,0.939],["Illinois",1159,"blue",24.6,0.903],["Pennsylvania",1129,"blue",22.0,0.889],["Montana",80,"red",22.6,0.809],["Maryland",428,"blue",23.7,0.741],["Indiana",365,"blue",24.7,0.563],["New York",1020,"blue",22.6,0.526],["Hawaii",62,"blue",22.4,0.456],["Vermont",27,"blue",20.3,0.431],["Maine",43,"blue",20.6,0.324],["New Hampshire",38,"blue",21.8,0.289],["New Jersey",253,"blue",23.5,0.288],["Connecticut",102,"blue",23.0,0.285],["Rhode Island",26,"blue",21.5,0.247],["Massachusetts",146,"blue",21.7,0.223],["District of Columbia",12,"blue",19.0,0.199]];
  var data_length = data.length;
  
  var facilities_data = new google.visualization.DataTable();
  facilities_data.addColumn('string', 'State');
  facilities_data.addColumn('number', 'Facilities Per 10,000 People');
  facilities_data.addColumn('number', 'Facilities Per 10,000 People');
  facilities_data.addRows(data_length);
  
  var facilities_map_data = new google.visualization.DataTable();
  facilities_map_data.addColumn('string', 'State');
  facilities_map_data.addColumn('number', 'Facilities Per 10,000 People');
  facilities_map_data.addRows(data_length);
  
  var facilities_youth_data = new google.visualization.DataTable();
  facilities_youth_data.addColumn('number', '% of population under 18');
  facilities_youth_data.addColumn('number', 'number of facilities');
  facilities_youth_data.addColumn('number', 'number of facilities');
  facilities_youth_data.addRows(data_length);
  
  for ( var i=0; i<data_length; i++ ){
    var facilities_pp = data[i][4];
    
    // bar graph  
    facilities_data.setValue(i, 0, data[i][0]);
    
    // scatter graph
    var youth = data[i][3];
    var state = data[i][0];
    var label = state + " / " + youth + "%";
    facilities_youth_data.setCell(i, 0, youth, label);
    
    if(data[i][2] === "blue"){
      facilities_data.setValue(i, 1, facilities_pp);
      facilities_data.setValue(i, 2, 0);
      facilities_youth_data.setValue(i, 1, facilities_pp);
      facilities_youth_data.setValue(i, 2, null);
    } else {
      facilities_data.setValue(i, 1, 0);
      facilities_data.setValue(i, 2, facilities_pp);
      facilities_youth_data.setValue(i, 1, null);
      facilities_youth_data.setValue(i, 2, facilities_pp);
    }
    
    // us map
    facilities_map_data.setValue(i, 0, data[i][0]);  
    facilities_map_data.setValue(i, 1, facilities_pp);
  }
  
  new google.visualization.ColumnChart(document.getElementById('facilities_pp_by_state')).draw(facilities_data, {width: 598, height: 320, legend: 'none', title: 'Number of Self Storage Facilities By State Per 10,000 People', isStacked: true, vAxis: {title: "Facilities Per 10,000 People"}, hAxis: {slantedTextAngle: 70}});

  // map      
  new google.visualization.GeoMap(document.getElementById('facilities_region')).draw(facilities_map_data, {region: 'US'});

  // scatter graph
  new google.visualization.ScatterChart(document.getElementById('facilities_youth')).draw(facilities_youth_data, {width: 598, height: 320, legend: 'none', title: 'Number of Self Storage Facilities Per 10,000 People and Percentage of Population Under 18', vAxis: {title: "Facilities Per 10,000 People"}, hAxis: {title: 'Percentage of Population Under 18'}});
}