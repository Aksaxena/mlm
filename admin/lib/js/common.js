function raiseError(errArr) {
	str = "";
	for(i=0;i<errArr.length;i++) {
		str += errArr[i]+"<br>";
	}
	$("#errorboxcontent").html(str);
	
	if(document.getElementById('errorbox').style.display=='none') {
	$("#errorbox").show("slow");
	}
	return false;
}
$(function () {
    var minlength = 5;
	
	// for the sponsor id
    $("#sponsor_id").keyup(function () {
        var that = this,
        value = $(this).val();

        if (value.length >= minlength ) {
            $.ajax({
                type: "POST",
                url: "ajaxRequest.php",
                data: {
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
					$('#sponsorUser').html(msg);
                    //we need to check if the value is the same
                    if (value==$(that).val()) {
                    //Receiving the result of search here
						
                    }
                }
            });
        }
    });
	
	// for the parent id 
	$("#parent_id").keyup(function () {
        var that = this,
        value = $(this).val();

        if (value.length >= minlength ) {
            $.ajax({
                type: "POST",
                url: "ajaxRequest.php",
                data: {
                    'search_keyword' : value
                },
                dataType: "text",
                success: function(msg){
                    //we need to check if the value is the same
					$('#parentUser').html(msg);
                    if (value==$(that).val()) {
                    //Receiving the result of search here
					
                    }
                }
            });
        }
    });
	
});