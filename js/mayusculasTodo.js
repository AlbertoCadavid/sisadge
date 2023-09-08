$(document).ready( function () {

                      $("input, textarea").on("keypress", function () {
                       $input=$(this);
                       setTimeout(function () {
                        $input.val($input.val().toUpperCase());
                       },50);
                      })



                      
                  });