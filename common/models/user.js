let utils = require('loopback-datasource-juggler/lib/utils');
const crypto = require('crypto');
const algorithm = 'aes-256-cbc';
const key = 'c528f898762e16bd722abb53fbd76a164dfc69c3dfacd4a7a2e92b495ddf92d5';/*crypto.randomBytes(32);*/
const iv = crypto.randomBytes(16)/*'c0bb9b8d1445c27b962314a1ae0fb500'*/;
module.exports = function(Users) {


	
	Users.on('dataSourceAttached', function(obj){
		var find = Users.find;
		Users.find = function(filter,user,cb){
			if(filter!=undefined && filter.where !=undefined && filter.where.password!= undefined)
			{	
				let pas  = encrypt(filter.where.password);
				filter.where.password =pas.encryptedData;
			}
			
			 cb = cb || utils.createPromiseCallback();
			 let result = find.call(this, filter, function(err, result) {
				
				if(result.length>0){
					if(result.length==1)
						result[0].password = decrypt({encryptedData: result[0].password});	
					else{
						for (var i = 0; i < result.length; i++) {
							result[i].password =decrypt({encryptedData: result[i].password});	
						}
					}

				}

				console.log('===result', result);
				return cb(err, result);
					
			});
		};
	});

	

	Users.observe('before save', function(obj,next){
		// console.log(Buffer.from(crypto.randomBytes(16),"hex").toString("hex"))
		let pas  = encrypt(obj.instance.password);
		obj.instance.password = pas.encryptedData;
		// console.log(obj.instance.password)
		next()
	});

	Users.observe('after save', function(obj,next){
		let pas  = decrypt({/*iv:iv,*/encryptedData: obj.instance.password});
		obj.instance.password = pas;
		// console.log(obj.instance.password)
		next()
	});
};


function encrypt(text) {
	 // let cipher = crypto.createCipheriv('aes-256-cbc', key, iv);
	 let cipher = crypto.createCipher('aes-256-cbc', key/*, iv*/);
	 let encrypted = cipher.update(text);
	 encrypted = Buffer.concat([encrypted, cipher.final()]);
	 return { /*iv: iv.toString('hex'),*/ encryptedData: encrypted.toString('hex') };
}

function decrypt(text) {
	 // let iv = Buffer.from(text.iv, 'hex');
	 let encryptedText = Buffer.from(text.encryptedData, 'hex');
	 let decipher = crypto.createDecipher('aes-256-cbc',key/*, iv*/);
	 // let decipher = crypto.createDecipheriv('aes-256-cbc',key, iv);
	 let decrypted = decipher.update(encryptedText);
	 decrypted = Buffer.concat([decrypted, decipher.final()]);
	 return decrypted.toString();
}