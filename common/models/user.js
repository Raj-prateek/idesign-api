module.exports = function(Users) {
   Users.on('dataSourceAttached', function(obj){
    var find = Users.find;
    Users.find = function(filter, cb) {
    	console.log(filter)
      return find.apply(this, arguments);
    };
  });
};
