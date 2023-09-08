// JavaScript Document
//Start :: jQuery Click Event :: or as you wish to handle the click event
    $("#confirm_button").click(function(){
        //Start :: DAlert Confirm Usage     
        dalert.confirm("Are You Sure?","DAlert Confirm !",function(result){
            if(result){
            dalert.alert("You've just clicked YES !");
            }
            else{
            dalert.alert("You've just clicked NO !");
            }
        });
        //End :: DAlert Confirm Usage
    });
//End :: jQuery Click Event :: or as you wish to handle the click event 