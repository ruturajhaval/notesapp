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
			<div class="col-md-3">
				<div class="h3">Notes </div>
			</div>
			<div class="col-md-3">
				<div class="h4">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
				  	Add notes
				</button>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<h1></h1>
		</div>
	</div>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<div class="notes list-group">
				</div>
			</div>
		</div>
	</div>


<!-- Button trigger modal -->
<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
        <form id="idForm">
      <div class="modal-header">
        <h3 class="modal-title" id="exampleModalLabel">Add Notes</h3>
        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button> -->
      </div>
      <div class="modal-body">
		  	<div class="form-group">
		  	  	<label for="title">Title</label>
		  	  	<input type="text" class="form-control" id="title" name="title" placeholder="Title">
		  	</div>
		  	<div class="form-group">
		  	  	<label for="description">Description</label>
		  	  	<textarea class="form-control" name="description" id='description'></textarea>
		  	</div>
		  	<div class="tag-checkbox form-check">
		  	</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
	  	<button type="submit" class="btn btn-primary">Submit</button>
      </div>
		</form>
    </div>
  </div>
</div>



	
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
	<script>
		// var html = '<a href="#" class="list-group-item active"><h4 class="list-group-item-heading">List group item heading</h4><p class="list-group-item-text">...</p></a>';
		var html = '';
		var taglist = '';
		$(document).ready(function(){
		    $.ajax({
		      	url: 'http://127.0.0.1:8000/api/notes',
		      	type: 'GET',
		      	dataType: 'json',
		      	success: function(data, textStatus, xhr) {
		      		for(var i = 0, length1 = data.length; i < length1; i++){
		      			var tags = data[i].tagname.split(',');
		      			var tagshtml = '';
		      			for(var j = 0, length2 = tags.length; j < length2; j++){
		      				tagshtml += '<span class="label label-default">'+tags[j]+'</span>&nbsp;';
		      			}
		      			html += '<a href="#" class="list-group-item" style="margin-bottom:5px;"><h4 class="list-group-item-heading">' + data[i].title + '</h4><p class="list-group-item-text">' + data[i].description + '</p>'+tagshtml+'</a>';
		      		}
			      	  	console.log(data);
		      		$('.list-group').html(html);
		      	},
		      	error: function(xhr, textStatus, errorThrown) {
		      	   alert(errorThrown);
		      	}
		    });
		    $.ajax({
		      	url: 'http://127.0.0.1:8000/api/tags',
		      	type: 'GET',
		      	dataType: 'json',
		      	success: function(data, textStatus, xhr) {
		      		for(var i = 0, length1 = data.length; i < length1; i++){
		      			taglist += '<input class="form-check-input" type="checkbox" id="tags" name="tags" value="'+data[i].id+'"> '+data[i].tagname+'<br>';
		      		}
			      	  	console.log(data);
		      		$('.tag-checkbox').empty();
		      		$('.tag-checkbox').html(taglist);
		      	},
		      	error: function(xhr, textStatus, errorThrown) {
		      	   alert(errorThrown);
		      	}
		    });

		    $("#idForm").submit(function(e) {
		    	var tagarray = [];
			    e.preventDefault(); // avoid to execute the actual submit of the form.

			    var title = $("#title").val();
			    var description = $("#description").val();

			    $("input:checkbox[name=tags]:checked").each(function(){
				    tagarray.push($(this).val());
				});
			    var postdata = {"title":title,"description":description,"tags":tagarray.toString()};
			    $.ajax({
		           	type: "POST",
		           	url: 'http://127.0.0.1:8000/api/notes',
		           	data: postdata, // serializes the form's elements.
		           	success: function(data)
		           	{
		           	    console.log(data); // show response from the php script.
		           	    location.reload();
		           	}
		        });
			});
		});
	</script>
</body>
</html>