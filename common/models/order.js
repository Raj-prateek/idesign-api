
module.exports = function(Order) {
  Order.observe('after save', function(ctx, next) {
    var model = ctx.instance;
      Order.app.models.User.find({where: {id : model.createdby}}, function(err, res){
          if (err) throw err; //error making request
          if (res.error) {
            next('> response error: ' + res.error.stack);
          }
          model.user = res;
          Order.app.models.Requirement.find({where:{id:{inq:JSON.parse(model.requirementids)}}},function(err2,res2){
            if (err2) throw err2; //error making request
            if (res2.error) {
              next('> response error: ' + res2.error.stack);
            } 
            //model.requirementids = res2;
            let to = model.user[0].name +"<"+model.user[0].email+">";
            let from = "Soopla <noreply@soopla.com>";
            let subject = "Order Place Successfully!";
            let html ="<h2>Hi "+model.user[0].name+"</h2><br> Your Order was successfully placed. <br/> <b>Order Id:</b> "+model.id+"<br><br>Regards<br>Team Soopla<br><br>For any query:<br>056-7207500";
            Order.app.models.Email.send({
              to: to,
              from: from,
              subject: subject,
              html: html
            }, function(err, mail) {
              next();
            });
          });
      });
  });
};

