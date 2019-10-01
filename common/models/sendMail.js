// Copyright IBM Corp. 2016. All Rights Reserved.
// Node module: loopback-workspace
// This file is licensed under the MIT License.
// License text available at https://opensource.org/licenses/MIT

module.exports = function(SendMail) {
  SendMail.sendMail = function(type,forA,cb){

    switch(type){
      //Forget Password
      case 1:
        SendMail.app.models.User.find({where: {email : forA}}, function(err, res){
          if (err) throw err;
          if (res.error) {
            cb('> response error: ' + res.error.stack);
          }
          if (res.length>0){
            let html ="<h2>Hi "+res[0].name+"</h2><br> Your password is <b>"+res[0].password+"</b>. <br><br>Regards<br>Team Soopla<br><br>For any query:<br>056-7207500";
            let option = {
              to: res[0].name+' <'+res[0].email+'>',
              from: 'Soopla <noreply@soopla.com>',
              subject: 'Your Soopla Password',
              text: html,
              html: html
            };
            console.log(option)

            SendMail.app.models.Email.send(option, function(err, mail) {
              if (err) throw err;
				if (res.error) {
					cb('> response error: ' + res.error.stack);
				}
              cb(null,"success",1)
            });  
          }else{
            cb(null,"Email does not exists.",0)

          }
          
        });

        break;
    }
    
    

  };
};
