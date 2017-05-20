        <?php
        function selecData(){
                if(!isset($_GET["graph"])){
                    $selectListe = "aujourdhui";
                } else {
                    $selectListe = $_GET["graph"];
                }

                switch ($selectListe){
                    case "aujourdhui":
                        return "WHERE jour='".date("d")."' AND mois='".date("m")."' AND annee='".date("y")."'";
                        break;
                    case "hier":
                        return "WHERE jour='".date("d", time() - 3600 * 24)."' AND mois='".date("m", time() - 3600 * 24)."' AND annee='".date("y", time() - 3600 * 24)."'";
                        break;
                    case "mois":
                        return "WHERE mois='".date("m")."' AND annee='".date("y")."'";
                        break;
                    case "7j":
                        $resultat = "";
                        for ($i = 0; $i <= 7; $i++) {
                            if($i == 0){
                                $resultat = "(jour='".date("d", time() - $i*(3600 * 24))."' AND mois='".date("m", time() - $i*(3600 * 24))."' AND annee='".date("y", time() - $i*(3600 * 24))."')";
                            } else {
                                $resultat = $resultat." OR (jour='".date("d", time() - $i*(3600 * 24))."' AND mois='".date("m", time() - $i*(3600 * 24))."' AND annee='".date("y", time() - $i*(3600 * 24))."')";
                            }
                            }
                        return "WHERE ".$resultat;
                        break;
                    case "30j":
                        $resultat = "";
                        for ($i = 0; $i <= 30; $i++) {
                            if($i == 0){
                                $resultat = "(jour='".date("d", time() - $i*(3600 * 24))."' AND mois='".date("m", time() - $i*(3600 * 24))."' AND annee='".date("y", time() - $i*(3600 * 24))."')";
                            } else {
                                $resultat = $resultat." OR (jour='".date("d", time() - $i*(3600 * 24))."' AND mois='".date("m", time() - $i*(3600 * 24))."' AND annee='".date("y", time() - $i*(3600 * 24))."')";
                            }
                        }
                        return "WHERE ".$resultat;
                        break;
                    case "all":
                        break;
                    default:
                        return "WHERE jour='".date("d")."' AND mois='".date("m")."' AND annee='".date("y")."'";
                        break;
                }

            }


        function traducMois($mois)
        {
            switch ($mois) {
                case 'January':
                    return 'de janvier';
                    break;
                case 'February':
                    return 'de février';
                    break;
                case 'March':
                    return 'de mars';
                    break;
                case 'April':
                    return "d'avril";
                    break;
                case 'May':
                    return 'de mai';
                    break;
                case 'June':
                    return 'de juin';
                    break;
                case 'July':
                    return 'de juillet';
                    break;
                case 'August':
                    return "d'août";
                    break;
                case 'September':
                    return 'de septembre';
                    break;
                case 'October':
                    return "d'octobre";
                    break;
                case 'November':
                    return 'de novembre';
                    break;
                case 'December':
                    return 'de décembre';
                    break;
                default:
                    return 'ERREUR';
                    break;

            }
        }

        function titre()
        {
            switch ($_GET["graph"]) {
                case "aujourdhui":
                    echo "Donnés du ";
                    echo date("d/m/y");
                    break;
                case "hier":
                    echo "Donnés du ";
                    echo date('d/m/y', time() - 3600 * 24);
                    break;
                case "7j":
                    echo "Donnés du ";
                    echo date("d/m/y", time() - 7 * (3600 * 24));
                    echo " au ";
                    echo date("d/m/y");
                    break;
                case "30j":
                    echo "Donnés du ";
                    echo date("d/m/y", time() - 30 * (3600 * 24));
                    echo " au ";
                    echo date("d/m/y");
                    break;
                case "mois":
                    echo "Donnés du mois ";
                    echo traducMois(date("F"));
                    break;
                case "all":
                    echo "Toutes les données";
                    break;
                default:
                    echo "Donnés du ";
                    echo date("d/m/y");
                    break;
            }
        }
        ?>