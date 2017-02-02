<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Classe principale de Grafomatic
 *
 * PHP version 5
 *
 * LICENSE: Ce programme est un logiciel libre distribué sous licence GNU/GPL
 *
 * @category   General
 * @package    gluPanel
 * @author     Yves Tannier <yves@grafactory.net>
 * @copyright  2006 Yves Tannier
 * @license    http://www.gnu.org/copyleft/lesser.html  LGPL License 2.1
 * @version    0.1.0
 * @link       http://www.grafactory.net
 */

 class Dao {

    /**
    * Nom de la table dans la base de données
    *
    * @var      string
    * @access   private
    */
    var $table;

    /**
    * Alias de la table pour les requêtes
    *
    * @var      string
    * @access   private
    */
    var $aliastable;

    /**
    * Champ index auto incrémenté et unique
    *
    * @var      string
    * @access   private
    */
    var $idtable;

    /**
    * Choix des champs
    *
    * @var      array
    * @access   private
    */
    var $selectfields;

    /**
    * Chaîne de connection à la base
    *
    * @var      string
    * @access   private
    */
    var $dsn;

    /**
    * Champs de la table
    *
    * @var      array
    * @access   private
    */
    var $fields;

    /**
    * type d'objet
    *
    * @var      string
    * @access   private
    */
    var $typeObj;

    //  {{{ __construct()

    /** Constructeur
     *
     * Le constructeur de la classe abstraite initie la connection
     *
     * @access private
     */
    public function __construct($pdo=null)
    {
        // chaine de connexion
        if (empty($pdo)) {
          try {
            $this->db = new PDO('mysql:host='.HOSTNAME.';dbname='.DBNAME,USERNAME,PASSWORD);

          }
          catch (PDOException $e)
          {
            print "Erreur !: " . $e->getMessage() . "<br/>";
            die();
          }
        }
        else {
          $this->db = $pdo;
        }

        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // pb avec les charset
        $this->db->query('SET NAMES utf8');

        // nom du typeObj
        $this->typeObj = strtolower($this->table);

        // préfix de la table
        define('PREFIX', '');

        // nom de la table avec prefix
        $this->table = PREFIX.$this->table;

    }

    // }}}

    // {{{ loadData()

    /** Charger les informations dans l'instanciation
     *
     * Récupére les informations complétes relatives à un enregistrement
     *
     * @param       int         $id     Valeur du champ index pour l'enregistrement
     * @return      array       $r      Retourne un tableau de données
     * @access      public
     */
    public function loadData($class,$id)
    {

        $obj = new $class();
        return $obj->getData($id);

    }

    // }}}

    //  {{{ getData()

    /** Charger les informations
     *
     * Récupére les informations complétes relatives à un enregistrement
     *
     * @param       int         $id     Valeur du champ index pour l'enregistrement
     * @return      array       $r      Retourne un tableau de données
     * @see         getField
     * @access      public
     */
    public function getData($field_value,$other_field=null)
    {

        if (!empty($other_field)) {
		 	$field = $other_field;
		 } else {
		 	$field = $this->idtable;
		 }

        $sql = 'SELECT  '.$this->getSelectfields().'
                FROM '.$this->table.' '.$this->aliastable.'
                WHERE '.$field.'='.$this->db->quote($field_value);

        // statement
        $sth = $this->db->prepare($sql);
        $sth->execute();

        if (!$sth) {
            echo "\nPDO::errorInfo():\n";
            print_r($this->db->errorInfo());
            exit;
        }

        // résultat
        $result = $sth->fetch(PDO::FETCH_ASSOC);

        if (!$result) {
            return null;
        } else {
            $this->r = $result;
        }

        return $this->r;

    }

    // }}}

    /** Mettre les infos dans un tableau
     *
     * dans une boucle, mets chaque enregistrement dans un tableau
     *
     * @return      array       $r      Retourne un tableau de données
     * @access      public
     */
    public function toArray()
    {

        // le tableau des champs
        $fields = $this->fields;

        // initialisation
        $r = array();

        for($i=0;sizeof($fields)>$i;$i++) {
            $r[$fields[$i]] = $this->getField($fields[$i]);
        }

        return $r;

    }

    // }}}

    //  {{{ findData()

    /** Chercher les informations
     *
     * Recherche dans une table en fonction des critères donnés
     *
     * @param       int         $tri    Valeur pour orderby
     * @return      array       $r      Retourne un tableau de données
     * @see         getField, setQuery
     * @access      public
     */
    public function findData($tri=null,$direction='DESC')
    {

        // tri par défaut
        if (empty($tri)) {
            $tri = $this->aliastable.'.'.$this->idtable;
        }
        else {
            $tri = $tri.' '.$direction;
        }

        // déclaration de la variable
        $sql = ' WHERE  1 ';

        if (!empty($this->queryString)) {
            $sql .= $this->queryString;
        }

        // calcul du nombre d'enregistrement
        $sql_total = 'SELECT COUNT(DISTINCT '.$this->aliastable.'.'.$this->idtable.') as total
                      FROM '.$this->table.' '.$this->aliastable.' '.$sql;



        // statement
        $sth_total = $this->db->prepare($sql_total);
        // echo ($sql_total);
        $sth_total->execute();



        if (!$sth_total) {
            echo "\nPDO::errorInfo():\n";
            print_r($this->db->errorInfo());
            exit;
        }

        // résultat
        $result = $sth_total->fetchAll();

        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($this->db->errorInfo());
            exit;
        } else {
            $this->total = $result[0]['total'];
        }


        // requete 'normale'
        $sql = 'SELECT DISTINCT '.$this->getSelectfields().'
                FROM '.$this->table.' '.$this->aliastable.' '.$sql;

        // tri
        $sql .= ' ORDER BY '.$tri;

        // si on veux limiter (limitData)
        if (!empty($this->limit)) {
            $sql .= ' LIMIT '.$this->from.','.$this->limit;
        }

        // pour le débugage
        $this->sql = $sql;
        // echo ($sql);


        // premier enregistrement ensuite nextData()
        $sth = $this->db->prepare($this->sql);
        $sth->execute();

        if (!$sth) {
            echo "\nA PDO::errorInfo():\n";
            print_r($this->db->errorInfo());
            exit;
        }

        $this->r = $sth->fetchAll(PDO::FETCH_ASSOC);

        $this->list = $sth;

        return $this->r;

    }

    // }}}

    //  {{{ setQuery()

    /** Requete spéciale
     *
     * Permet de définir une requête spéciale qui utilisé dans une méthode de 'recherche'
     *
     * @param       int         $query   Valeur de la requete
     * @return      string      $r       Requete
     * @see         findData
     * @access      public
     */
    public function setQuery($query) {
        $this->queryString = $query;
    }

    // }}}

    //  {{{ nextData()

    /** Passer à l'enregistrement suivant
    *
    * Permet de passe à l'enregistrement suivant après
    * la méthode finData()
    *
    * Exemples dans les classes filles
    *
    * @see      findData()
    * @see      hasData()
    * @access   public
    * @return   array
    */
    public function nextData() { $this->r = $this->list->fetch(PDO::FETCH_LAZY); }

    // }}}

    //  {{{ hasData()

    /** Vérifie la fin de parcours du tableau
    *
    * Avec l'utilisation des méthodes findData() et nextData()
    * permet de vérifier qu'on a parcouru tous les enregistrements
    *
    * Exemples à préciser
    *
    * @see      findData()
    * @see      nextData()
    * @access   public
    * @return   boolean
    */
    public function hasData() { return $this->r != 0; }

    // }}}

    //  {{{ getSelectfields()

    /** Passe les champs souhaités sous forme de chaine
    *
    * Récupére sous forme de string les champs qu'on souhaite pour une
    * requête. Si selectfields n'est pas précisé, on prendra tous les champs
    * comme pour un SELECT étoile.
    *
    * @access   public
    * @return   string
    */
    public function getSelectfields()
    {

        // creation de la variable
        $field_string = '';

        if(empty($this->selectfields)) {
            $this->selectfields = $this->fields;
        }

        for($i=0;$i<sizeof($this->selectfields)-1;$i++) {
            $field_string .= $this->aliastable.'.'.$this->selectfields[$i].', ';
        }
        // pour ne pas avoir de virgule à la fin
        if(!empty($this->selectfields)){
            $field_string .= $this->aliastable.'.'.$this->selectfields[$i];
        }

        return $field_string;

    }

    // }}}

    //  {{{ selectFields()

    /** Récupére les champs souhaités
    *
    * Récupére sous forme de array les champs qu'ont souhaite pour une
    * requête. Si selectfields n'est pas précisé, on prendra tous les champs
    * comme pour un SELECT étoile.
    *
    * @param    array       $fieldsext      Les champs précisés dans un tableau
    * @access   public
    * @see      getSelectfields()
    * @see      setUpdatefields()
    * @return   array
    */
    public function selectFields($fieldsext='')
    {

        if(!empty($fieldsext)) {
            $this->selectfields = $fieldsext;
        }

    }

    // }}}

    //  {{{ getField()

    /** Récupérer la valeur d'un champ
    *
    * Permet de récupérer la valeur d'un champ dans le tableau
    *
    * @see      findData()
    * @access   public
    * @return   array
    */

    public function getField($field) { return $this->r[$field]; }

    // }}}

    //  {{{ setUpdatefields()

    /** Précise les champs à updater ou insérer
    *
    * Précise dans un tableau les champs à updater ou à insérer. Le nom du champ
    * et sa valeur nécessaire à la classe DB
    *
    * @param    array       $fieldsext      Les champs précisés dans un tableau
    * @access   public
    * @return   array
    */
    public function setUpdatefields($fieldsext) { $this->setFields = $fieldsext; }

    // }}}x²x

    //  {{{ setData()

    /** Met à jour globalement les informations
     *
     * Mettre à jour toutes les champs d'un enregistrement
     *
     * @param       int         $id     Valeur du champ index pour l'enregistrement
     * @return      mixed               Retourne 1 si la mise à jour c'est bien déroulée
     * @access      public
     */
    public function setData($id=null,$last=true)
    {

        foreach($this->setFields as $s=>$v) {
            $names_fields[] = $s;
            $values_fields[] = $this->db->quote($v);
            $update_fields[] = $s.'='.$this->db->quote($v);
        }

        // si $id existe on update sinon insert
        if (!empty($id)) {
            $sql = 'UPDATE '.$this->table.' SET '.join($update_fields, ',').' WHERE '.$this->idtable.'='.$this->db->quote($id);
        } else {
            $sql = 'INSERT INTO '.$this->table.' ('.join($names_fields, ',').') VALUES ('.join($values_fields, ',').')';
        }
        $stmt = $this->db->prepare($sql);
        $stmt->execute();

        // return last_insert_id si demande
        if ($last && $id=='') {
            return $this->lastData();
        } else {
            return true;
        }

    }

    // }}}

    //  {{{ deleteData()

    /** Supprime un enregistrement
     *
     * Supprime définitivement un enregistrement
     *
     * @param       int         $id     Valeur du champ index pour l'enregistrement
     * @return      mixed
     * @see         canDelete
     * @access      public
     */
     public function deleteData($id)
     {

        $this->res = $this->db->exec('DELETE FROM '.$this->table.' WHERE '.$this->idtable.'='.$this->setQuote($id));

     }

    // }}}

    //  {{{ limitData()

    /** Limiter le nombre de résultat
     *
     * On n'affiche pas tout les résultats d'un coup. Affichage par par page
     *
     * @param   int       $limit        Nombre d'enregistrement par page
     * @param   int       $from         De quel enregistrement part-on
     * @see     findData()
     * @see     pagerData()
     * @access  private
     */
    public function limitData($limit=20, $from=0)
    {

        $this->limit = $limit;
        $this->from = $from;

    }

    // }}}

    //  {{{ pagerData()

    /** Affichage page par page
     *
     * Permet de gèrer l'affichage page par page
     * page suivante / page précédente, numéro de page ect...
     *
     * @param   int       $maxpages     Nombre de page à afficher (google like)
     * @see     findData()
     * @see     limitData()
     * @access  private
     * @return  array
     */
    public function pagerData($maxpages = false)
    {

        if (empty($this->total) || ($this->total < 0)) {
            return null;
        }

        // Nombre total de page
        $pages = ceil($this->total/$this->limit);
        $data['numpages'] = $pages;
        $data['current'] = null;

        // première page / dernière page
        $data['firstpage'] = 1;
        $data['lastpage']  = $pages;

        // array des numéros de pages
        $data['pages'] = array();
        for ($i=1; $i <= $pages; $i++) {
            $offset = $this->limit * ($i-1);
            $data['pages'][$i] = $offset;
            // $from must point to one page
            if ($this->from == $offset) {
                // The current page we are
                $data['current'] = $i;
            }
        }

        // limit le nombre de numéro de page (comme google)
        if ($maxpages) {
            $radio = floor($maxpages/2);
            $minpage = $data['current'] - $radio;
            if ($minpage < 1) {
                $minpage = 1;
            }
            $maxpage = $data['current'] + $radio - 1;
            if ($maxpage > $data['numpages']) {
                $maxpage = $data['numpages'];
            }
            foreach (range($minpage, $maxpage) as $page) {
                $tmp[$page] = $data['pages'][$page];
            }
            $data['pages'] = $tmp;
            $data['maxpages'] = $maxpages;
        } else {
            $data['maxpages'] = null;
        }

        // lien 'précédent'
        $prev = $this->from - $this->limit;
        $data['prev'] = ($prev >= 0) ? $prev : null;

        // lien 'suivant'
        $next = $this->from + $this->limit;
        $data['next'] = ($next < $this->total) ? $next : null;

        //  ou somme nous ?
        if ($data['current'] == $pages) {
            $data['remain'] = 0;
            $data['to'] = $this->total;
        } else {
            if ($data['current'] == ($pages - 1)) {
                $data['remain'] = $this->total - ($this->limit*($pages-1));
            } else {
                $data['remain'] = $this->limit;
            }
            $data['to'] = $data['current'] * $this->limit;
        }
        $data['numrows']    = $this->total;
        $data['from']       = $this->from + 1;
        $data['limit']      = $this->limit;
        $data['lastdata']   = $data['numpages']*$this->limit-$this->limit;

        return $data;


    }


    // }}}

    //  {{{ countData()

    /** Compte le nombre de résultat
    *
    * Compte le nombre de résultat d'une requete
    *
    * @access   public
    * @return   int
    */
    public function countData() { return $this->list->numRows(); }

    // }}}

    //  {{{ lastData()

    /** Récupére le dernier enregistrement
    *
    * Après un insert, récupére l'id du dernier enregistrement
    *
    * @access   public
    * @return   int
    */
    public function lastData()
    {

        $sql = 'SELECT LAST_INSERT_ID() as newid
                FROM '.$this->table;

        // statement
        $sth = $this->db->prepare($sql);
        $sth->execute();

        if (!$sth) {
            echo "\nPDO::errorInfo():\n";
            print_r($this->db->errorInfo());
            exit;
        }

        // résultat
        $result = $sth->fetchAll();

        if (!$result) {
            echo "\nPDO::errorInfo():\n";
            print_r($this->db->errorInfo());
            exit;
        } else {
            $r = $result[0];
        }

        return $r['newid'];

    }

    // }}}

    //  {{{ getToArray()

    /** Place le résultat dans un array
    *
    *
    * @access   public
    * @return   array
    * @param    mixed $id Id de l'enregistrement
    */
    public function getToArray($id) { return $this->getData($id); }

    // }}}

}
?>
