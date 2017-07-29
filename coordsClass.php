<?php

class Coords 
{
    //Cette classe prend en parametre l'adresse ip ou le du quartier et retourne la longitude et la latitude de la ville $
    //On aura donc deux fonctions une qui retourne les coordonnées par le la ville et le quartier getCoordsByCity et getCoordsByIp par l'ip 

    /**
*Fonction retournant la longitude et la latitude en fonction de la ville
*return @array(lng,lat)
*/

    public static function getCoordsByCity($ville = 'Abidjan',$quartier)
    {
        $googleQuery = $ville.' '.$quartier;
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($googleQuery) . '&sensor=false';
        $url = htmlspecialchars($url);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = json_decode(curl_exec($ch), true);
        
        if ($response['status'] != 'OK')
        {
            echo 'Une erreur a été detecté : '.print_r($response);
        } else {
            $geo = $response['results'][0]['geometry'];
            $longitude = $geo['location']['lat'];
            $latitude = $geo['location']['lng'];
        }
        return array($longitude, $latitude);
    }
    
    
    /**
    *Fonction permettant d'obtenir les coordonnees par l'ip du gars 
    *return @array (longitude,latitude, pays, quartier, F.A.I)
    */
    public static function getCoordsByIp($ip)
    {
        $query = @unserialize(file_get_contents('http://ip-api.com/php/'.$ip));
        if ($query && $query['status'] == 'success')
        {
            $longitude = $query['lon'];
            $latitude = $query['lat'];
            $country = $query['country'];
            $city = $query['city'];
            $fai = $query['org'];
            
            return array($longitude, $latitude, $country, $city, $fai);
        }
    }
    
    
}


/*$l = Coords::getCoordsByCity('Abidjan', 'yopougon');
$coords = List($lng,$lat) = $l;
echo $lng;*/

/*$test = Coords::getCoordsByIp('41.207.202.244');
List($lng, $lat, $pays, $city, $fai) = $test;
echo '<br>';
echo $lng;*/

var_dump(Coords::getCoordsByIp('41.207.215.173'));