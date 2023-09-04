<?php
namespace App\Action;

final class argValidator
{
    private argValidator $argValidator;

    private JsonRenderer $renderer;

   public function whereGenerate($params,$table_name){
        $where = [];
        $fecha = null;

        foreach ($params as $filas => $value) {

            switch ($filas) {
                case 'format_appointment':
                    $filas = 'format_appointment.format_appointment';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];   
                    break;
                
                case 'name':
                    $filas = 'users.name';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];   
                    break;
                
                case 'surname':
                    $filas = 'users.surname';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];
                    break;
                
                case 'status':
                    $filas = 'state.status';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];
                    break;

                case 'format_appointments':
                    $filas = 'format_appointment.format_appointment';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];
                    break;

                case 'fecha_inicial':
                    $filas = "'".$table_name.'.created';
                    $value = strtoupper($value);
                    $where = [...$where,$filas => "$value"];;
                    break;

                
                default:
                    break;
            }
           
            
        }

        return $where;
    }        
}
