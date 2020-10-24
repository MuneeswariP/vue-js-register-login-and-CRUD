
<!DOCTYPE html>
<html>
 <head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>PHP Insert Update Delete with Vue.js</title>
  <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
  <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/vee-validate@3.3.8/dist/vee-validate.min.js"></script>
   <script src="https://cdn.jsdelivr.net/npm/vee-validate@3.3.8/dist/rules.umd.js"></script>
  <style>
   .modal-mask {
     position: fixed;
     z-index: 9998;
     top: 0;
     left: 0;
     width: 100%;
     height: 100%;
     background-color: rgba(0, 0, 0, .5);
     display: table;
     transition: opacity .3s ease;
   }

   .modal-wrapper {
     display: table-cell;
     vertical-align: middle;
   }
   .reg-body {
	margin: 0 auto;
	width: 45%;
}
a {
	cursor: pointer;
}
@media only screen and (max-width: 600px) {
 .reg-body {
	margin: 0 auto;
	width: 90%;
}
}

  </style>
 </head>
 <body>
  <div class="container" id="crudApp">
   <br />
   <h3 align="center">Register</h3>
   <br />
   
         <div class="reg-body">
			<div class="col-md-12">
				  <div class="form-group col-md-6">
				   <label>Enter First Name</label>
				   <input type="text" class="form-control" v-model="first_name" />
				  </div>
				  <div class="form-group col-md-6">
				   <label>Enter Last Name</label>
				   <input type="text" class="form-control" v-model="last_name" />
				  </div>
			</div>
			<div class="col-md-12">
				   <div class="form-group col-md-6">
				   <label>Enter Phone Number</label>
				   <input type="text" class="form-control" v-model="phone_number" @change="isPhoneValid"/>
				   <span v-show="wrongPhone" style="color:red">Incorrect Phone Number</span>
				  </div>
				  <div class="form-group col-md-6">
				   <label>Enter Email Id</label>
				   <input type="text" class="form-control" v-model="email_id" @change="isEmailValid"/>
				   <span v-show="wrongEmail" style="color:red">Incorrect email address</span>
				  </div>
			</div>
			<div class="col-md-12">
					<div class="form-group col-md-6">
				   <label>Enter Password</label>
				   <input type="password"  class="form-control" v-model="password" />
				  
				  </div>
				  <div class="form-group col-md-6">
				   <label>Confirm Password</label>
				   <input type="password"  class="form-control"  v-model="cpassword" />
					
				  </div>
			</div>	  
		  <div class="form-group">
           <label>Role</label>
		   <select class="form-control" v-model="role">
				<option value="">choose role</option>
				<option value="1">admin</option>
				<option value="2">user</option>
		   </select>
		   
           
          </div>
          <br />
          <div align="center">
           <input type="hidden" v-model="hiddenId" />
           <input type="button" class="btn btn-success btn-xs" value="Register" @click="submitData" />
          </div>
		
		  <!-- Login Popup -->
		   <div class="col-md-12" align="center">
		   <p>Already Have an Account <a @click="openModel">Login Here</a></p>
		  
		  </div>
				<div v-if="myModel">
						<transition name="model">
						 <div class="modal-mask">
						  <div class="modal-wrapper">
						   <div class="modal-dialog">
							<div class="modal-content">
							 <div class="modal-header">
							  <button type="button" class="close" @click="myModel=false"><span aria-hidden="true">&times;</span></button>
							  <h4 class="modal-title">{{ dynamicTitle }}</h4>
							 </div>
							 <div class="modal-body">
							  <div class="form-group">
							   <label>Email Id</label>
							   <input type="text" class="form-control" v-model="loginemail_Id" />
							  </div>
							  <div class="form-group">
							   <label>Password</label>
							   <input type="password" class="form-control" v-model="loginpassword" />
							  </div>
							   
							  <br />
							  <div align="center">
							   <input type="button" class="btn btn-success btn-xs" value="Login" @click="logindata" />
							  </div>
							 </div>
							</div>
						   </div>
						  </div>
						 </div>
						</transition>
					   </div>
         </div>
        </div>
    
 </body>
</html>

<script>
 const  phonereg = /^[0-9]*$/;
const emailRe = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
var application = new Vue({
 el:'#crudApp',
 data:{
  allData:'',
  first_name:'',
  last_name:'',
  phone_number:'',
  password:'',
  cpassword:'',
   role:'',
  email_id:'',
  hiddenId:'',
  passworderror:'',
  keywords: '',
  wrongPhone:'',
  loginemail_Id: '',
  loginpassword: '',
  myModel:false,
  wrongEmail: false,
  actionButton:'Insert',
  dynamicTitle:'Add Data',


 },
 methods:{
	    isEmailValid() {
			  if (emailRe.test(this.email_id)) {
				this.wrongEmail = false;
				e.preventDefault();
			  } else {
				this.wrongEmail = true;
			  }
		},
		isPhoneValid() {
			  if (phonereg.test(this.phone_number)) {
				this.wrongPhone = false;
				e.preventDefault();
			  } else {
				this.wrongPhone = true;
			  }
		},
	checkpassword:function(event) {

       const value = event.target.value;
        this.keywords = value;
		
		/*firstName:application.first_name; 
		lastName:application.last_name;
		 password:application.password;
		 if(value != password)
		 {
         application.passworderror = 'you are enter some key!!';
		 }
		 */
		 application.passworderror = 'you are enter some key!!';
    },


	 /* After insert show all data */
	  fetchAllData:function(){
	   axios.post('action.php', {
		action:'fetchall'
	   }).then(function(response){
		application.allData = response.data;
	   });
	  },
	  
	  /* Fetch login */  		  
		  logindata:function(){
		   if(application.loginemail_Id != '' && application.loginpassword != '' )
		   {
			axios.post('action.php', {
			 action:'login',
			 PassLogin:application.loginpassword,
			 EmilLogin:application.loginemail_Id
			 
			}).then(function(response){
				 application.myModel = false;
			   if(response.data.id == '1')
			   {	
					if(response.data.userrole == '1')
					{
						window.location.href = 'admindashboard.php';
					}
					else if(response.data.userrole == '2')
					{
						window.location.href = 'user.php';
					}
			   }
			   else
			   {
				   alert("please enter valid data");
			   }
			});
		   }
		  },
		
	  
	 /* Show register popup */ 
	  openModel:function(){
	   application.email_id = '';
	   application.password = '';
	   application.actionButton = "Login";
	   application.dynamicTitle = "Exsisting Customer";
	   application.myModel = true;
	  },
	  
	 /* Form Submit for database */  
		  submitData:function(){
		   if(application.first_name != '' && application.last_name != '' && application.password != '' && application.role != ''  && application.phone_number != '' && application.email_id != '')
		   {
			
			if(application.password != application.cpassword)
			{
				alert("passwords not same");
			}
			else if( !emailRe.test(application.email_id)) {
				alert("Please enter correct Email id");
				e.preventDefault();
			  }
			else if( !phonereg.test(this.phone_number)) {
				alert("Please enter correct Valid Phone Number");
				e.preventDefault();
			  }
			else{
				if(application.actionButton == 'Insert')
				{
				 axios.post('action.php', {
				  action:'insert',
				  firstName:application.first_name, 
				  lastName:application.last_name,
				  phoneNumber:application.phone_number,
				   password:application.password,
				   userRole:application.role,
				  emailId:application.email_id
				 }).then(function(response){
				  application.fetchAllData();
				  application.first_name = '';
				  application.last_name = '';
				  application.phone_number = '';
				  application.email_id = '';
				  application.password = '';
				   application.cpassword = '';
				  alert(response.data.message);
				 });
				}
				if(application.actionButton == 'Update')
				{
				 axios.post('action.php', {
				  action:'update',
				  firstName : application.first_name,
				  lastName : application.last_name,
				  hiddenId : application.hiddenId
				 }).then(function(response){
				  application.myModel = false;
				  application.fetchAllData();
				  application.first_name = '';
				  application.last_name = '';
				  application.hiddenId = '';
				  alert(response.data.message);
				 });
				}
			}
		   }
		   else
		   {
			alert("Fill All Field");
		   }
		  }
 },
 
		  
 
		
 created:function(){
  this.fetchAllData();
 }
});

</script>

