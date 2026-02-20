
 <div id="content">
<?php 
/**
 * This file contains the Backup_Database class wich performs
 * a partial or complete backup of any given MySQL database
 * @author Daniel López Azaña <http://www.daniloaz.com-->
 * @version 1.0
 */

// Report all errors
//error_reporting(E_ALL);

/**
 * Define database parameters here
 */
define("DB_USER", $user);
define("DB_PASSWORD", $pass);
define("DB_NAME", $base);
define("DB_HOST", $server);
define("OUTPUT_DIR", 'c:\asset_backup');
define("TABLES", '`visit`');

/**
 * Instantiate Backup_Database and perform backup
 */
$backupDatabase = new Backup_Database(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
$status = $backupDatabase->backupTables(TABLES, OUTPUT_DIR) ? 'OK' : 'KO';
echo "


Backup result: ".$status;

/**
 * The Backup_Database class
 */
class Backup_Database {
    /**
     * Host where database is located
     */
    var $host = '';

    /**
     * Username used to connect to database
     */
    var $username = '';

    /**
     * Password used to connect to database
     */
    var $passwd = '';

    /**
     * Database to backup
     */
    var $dbName = '';

    /**
     * Database charset
     */
    var $charset = '';

    /**
     * Constructor initializes database
     */
    function Backup_Database($host, $username, $passwd, $dbName, $charset = 'utf8')
    {
        $this->host     = $host;
        $this->username = $username;
        $this->passwd   = $passwd;
        $this->dbName   = $dbName;
        $this->charset  = $charset;

        //$this->initializeDatabase();
    }
/*
    protected function initializeDatabase()
    {
        $conn = mysql_connect($this->host, $this->username, $this->passwd);
        mysql_select_db($this->dbName, $conn);
        if (! mysql_set_charset ($this->charset, $conn))
        {
            mysql_query('SET NAMES '.$this->charset);
        }
    }
*/
    /**
     * Backup the whole database or just some tables
     * Use '*' for whole database or 'table1 table2 table3...'
     * @param string $tables
     */
    public function backupTables($tables = '*', $outputDir = '.')
    {
        try
        {
            /**
            * Tables to export
            */
            if($tables == '*')
            {
                $tables = array();
                $result = mysql_query('SHOW TABLES');
                while($row = mysql_fetch_row($result))
                {
                    $tables[] = $row[0];
                }
            }
            else
            {
                $tables = is_array($tables) ? $tables : explode(',',$tables);
            }

           // $sql = 'CREATE DATABASE IF NOT EXISTS '.$this->dbName.";\n\n";
            $sql = 'USE `'.$this->dbName."`;\n\n";

            /**
            * Iterate tables
            */
			$last_key = end(array_keys($tables));
            foreach($tables as $table)
            {
                echo "Backing up ".$table." table...";

                $result = mysql_query('SELECT * FROM '.$table);
                $numFields = mysql_num_fields($result);

               // $sql .= 'DROP TABLE IF EXISTS '.$table.';';
               // $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
               // $sql.= "\n\n".$row2[1].";\n\n";

                for ($i = 0; $i < $numFields; $i++) 
                {
                    while($row = mysql_fetch_row($result))
                    {
                        $sql .= 'INSERT INTO '.$table.' VALUES(NULL,';
                        for($j=1; $j<$numFields; $j++) 
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = ereg_replace("\n","\\n",$row[$j]);
                            if (isset($row[$j]))
                            {
								if($j!=8)
                                $sql .= '"'.$row[$j].'"' ;
							else
								   $sql .= 'NOW()' ;
                            }
                            else
                            {
                                $sql.= '""';
                            }

                            if ($j < ($numFields-1))
                            {
                                $sql .= ',';
                            }
                        }

                        $sql.= ");\n";
						//echo $sql;
						////////////////////////////////////////////////////////////////for the creation of the visit assets/////////////////
				$sql.="SET @visit= last_insert_id(); \n\n";
$result = mysql_query('SELECT * FROM visit_assets ');
                $numFields = mysql_num_fields($result);

               // $sql .= 'DROP TABLE IF EXISTS '.$table.';';
               // $row2 = mysql_fetch_row(mysql_query('SHOW CREATE TABLE '.$table));
               // $sql.= "\n\n".$row2[1].";\n\n";

                for ($i = 0; $i < $numFields; $i++) 
                {
                    while($row = mysql_fetch_row($result))
                    {
                        $sql .= 'INSERT INTO visit_assets VALUES(NULL,@visit ,';
                        for($j=2; $j<$numFields; $j++) 
                        {
                            $row[$j] = addslashes($row[$j]);
                            $row[$j] = preg_replace("{\n}","\\n",$row[$j]);
                            if (isset($row[$j]))
                            {
                                $sql .= '"'.$row[$j].'"' ;
                            }
                            else
                            {
                                $sql.= '""';
                            }

                            if ($j < ($numFields-1))
                            {
                                $sql .= ',';
                            }
                        }

                        $sql.= ");\n";
						//echo $sql;
											
                    
					
					}
					
					
                }						
                    
					
					}
					
					
                }
if ($table == $last_key)
                $sql.="\n\n\n";

                echo " OK <br/>" . "
";
            }
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }

        return $this->saveFile($sql, $outputDir);
    }

    /**
     * Save SQL to file
     * @param string $sql
     */
    protected function saveFile(&$sql, $outputDir = '.')
    {
        if (!$sql) return false;

        try
        {
            $handle = fopen($outputDir.'\db-asset-backup-'.$this->dbName.'-'.date("Ymd-His", time()).'.sql','w');
            fwrite($handle, $sql);
            fclose($handle);
        }
        catch (Exception $e)
        {
            var_dump($e->getMessage());
            return false;
        }

        return true;
    }
}
?>
<!-- <input type="file" type="save" />-->

</div>