<html>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<style type="text/css">
		.bg-red {
			background-color: red;
			color: white;
		}
		.bg-green {
			background-color: green;
			color:white;
		}
		.center {
			width:30%;
			margin:auto;
		}
	</style>
	<body>
		<center><h2>Live Stock Feed</h2></center>

		<table class="table table-bordered center">
			<tr>
			<th>Ticker</th>
			<th>Price</th>
			<th>Last Updated</th>
			</tr>
		</table>
	</body>
</html>

<script type="text/javascript" src="https://code.jquery.com/jquery-3.2.0.min.js"></script>
<script type="text/javascript">
	var month = new Array();
	month[0]  = "Jan";
	month[1]  = "Feb";
	month[2]  = "Mar";
	month[3]  = "Apr";
	month[4]  = "May";
	month[5]  = "Jun";
	month[6]  = "Jul";
	month[7]  = "Aug";
	month[8]  = "Sep";
	month[9]  = "Oct";
	month[10] = "Nov";
	month[11] = "Dec";
    
    socket = new WebSocket("ws://stocks.mnet.website");
    
    socket.onmessage = function (e) {
        var obj = JSON.parse(e.data);
        obj.forEach( function(item) {     
        	var date  = new Date();
            date = month[date.getMonth()] + ' ' + date.getDate() + ' ' + date.toLocaleString('en-US', { hour: 'numeric',minute:'numeric', hour12: true });
        	
        	if( $('#'+item[0]).length == 0 ){
        		$('.table').append('<tr>'+
        			'<td id = "'+item[0]+'"> '+item[0]+' </td>'+
        			'<td> '+ Math.round(item[1] * 100) / 100 +' </td>'+
        			'<td> A few seconds ago </td>'+
        			'</tr>');
        	}
        	else {        		        
        		var value_cell = $('#'+item[0]).closest('td').next();
    			var date_cell = $('#'+item[0]).closest('td').next().next();

        		value_cell.removeClass('bg-red'); 
    			value_cell.removeClass('bg-green');

        		var previous_value = parseInt(value_cell.html());
        		var current_value =  parseInt(item[1]);
       
        		if(current_value < previous_value){        			
        			value_cell.addClass('bg-red'); 
        		} else {
        			value_cell.addClass('bg-green'); 
        		}
        		
        		value_cell.html(Math.round(item[1] * 100) / 100);
        		date_cell.html(date);
        	}
        });
    }
</script>