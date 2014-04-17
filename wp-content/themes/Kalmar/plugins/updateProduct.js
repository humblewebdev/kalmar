$(document).ready(function()
		{
		 
		    var options = { 
		    beforeSend: function() 
		    {
		        $(".progress").show();
		        //clear everything
		        $(".progress-bar").width('0%');
		        $("#message").html("");
		        $("#percent").html("0%");
		    },
		    uploadProgress: function(event, position, total, percentComplete) 
		    {
		        $(".progress-bar").width(percentComplete+'%');
		        $("#percent").html(percentComplete+'%');
		 
		    },
		    success: function(output) 
		    {
		    	console.log(output);
		        $(".progress-bar").width('100%').parent('.progress').fadeOut(4000, function(){
		        	location.reload();
		        });
		        $("#percent").html('100%');
		    },
		    complete: function(response) 
		    {	  	
		        $("#message").html(response.responseText);
		    },
		    error: function()
		    {
		        $("#message").html("<div class='alert alert-danger> ERROR: unable to submit form</div>");
		 
		    }
		 
		}; 
		 
		     $(".editForm").ajaxForm(options);
		 
});