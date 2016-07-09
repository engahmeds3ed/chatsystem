var chatApp = angular.module('chatApp', ["ngSanitize"]);

//new directive to submit message with Enter
chatApp.directive('submitEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13) {
            	if(event.shiftKey){
            		//do nothing
            	}else{
	            	scope.$apply(function (){
	                    scope.$eval(attrs.submitEnter);
	                });

	                event.preventDefault();
            	}
                
            }
        });
    };
});