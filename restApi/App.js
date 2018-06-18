
var express = require("express"); 
var app = express();
var soapServer = 'http://soap.payco.com/index.php';
var userEndpoint  = '/usuario/soap';
var soap = require('soap');


var bodyParser = require('body-parser');
app.use(bodyParser.json()); // soporte para bodies codificados en jsonsupport
app.use(bodyParser.urlencoded({ extended: true })); // soporte para bodies codificados

//Usuarios
//crear
app.get('/crear/usuario', function(req, res, next) {
  	 if(req.query.filter) {
	   next();
	   return;
	  }
    var args = {
        nombre :  'Juan David Marulanda V.',
        correo : 'juandavidmarulanda@yahoo.com',
        numeroIdentificacion : '15371377',
        celular:'3185668227'
	};
    soap.createClient(soapServer+userEndpoint+'?wsdl',function(err,client){
        if(err)
            console.log(err);
        else {
            client.crearusuario(args,function(err,response){
                if(err)
                    console.log(err);
                else {
                    console.log(response);
                    res.send(response);

                }
            })
        }
    });

});

var server = app.listen(8080, function () {
    console.log('Servidor corriendo puerto 8080'); 
});