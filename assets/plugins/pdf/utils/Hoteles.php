<?php 
class Hoteles{

/*     
https://www.grupodiemsa.com/v1/?hotel=CataloniaRoyalTulum
https://www.grupodiemsa.com/v1/?hotel=CataloniaRiveraMaya
https://www.grupodiemsa.com/v1/?hotel=CataloniaPlayaMaroma
https://www.grupodiemsa.com/v1/?hotel=CataloniaCostaMujeres
https://www.grupodiemsa.com/v1/?hotel=MajesticCostaMujeres
https://www.grupodiemsa.com/v1/?hotel=DisaludClinic 
*/

    // * * Se define Tipo de hotel en layer default;        
    public static $hoteles= ['0',
                'CataloniaRoyalTulum',
                'CataloniaRiveraMaya',
                'CataloniaPlayaMaroma',
                'CataloniaCostaMujeres',
                'MajesticCostaMujeres',
                'DisaludClinic'
    ];

    public static $hoteles_nombres= ['3214efd4t',
                'Catalonia Royal Tulum',
                'Catalonia Rivera Maya',
                'Catalonia Playa Maroma',
                'Catalonia Costa Mujeres',
                'Majestic Costa Mujeres',
                'Disalud Clinic'
    ];

    public static  $hoteles_corto =['arreglo de abreviaturas de hoteles',
        'CRT', // Catalonia Royal Tulum
        'CRM', // Catalonia Riviera Maya
        'CPM', // Catalonia Playa Maroma
        'CMU', // Catalonia Costa Mujeres
        'MCM', // Majestic Costa mujeres
        'HGE' //   ??? parece que ya no se usa
    ];

    public static  $hoteles_horarios =['arreglo horarios',
        'CRT'=> [   // Catalonia Royal Tulum
                    ['lunes'=>'08:00:00','martes'=>'08:00:00','miercoles'=>'08:00:00','jueves'=>'08:00:00','viernes'=>'08:00:00','sabado'=>'08:00:00','domingo'=>'none'],
                    ['lunes'=>'13:30:00','martes'=>'13:30:00','miercoles'=>'13:30:00','jueves'=>'13:30:00','viernes'=>'13:30:00','sabado'=>'13:30:00','domingo'=>'none']
                ], 
        'CRM'=> [   // Catalonia Riviera Maya
                    ['lunes'=>'09:00:00','martes'=>'09:00:00','miercoles'=>'09:00:00','jueves'=>'09:00:00','viernes'=>'09:00:00','sabado'=>'09:00:00','domingo'=>'09:00:00'],
                    ['lunes'=>'11:30:00','martes'=>'11:30:00','miercoles'=>'11:30:00','jueves'=>'11:30:00','viernes'=>'11:30:00','sabado'=>'11:30:00','domingo'=>'11:30:00']
                ], 
        'CPM'=> [   // Catalonia Playa Maroma
                    ['lunes'=>'09:00:00','martes'=>'09:00:00','miercoles'=>'09:00:00','jueves'=>'09:00:00','viernes'=>'09:00:00','sabado'=>'09:00:00','domingo'=>'09:00:00'],
                    ['lunes'=>'11:30:00','martes'=>'11:30:00','miercoles'=>'11:30:00','jueves'=>'11:30:00','viernes'=>'11:30:00','sabado'=>'11:30:00','domingo'=>'11:30:00']
                ], 
        'CMU'=> [   // Catalonia Costa Mujeres
                    ['lunes'=>'09:30:00','martes'=>'09:30:00','miercoles'=>'09:30:00','jueves'=>'09:30:00','viernes'=>'09:30:00','sabado'=>'09:30:00','domingo'=>'08:00:00'],
                    ['lunes'=>'13:30:00','martes'=>'13:30:00','miercoles'=>'13:30:00','jueves'=>'13:30:00','viernes'=>'13:30:00','sabado'=>'13:30:00','domingo'=>'12:00:00']
                ], 
        'MCM'=> [   // Majestic Costa mujeres
                    ['lunes'=>'08:00:00','martes'=>'08:00:00','miercoles'=>'08:00:00','jueves'=>'08:00:00','viernes'=>'08:00:00','sabado'=>'08:00:00','domingo'=>'08:00:00'],
                    ['lunes'=>'13:30:00','martes'=>'13:30:00','miercoles'=>'13:30:00','jueves'=>'13:30:00','viernes'=>'13:30:00','sabado'=>'13:30:00','domingo'=>'12:00:00']
                ], 
        'HGE'=>[
                    ['lunes'=>'08:00:00','martes'=>'08:00:00','miercoles'=>'08:00:00','jueves'=>'08:00:00','viernes'=>'08:00:00','sabado'=>'08:00:00','domingo'=>'08:00:00'],
                    ['lunes'=>'08:00:00','martes'=>'08:00:00','miercoles'=>'08:00:00','jueves'=>'08:00:00','viernes'=>'08:00:00','sabado'=>'08:00:00','domingo'=>'08:00:00']
                ], //   ??? parece que ya no se usa
    ];

    public static  $hoteles_costo_ptueba_ant =['arreglo costos de las pruebas Antigenos',
        2200, // Catalonia Royal Tulum
        2200, // Catalonia Riviera Maya
        2200, // Catalonia Playa Maroma
        2200, // Catalonia Costa Mujeres
        1600, //todo Majestic Costa mujeres
        2200 //   ??? parece que ya no se usa
    ];

    public static  $hoteles_costo_ptueba_pcr =['arreglo costos de las pruebas PCR',
        8000, // Catalonia Royal Tulum
        8000, // Catalonia Riviera Maya
        8000, // Catalonia Playa Maroma
        8000, // Catalonia Costa Mujeres
        100000, //todo Majestic Costa mujeres 6500
        8000 //   ??? parece que ya no se usa
    ];

    //? ID MAYOR QUE 38617 PARA COMENZAR A ESCOJER PRUEBAS A PARTIR DE CRM4000 (ESTO A CAUSA DEL PROBLEMA DEL ROLLBACK REALIZADO EN DB) 07-07-21 VERIFICADO
    public static  $hoteles_limits_id =['arreglo de ids a omitir por errores de la base de datos',
        18115, // Catalonia Royal Tulum
        38617, // Catalonia Riviera Maya
        25117, // Catalonia Playa Maroma
        35617, // Catalonia Costa Mujeres
        61618, // Majestic Costa mujeres
        61800 //   ??? parece que ya no se usa HGE hospital general //-> todos los nuevos 
    ];

    // debe hacer match con core/app/view/index-view-tabla-superadmin-btnPago.php
    // y Pruebas::validateMethodPay()
    public static $metodosPago= [
        'Tarjeta',
        'Terminal',
        'Cargo al hotel',
        'Efectivo',
        'GRATUITO',
        'Cancelada',
    ];

    public function Hoteles(){
        //arma un array de 24 horas con 60 minutos
        $this->id = "";
    }

    public static function horas($h_inicio,$hora_final){
        //arma un array de 24 horas con 60 minutos
        $x =  [];
        for ($i=0; $i <= $hora_final; $i++) { 
            $x[$i]= [];
            for ($z=0; $z <= 60; $z++) { 
                $x[$i][] = "libre";
            }
        }
        return $x;
    }

    public static function horarios($dia=''){
        if($dia!=''){$dia=" and  fechaCita like '$dia %' ";}
        //selecciona todas las pruebas que sean del dia que se elige a buscar para indexarlas en el option del front en bookNow
        //? select * from pruebas where prueba like 'CRT%' 
        //? and fecha_registro like '2021-08-03 %' 
        //? or fecha like '2021-08-03 %'
        //?  ORDER BY `id` DESC
        $sql= "select id,prueba,fecha,fecha_resultado,fecha_registro,fechaCita from pruebas where prueba like '".Hoteles::$hoteles_corto[$_SESSION['hotelNum']]."%' ".$dia;
        $query = Database::exeDoIt($sql);

        if ($query[0]->num_rows == 0)
        {
            $query = array(['id'=>'todo libre']);
            return  $query;// si no hay resultados, devuelve array en ceros con 1 elemento en ceros.
        }
        else
        {
            $data = Model::many($query[0], new Hoteles());
            return $data;
        }


    }

    public static function getCadena(){
        $cadena = explode(' ',$_SESSION['hotel']); //* CATALONIA/ROYAL/TULUM
        //// $cadena = explode(" ", strtoupper("Majestic Costa Mujeres"));

        $array_cadena = [];
        $array_cortos_hoteles= [];

        foreach (Hoteles::$hoteles_nombres as $key => $val) {
            # recorriendo los hoteles de la cadena
            $value = explode(' ',strtoupper($val));
            if($cadena[0] == $value[0]){
                $array_cadena[] = $key;
                $array_cortos_hoteles[] = Hoteles::$hoteles_corto[$key];
            }
        }
        return $array_cortos_hoteles;
    }
}

?>