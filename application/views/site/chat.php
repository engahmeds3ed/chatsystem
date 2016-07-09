<?php $this->load->view($this->foldername.'/template/header'); ?>

<div id="chat" ng-app="chatApp" ng-controller="chatCtrl" ng-init="ajaxurl='<?php echo base_url("ajax"); ?>'">
	
	<div id="wrapper">

        <!-- Sidebar -->
        <div id="chat-sidebar">
        	<h2>Chat With:</h2>
            <ul id="chat-sidebar-list">
	            <li ng-repeat="user in allusers">
	            	<div class="{{user.status}} sidebar-user" ng-click="startChat(user)">
		            	<i class="fa fa-circle"></i>
		            	{{user.user_fullname}} - <span class="new-msg-count img-circle">{{user.newMsgCount}}</span>
	            	</div>
	            </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="chat-space">
            
	        <div class="chat-item" ng-repeat="user in openChats">
	        	<div class="chat-item-head">
	        		{{user.user.user_fullname}}
	        		<div class="chat-item-head-icons pull-right">
	        			<a href="#" class="chat-close" ng-click="closeChat(user.user)">
	        				<i class="fa fa-times" aria-hidden="true"></i>
	        			</a>
	        		</div><!-- .chat-item-head-icons -->
	        		<div class="clearfix"></div>
	        	</div><!-- .chat-item-head -->

	        	<div class="chat-item-body" id="chat-item-body_{{user.user.user_id}}">

	        		<div class="chat-item-body-msg" ng-repeat="msg in user.messages">
	        			<div class="chat-item-body-msg-sender">{{ (msg.from==user.user.user_id) ? user.user.user_fullname : "you" }}</div>
	        			{{msg.msg}}
	        			<div class="chat-item-body-msg-time">{{msg.msg_date}}</div>
	        		</div>

	        	</div><!-- .chat-item-body -->

	        	<div class="chat-item-foot">
	        		<?php echo form_textarea("msg","","class='form-control chat-item-foot-text' submit-enter='sendMsg(user.user,msgContent)' ng-model='msgContent' id='chat-item-foot-text_{{user.user.user_id}}'"); ?>
	        		<?php echo form_button("send_msg","<i class='fa fa-paper-plane'></i>","class='chat-item-foot-sendmsg' type='submit' ng-click='sendMsg(user.user,msgContent)'"); ?>
	        	</div><!-- .chat-item-foot -->

	        </div><!-- .chat-item -->

        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

</div><!-- #chat.row -->

<?php $this->load->view($this->foldername.'/template/footer'); ?>