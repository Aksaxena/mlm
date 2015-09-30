function checkfield(quote)
{
	ok=true
	if(quote.fname.value=="")
	{
		alert("Please Enter Your Name.")
		quote.fname.focus()
		ok=false
	}
	else if (quote.email.value == "")
	{
		alert("Please enter a value for the email field.");
		quote.email.focus();
		ok=false
	}
	else if (!isEmailAddr(quote.email.value))
	{
		alert("Please enter a complete email address in the form: yourname@yourdomain.com");
		quote.email.focus();
		ok=false
	}
		else if(quote.mobile.value=="")
	{
		alert("Please Enter Mobile Number.")
		quote.mobile.focus()
		ok=false
	}
	else if (quote.comments.value == "")
	{
		alert("Please specify your requirements.");
		quote.comments.focus();
		ok=false
	}	
	return ok
}
function isEmailAddr(email)
{
  var result = false
  var theStr = new String(email)
  var index = theStr.indexOf("@");
  if (index > 0)
  {
	var pindex = theStr.indexOf(".",index);
	if ((pindex > index+1) && (theStr.length > pindex+1))
	result = true;
  }
  return result;
}