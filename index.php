<?php
/**
 * Step 1: Require the Slim Framework
 *
 * If you are not using Composer, you need to require the
 * Slim Framework and register its PSR-0 autoloader.
 *
 * If you are using Composer, you can skip this step.
 */

/* Librerias */
require 'Slim/Slim.php';
require 'includes/meekrodb.2.2.class.php';
require 'includes/functions.php';



\Slim\Slim::registerAutoloader();
/* Conexion a la base de datos */
DB::$user='root';
DB::$password = 'Hola.1234';
DB::$dbName = 'sismos';
DB::$host = 'localhost';
DB::$encoding = 'utf8';
$app = new \slim\slim();


// GET route
$app->get(
    '/',
    function () {
        $template = <<<EOT
<!DOCTYPE html>
    <html>
        <head>
            <meta charset="utf-8"/>
            <title>Slim Framework for PHP 5</title>
            <style>
                html,body,div,span,object,iframe,
                h1,h2,h3,h4,h5,h6,p,blockquote,pre,
                abbr,address,cite,code,
                del,dfn,em,img,ins,kbd,q,samp,
                small,strong,sub,sup,var,
                b,i,
                dl,dt,dd,ol,ul,li,
                fieldset,form,label,legend,
                table,caption,tbody,tfoot,thead,tr,th,td,
                article,aside,canvas,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section,summary,
                time,mark,audio,video{margin:0;padding:0;border:0;outline:0;font-size:100%;vertical-align:baseline;background:transparent;}
                body{line-height:1;}
                article,aside,details,figcaption,figure,
                footer,header,hgroup,menu,nav,section{display:block;}
                nav ul{list-style:none;}
                blockquote,q{quotes:none;}
                blockquote:before,blockquote:after,
                q:before,q:after{content:'';content:none;}
                a{margin:0;padding:0;font-size:100%;vertical-align:baseline;background:transparent;}
                ins{background-color:#ff9;color:#000;text-decoration:none;}
                mark{background-color:#ff9;color:#000;font-style:italic;font-weight:bold;}
                del{text-decoration:line-through;}
                abbr[title],dfn[title]{border-bottom:1px dotted;cursor:help;}
                table{border-collapse:collapse;border-spacing:0;}
                hr{display:block;height:1px;border:0;border-top:1px solid #cccccc;margin:1em 0;padding:0;}
                input,select{vertical-align:middle;}
                html{ background: #EDEDED; height: 100%; }
                body{background:#FFF;margin:0 auto;min-height:100%;padding:0 30px;width:440px;color:#666;font:14px/23px Arial,Verdana,sans-serif;}
                h1,h2,h3,p,ul,ol,form,section{margin:0 0 20px 0;}
                h1{color:#333;font-size:20px;}
                h2,h3{color:#333;font-size:14px;}
                h3{margin:0;font-size:12px;font-weight:bold;}
                ul,ol{list-style-position:inside;color:#999;}
                ul{list-style-type:square;}
                code,kbd{background:#EEE;border:1px solid #DDD;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:0 4px;color:#666;font-size:12px;}
                pre{background:#EEE;border:1px solid #DDD;border-radius:4px;-moz-border-radius:4px;-webkit-border-radius:4px;padding:5px 10px;color:#666;font-size:12px;}
                pre code{background:transparent;border:none;padding:0;}
                a{color:#70a23e;}
                header{padding: 30px 0;text-align:center;}
            </style>
        </head>
        <body>
            <header>
                <a href="http://www.slimframework.com"><img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAHIAAAA6CAYAAABs1g18AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAABRhJREFUeNrsXY+VsjAMR98twAo6Ao4gI+gIOIKOgCPICDoCjCAjXFdgha+5C3dcv/QfFB5i8h5PD21Bfk3yS9L2VpGnlGW5kS9wJMTHNRxpmjYRy6SycgRvL18OeMQOTYQ8HvIoJKiiz43hgHkq1zvK/h6e/TyJQXeV/VyWBOSHA4C5RvtMAiCc4ZB9FPjgRI8+YuKcrySO515a1hoAY3nc4G2AH52BZsn+MjaAEwIJICKAIR889HljMCcyrR0QE4v/q/BVBQva7Q1tAczG18+x+PvIswHEAslLbfGrMZKiXEOMAMy6LwlisQCJLPFMfKdBtli5dIihRyH7A627Iaiq5sJ1ThP9xoIgSdWSNVIHYmrTQgOgRyRNqm/M5PnrFFopr3F6B41cd8whRUSufUBU5EL4U93AYRnIWimCIiSI1wAaAZpJ9bPnxx8eyI3Gt4QybwWa6T/BvbQECUMQFkhd3jSkPFgrxwcynuBaNT/u6eJIlbGOBWSNIUDFEIwPZFAtBfYrfeIOSRSXuUYCsprCXwUIZWYnmEhJFMIocMDWjn206c2EsGLCJd42aWSyBNMnHxLEq7niMrY2qyDbQUbqrrTbwUPtxN1ZZCitQV4ZSd6DyoxhmRD6OFjuRUS/KdLGRHYowJZaqYgjt9Lchmi3QYA/cXBsHK6VfWNR5jgA1DLhwfFe4HqfODBpINEECCLO47LT/+HSvSd/OCOgQ8qE0DbHQUBqpC4BkKMPYPkFY4iAJXhGAYr1qmaqQDbECCg5A2NMchzR567aA4xcRKclI405Bmt46vYD7/Gcjqfk6GP/kh1wovIDSHDfiAs/8bOCQ4cf4qMt7eH5Cucr3S0aWGFfjdLHD8EhCFvXQlSqRrY5UV2O9cfZtk77jUFMXeqzCEZqSK4ICkSin2tE12/3rbVcE41OBjBjBPSdJ1N5lfYQpIuhr8axnyIy5KvXmkYnw8VbcwtTNj7fDNCmT2kPQXA+bxpEXkB21HlnSQq0gD67jnfh5KavVJa/XQYEFSaagWwbgjNA+ywstLpEWTKgc5gwVpsyO1bTII+tA6B7BPS+0PiznuM9gPKsPVXbFdADMtwbJxSmkXWfRh6AZhyyzBjIHoDmnCGaMZAKjd5hyNJYCBGDOVcg28AXQ5atAVDO3c4dSALQnYblfa3M4kc/cyA7gMIUBQCTyl4kugIpy8yA7ACqK8Uwk30lIFGOEV3rPDAELwQkr/9YjkaCPDQhCcsrAYlF1v8W8jAEYeQDY7qn6tNGWudfq+YUEr6uq6FZzBpJMUfWFDatLHMCciw2mRC+k81qCCA1DzK4aUVfrJpxnloZWCPVnOgYy8L3GvKjE96HpweQoy7iwVQclVutLOEKJxA8gaRCjSzgNI2zhh3bQhzBCQQPIHGaHaUd96GJbZz3Smmjy16u6j3FuKyNxcBarxqWWfYFE0tVVO1Rl3t1Mb05V00MQCJ71YHpNaMcsjWAfkQvPPkaNC7LqTG7JAhGXTKYf+VDeXAX9IvURoAwtTFHvyYIxtnd5tPkywrPafcwbeSuGVwFau3b76NO7SHQrvqhfFE8kM0Wvpv8gVYiYBlxL+fW/34bgP6bIC7JR7YPDubcHCPzIp4+cum7U6NlhZgK7lua3KGLeFwE2m+HblDYWSHG2SAfINuwBBfxbJEIuWZbBH4fAExD7cvaGVyXyH0dhiAYc92z3ZDfUVv+jgb8HrHy7WVO/8BFcy9vuTz+nwADAGnOR39Yg/QkAAAAAElFTkSuQmCC" alt="Slim"/></a>
            </header>
            <h1>Welcome to Slim!</h1>
            <p>
                Congratulations! Your Slim application is running. If this is
                your first time using Slim, start with this <a href="http://docs.slimframework.com/#Hello-World" target="_blank">"Hello World" Tutorial</a>.
            </p>
            <section>
                <h2>Get Started</h2>
                <ol>
                    <li>The application code is in <code>index.php</code></li>
                    <li>Read the <a href="http://docs.slimframework.com/" target="_blank">online documentation</a></li>
                    <li>Follow <a href="http://www.twitter.com/slimphp" target="_blank">@slimphp</a> on Twitter</li>
                </ol>
            </section>
            <section>
                <h2>Slim Framework Community</h2>

                <h3>Support Forum and Knowledge Base</h3>
                <p>
                    Visit the <a href="http://help.slimframework.com" target="_blank">Slim support forum and knowledge base</a>
                    to read announcements, chat with fellow Slim users, ask questions, help others, or show off your cool
                    Slim Framework apps.
                </p>

                <h3>Twitter</h3>
                <p>
                    Follow <a href="http://www.twitter.com/slimphp" target="_blank">@slimphp</a> on Twitter to receive the very latest news
                    and updates about the framework.
                </p>
            </section>
            <section style="padding-bottom: 20px">
                <h2>Slim Framework Extras</h2>
                <p>
                    Custom View classes for Smarty, Twig, Mustache, and other template
                    frameworks are available online in a separate repository.
                </p>
                <p><a href="https://github.com/codeguy/Slim-Extras" target="_blank">Browse the Extras Repository</a></p>
            </section>
        </body>
    </html>
EOT;
        echo $template;
    }
);

// POST route
$app->post(
    '/post',
    function () {
        echo 'This is a POST route';
    }
);

// PUT route
$app->put(
    '/put',
    function () {
        echo 'This is a PUT route';
    }
);

// PATCH route
$app->patch('/patch', function () {
    echo 'This is a PATCH route';
});

// DELETE route
$app->delete(
    '/delete',
    function () {
        echo 'This is a DELETE route';
    }
);


/**************************Metodo Get ****************************/
//Consultar tabla de Contacto
$app->get('/contacto', function() use ($app){
    $points = DB:: query("SELECT Nombre_Persona, Correo,Mensaje FROM Contacto");
    $app->response()->header('Content-Type','application/json; charset=utf-8');
    array_walk($points, 'utf8_encode_array');
    echo json_encode($points);
});

//Consultar tabla de PG
$app->get('/consultapg', function() use ($app){
    $points = DB:: query("SELECT v.NS_V, v.EO_V, v.Z_V,e.NS_E, e.EO_E, e.Z_E,a.NS_A, a.EO_A, a.Z_A,d.NS_D, d.EO_D, d.Z_D
FROM Velocidad AS v 
INNER JOIN Espectro AS e ON e.ID_Espectros = v.ID_Velocidad 
INNER JOIN Aceleracion as a ON a.ID_Aceleracion = e.ID_Espectros 
INNER JOIN Desplazamiento as d ON d.ID_Desplazamiento = v.ID_Velocidad");
    $app->response()->header('Content-Type','application/json; charset=utf-8');
    array_walk($points, 'utf8_encode_array');
    echo json_encode($points);
});

//Consulta de estaciones
$app->get('/estaciones', function() use ($app){
    $points = DB:: query("SELECT Nombre_Estacion, Sitio, Latitud_Estacion, Longitud_Estacion FROM Estaciones");
    $app->response()->header('Content-Type','application/json; charset=utf-8');
    array_walk($points, 'utf8_encode_array');
    echo json_encode($points);
});

//Consulta de Sismos
$app->get('/sismos', function() use ($app){
    $points = DB:: query("SELECT Nombre_Sismo,Fecha,Hora,Latitud_Sismo, Longitud_Sismo FROM Sismo");
    $app->response()->header('Content-Type','application/json; charset=utf-8');
    array_walk($points, 'utf8_encode_array');
    echo json_encode($points);
});

//Consulta de Sismo con estaciones
$app->get('/conssultasismo', function() use ($app){
    $points = DB:: query("SELECT s.Nombre_Sismo, s.Fecha, s.Hora, s.Magnitud, e.Nombre_Estacion
FROM Sismo AS s INNER JOIN Estacion AS e ON e.ID_Estacion = s.Estaciones");
    $app->response()->header('Content-Type','application/json; charset=utf-8');
    array_walk($points, 'utf8_encode_array');
    echo json_encode($points);
});


/*****************************Metodo POST****************************************/
//POST para INSERTAR tabla Texto
$app->post('/insertartema', function () use($db, $app) {
            $Nombre=$_POST['Nombre_Tema'];
            $Descripcion=$_POST['Descripcion'];
            $Lugar=$_POST['Lugar'];

            $insert = DB:: query("INSERT INTO Texto(Nombre_Tema,Descripcion,Lugar) VALUES('$Nombre','$Descripcion','$Lugar')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });

// POST para insertar tabla Contacto
$app->post('/insertarcontacto', function () use($db, $app) {
            $Nombre=$_POST['Nombre_Persona'];
            $Correo=$_POST['Correo'];
            $Mensaje=$_POST['Mensaje'];

            $insert = DB:: query("INSERT INTO Contacto (Nombre_Persona,Correo,Mensaje) VALUES('$Nombre','$Correo','$Mensaje')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });

// POST para insertar tabla Estaciones
$app->post('/insertarestaciones', function () use($db, $app) {
            $Nombre=$_POST['Nombre_Estacion'];
            $Sitio=$_POST['Sitio'];
            $Lat_Estacion=$_POST['Latitud_Estacion'];
            $Long_Estacion=$_POST['Longitud_Estacion'];
            $Elevacion=$_POST['Elevacion'];
            $Aceleracion_Estacion=$_POST['Aceleracion_Estacion'];
            $GPS=$_POST['GPS'];
            $Velocidad=$_POST['Velocidad_Estacion'];
            $Digitalizador=$_POST['Digitalizador_Estacion'];
            $Niveles=$_POST['Niveles'];

            $insert = DB:: query("INSERT INTO Estaciones(Nombre_Estacion,Sitio,Latitud_Estacion, Longitud_Estacion, Elevacion,Aceleracion_Estacion, GPS, Velocidad_Estacion,Digitalizador_Estacion,Niveles) VALUES('$Nombre','$Sitio','$Lat_Estacion','$Long_Estacion','$Elevacion','$Aceleracion_Estacion','$GPS','$Velocidad','$Digitalizador','$Niveles')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });

// POST para insertar tabla Velocidad
$app->post('/insertarvelocidad', function () use($db, $app) {
            $Nortesur=$_POST['NS_V'];
            $Esteoeste=$_POST['EO_V'];
            $Z=$_POST['Z_V'];

            $insert = DB:: query("INSERT INTO Velocidad (NS_V,EO_V,Z_V) VALUES('$Nortesur','$Esteoeste','$Z')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });

// POST para insertar tabla Espectro
$app->post('/insertarespectro', function () use($db, $app) {
            $Nortesur=$_POST['NS_E'];
            $Esteoeste=$_POST['EO_E'];
            $Z=$_POST['Z_E'];

            $insert = DB:: query("INSERT INTO Espectro (NS_E,EO_E,Z_E) VALUES('$Nortesur','$Esteoeste','$Z')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });

// POST para insertar tabla Aceleracion
$app->post('/insertaraceleracion', function () use($db, $app) {
            $Nortesur=$_POST['NS_A'];
            $Esteoeste=$_POST['EO_A'];
            $Z=$_POST['Z_A'];

            $insert = DB:: query("INSERT INTO Aceleracion (NS_A,EO_A,Z_A) VALUES('$Nortesur','$Esteoeste','$Z')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });
// POST para insertar tabla Desplazamiento
$app->post('/insertarvelocidad', function () use($db, $app) {
            $Nortesur=$_POST['NS_D'];
            $Esteoeste=$_POST['EO_D'];
            $Z=$_POST['Z_D'];

            $insert = DB:: query("INSERT INTO Desplazamiento (NS_D,EO_D,Z_D) VALUES('$Nortesur','$Esteoeste','$Z')");
            $app->response()->header('Content-Type','application/json; charset=utf-8');
            echo json_encode($insert);
        });




/**
 * Step 4: Run the Slim application.
 */
$app->run();
