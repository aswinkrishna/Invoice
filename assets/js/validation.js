// JavaScript Document
    // Restrict user input in a text field
    // create as many regular expressions here as you need:
    var digitsOnly = /[1234567890]/g;
    var integerOnly = /[0-9\.]/g;
    var alphaOnly = /[A-Za-z]/g;
    var usernameOnly = /[A-Za-z\._-]/g;

    function restrictInput(myfield, e, restrictionType, checkdot){
        if (!e) var e = window.event
        if (e.keyCode) code = e.keyCode;
        else if (e.which) code = e.which;
        var character = String.fromCharCode(code);

        // if user pressed esc... remove focus from field...
        if (code==27) { this.blur(); return false; }

        // ignore if the user presses other keys
        // strange because code: 39 is the down key AND ' key...
        // and DEL also equals .
        if (!e.ctrlKey && code!=9 && code!=8 && code!=36 && code!=37 && code!=38 && (code!=39 || (code==39 && character=="'")) && code!=40) {
            if (character.match(restrictionType)) {
                if(checkdot == "checkdot"){
                    return !isNaN(myfield.value.toString() + character);
                } 
				else 
				{
                    return true;
                }
            } 
			else 
			{
                return false;
            }
        }
    }
    