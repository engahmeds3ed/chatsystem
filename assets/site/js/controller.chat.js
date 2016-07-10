chatApp.controller('chatCtrl', function($scope,$interval,$http,$timeout) {
	$scope.openChats = new Object();
    $scope.allusers = [
    	{user_id: 0, user_fullname: "Loading...",status: "offline",newMsgCount: 0}
    ];

    $scope.getUsers = function(){
    	$http({
			method : "POST",
			url : $scope.ajaxurl + "/getUsers"
		}).then(function mySucces(response) {
			$scope.allusers = response.data;
			$scope.allusers.forEach(function(user) {
			    if(user.newMsgCount > 0){
			    	$scope.startChat(user);
			    }
			});
		}, function myError(response) {
			console.log(response.statusText);
		});
    };

    $scope.$watch('getUsers', function () {
    	$scope.getUsers();
    	$interval(function () { $scope.getUsers(); }, 5000);
	});

    $scope.startChat = function(user){
    	var messages = new Object();
    	$scope.openChats[user.user_id] = {user: user, messages: messages};
    	var forceScroll = 1;
    	$scope.refreshChat(user,forceScroll);
		window['userChat_'+user.user_id] = $interval(function () { $scope.refreshChat(user); }, 5000);
    };

    $scope.closeChat = function(user){
    	$interval.cancel( window['userChat_'+user.user_id] );
    	delete $scope.openChats[user.user_id];
    };

	$scope.refreshChat = function(user,forceScroll){
		var messages = new Object();

    	$http({
			method : "POST",
			url : $scope.ajaxurl + "/getMessages/"+user.user_id
		}).then(function mySucces(response) {
			messages = response.data;
			$scope.openChats[user.user_id]['messages'] = messages;
			if(forceScroll == 1){
				//scroll down
				$timeout(function () {
					$('#chat-item-body_'+user.user_id).animate({
					   scrollTop: $('#chat-item-body_'+user.user_id)[0].scrollHeight
					}, 'slow');
				}, 100);
			}
		}, function myError(response) {
			console.log(response.statusText);
		});
	};

	$scope.sendMsg = function(user,msgContent){
		$http({
			method : "POST",
			url : $scope.ajaxurl + "/saveMsg",
			data: {toUserid: user.user_id,msgContent: msgContent}
		}).then(function mySucces(response) {
			if(response.data.status == "success"){
				//refresh chat
				var forceScroll = 1;
				$scope.refreshChat(user,forceScroll);
				//clear msg content
				$('#chat-item-foot-text_'+user.user_id).val("");
				
			}else{
				console.log(response.data.msg);
			}
		}, function myError(response) {
			console.log(response.statusText);
		});
	};



});

