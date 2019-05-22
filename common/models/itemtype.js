module.exports = function(ItemType) {
   ItemType.on('dataSourceAttached', function(obj){
    var find = ItemType.find;
    ItemType.find = function(filter, cb) {
    	console.log(filter)
      return find.apply(this, arguments);
    };
  });
};
