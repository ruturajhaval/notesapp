<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
	<title>Notes</title>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
</head>
<body class="container-fluid">
	<x-menu/>
		
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<h3>Notes</h3>
			</div>
		</div>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="notes list-group">
				</div>
			</div>
		</div>
	</div>
	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		// var html = '<a href="#" class="list-group-item active"><h4 class="list-group-item-heading">List group item heading</h4><p class="list-group-item-text">...</p></a>';
		var html = '';
		$(document).ready(function(){
		    $.ajax({
		      	url: 'http://127.0.0.1:8000/api/notes',
		      	type: 'GET',
		      	dataType: 'json',
		      	success: function(data, textStatus, xhr) {
		      		for(var i = 0, length1 = data.length; i < length1; i++){
		      			var tags = data[i].uk_tagname.split(',');
		      			var tagshtml = '';
		      			for(var j = 0, length2 = tags.length; j < length2; j++){
		      				tagshtml += '<span class="label label-default">'+tags[j]+'</span>&nbsp;';
		      			}
		      			html += '<a href="#" class="list-group-item" style="margin-bottom:5px;"><h4 class="list-group-item-heading">' + data[i].uk_title + '</h4><p class="list-group-item-text">' + data[i].description + '</p>'+tagshtml+'</a>';
		      		}
			      	  	console.log(data);
		      		$('.list-group').html(html);
		      	},
		      	error: function(xhr, textStatus, errorThrown) {
		      	   alert(errorThrown);
		      	}
		    });
		});
	</script>
</body>
</html>