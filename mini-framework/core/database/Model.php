<?php

/**
 * Classe de base générique pour  
 */

class Model
{
    public static function fetchAll($tableName, $orderBy, $fetchClass)
    {
        $dbh = App::get('dbh');
        $req = "select * from " . $tableName; 
        $req .= " ORDER BY " . $orderBy . " ASC";
        $statement = $dbh->prepare($req);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_CLASS, $fetchClass);
    }

    public static function fetch($tableName, $tabArgs)
    {
        $dbh = App::get('dbh'); 
        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "SELECT * FROM " . $tableName . " WHERE ";
        for($counter = 0; $counter < sizeof($tabArgs); $counter++)
        {
            $req .= $tabArgs[$counter][0];
            $req .= "= ?";
            if($counter != sizeof($tabArgs)-1)
            {
                $req .= " AND ";
            }
        }

        $statement = $dbh->prepare($req);
        for($i = 1; $i <= sizeof($tabArgs); $i++)
        {
            $statement->bindParam($i, $tabArgs[$i-1][1], $tabArgs[$i-1][2]);
        }
        $statement->execute();
        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public static function login($tableName, $tabArgs)
    {
        $dbh = App::get('dbh'); 
        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "SELECT * FROM " . $tableName . " WHERE ";
        for($counter = 0; $counter < sizeof($tabArgs); $counter++)
        {
            $req .= $tabArgs[$counter][0];
            $req .= "= ?";
            if($counter != sizeof($tabArgs)-1)
            {
                $req .= " AND ";
            }
        }

        $statement = $dbh->prepare($req);
        for($i = 1; $i <= sizeof($tabArgs); $i++)
        {
            $statement->bindParam($i, $tabArgs[$i-1][1], $tabArgs[$i-1][2]);
        }

        // use exec() because no results are returned
        //$statement->debugDumpParams();
        $statement->execute();
        $fetch = $statement->fetch();
        return !empty($fetch);
    }

    public static function update($tableName, $tabArgs)
    {
        // $argv are variable names and values to add to $tableName
        $dbh = App::get('dbh');

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "UPDATE " . $tableName . " SET ";
        for($counter = 0; $counter < sizeof($tabArgs) - 1; $counter++)
        {
            $req .= $tabArgs[$counter][0] . "=?";
            if($counter != sizeof($tabArgs) - 2)
            {
                $req .= ", ";
            }
        }
        $req .= " WHERE " . $tabArgs[$counter][0] . "=?";


        $statement = $dbh->prepare($req);
        for($i = 1; $i <= sizeof($tabArgs); $i++)
        {
            $statement->bindParam($i, $tabArgs[$i-1][1], $tabArgs[$i-1][2]);
        }
        $statement->execute();
    }

    public static function add($tableName, $tabArgs) 
    {
        // $argv are variable names and values to add to $tableName
        $dbh = App::get('dbh');

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "INSERT INTO " . $tableName . " (";
        for($counter = 0; $counter < sizeof($tabArgs); $counter++)
        {
            $req .= $tabArgs[$counter][0];
            if($counter != sizeof($tabArgs) - 1)
            {
                $req .= ", ";
            }
            else
            {
                $req .= ") VALUES (";
                for($i = 0; $i < sizeof($tabArgs); $i++)
                {
                    $req .= "?";
                    if($i != sizeof($tabArgs) - 1)
                    {
                        $req .= ", ";
                    }
                    else
                    {
                        $req .= ")";
                    }
                }
            }
        }

        $statement = $dbh->prepare($req);
        for($i = 1; $i <= sizeof($tabArgs); $i++)
        {
            $statement->bindParam($i, $tabArgs[$i-1][1], $tabArgs[$i-1][2]);
        }

        // use exec() because no results are returned
        //$statement->debugDumpParams();
        $statement->execute();
    }

    public static function delete($tableName, $tabArgs)
    {
        // $argv are variable names and values to add to $tableName
        $dbh = App::get('dbh');

        // prepared statement with question mark placeholders (marqueurs de positionnement)
        $req = "DELETE FROM " . $tableName . " WHERE ";
        $req .= $tabArgs[0][0] . "=?";


        $statement = $dbh->prepare($req);
        $statement->bindParam(1, $tabArgs[0][1], $tabArgs[0][2]);
        $statement->execute();
    }
}