<?php
/**
 * This class provides methods to realize a company.
 *
 * @author Mbalkam Martin<info@kentnix.com>
 * @name account
 * @package Kentnix
 * @version 1.0
 * @link http://www.kentnix.com
 */
class candidat
{
	/**
	 * Constructor
	 *
	 * @access protected
	 */
	function candidat()
	{
		
	}

	/**
	 * create page 
	 *
	 * @param int $id id of page
	 * @return bool
	 */
	function getCandidat($id)
	{
		global $conn;
		$id = (int) $id;

        $candidat = $conn->query("SELECT c.nom, c.prenom, it.code, c.datenaiss, c.photo
FROM candidats c, institution it
WHERE c.ID =$id
AND it.ID = c.iduniv")->fetch();
		if (!empty($candidat))
		{
			return $candidat;
		}
		else
		{
			return false;
		}
	}
	/*
	*get all candidat
	*/
	function getAllCandidat()
	{
		global $conn;
		$cand = array();
		
        $candidat = $conn->query("SELECT c.ID,c.nom, c.prenom, it.code, c.datenaiss, c.photo
FROM candidats c, institution it
WHERE it.ID = c.iduniv ");
 
        while ($ca = $candidat->fetch()) {
            array_push($cand,$ca);
        }
		if (!empty($cand))
		{
			return $cand;
		}
		else
		{
			return false;
		}
	}
	
	function getCandidatDiscipline($id)
	{
		global $conn;
		$id = (int) $id;
        $discipline=array();
       $sel = $conn->query("SELECT d.code,d.ID FROM cand_discipline cd,disciplines d  WHERE cd.idcand = $id and cd.iddis=d.ID");
		
		
		while($dis = $sel->fetch())
		{
			array_push($discipline,$dis);
		}
		if (!empty($discipline))
		{
			return $discipline;
		}
		else
		{
			return false;
		}
	}
	
	
	function countCandidate($iduniv,$iddis)
	{
		global $conn;
		$iduniv = (int) $iduniv;
		$iddis=(int) $iddis;
        $discipline=array();
        $num = $conn->query("SELECT count(cs.ID) as num FROM candidats cs, cand_discipline cd WHERE cd.iddis=$iddis and cs.iduniv=$iduniv and cs.ID=cd.idcand")->fetch() or die(mysql_error());
		
		
		if (!empty($num))
		{
			return $num["num"];
		}
		else
		{
			return false;
		}
	}
	
	function getOrder($iddis,$idcand)
	{
		global $conn;
        $discipline=array();
        $num = $conn->query("SELECT ordre FROM cand_discipline  WHERE iddis=$iddis and idcand=$idcand")->fetch();
		
		
		if (!empty($num))
		{
			return $num["ordre"];
		}
		else
		{
			return false;
		}
	}
	/*
	verify if we can add candidat
	*/
	function canAddCandidat($cni)
	{
		global $conn;
        $discipline=array();
        $num = $conn->query("SELECT count(*) as nbre FROM candidats  WHERE cni='$cni' ")->fetch();
		
		
		if (!empty($num))
		{
			return $num["nbre"];
		}
		else
		{
			return false;
		}
	}
	/**
	 * Create a page
	 *
	 * @param string $title Page id
	 * @param string $containt Company's name
	 * @param string $keyword page keyword
	 * @param string $logo Company's logo
	 * @return bool
	 */
	function addCandidat($cni, $cnidate, $cnilieu, $cnipar, $nom, $prenom, $genre, $datenaiss, $lieunaiss, $iduniv, $diplome, $numdip, $lieudip, $datedip, $qualite, $tel, $email,$iddis,$photo)
	{
    global $conn;			
	$ins1Stmt = $conn->prepare("INSERT INTO candidats(ID, cni, cnidate, cnilieu, cnipar, nom, prenom, genre, datenaiss, lieunaiss, iduniv, diplome, numdip, lieudip, datedip, qualite, tel, email,photo) VALUES ('', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?,?,?)");
	$insid = $ins1Stmt->execute(array($cni, $cnidate, $cnilieu, $cnipar, $nom, $prenom, $genre, $datenaiss, $lieunaiss, $iduniv, $diplome, $numdip, $lieudip, $datedip, $qualite, $tel, $email,$photo));
		 //create user account
		 
		 if($insid)
		 {
			 $idcan=$conn->lastInsertId();
			  
			 $val=$this->addDis($idcan, $iddis,$iduniv);
			
				 return $idcan;
			 
			 
		}
		else
		{
			return false;
		}
	}
	/**
	 * Delete a company
	 *
	 * @param int $id Company ID
	 * @return bool
	 */
	 function addDis($idcan, $iddis,$iduniv)
	{
    global $conn;			
	$num=$this->countCandidate($iduniv,$iddis);	
	 $num=$num+1;
	$ins1Stmt = $conn->prepare("INSERT INTO cand_discipline(ID, idcand, iddis, datecomp,ordre) VALUES ('', ?, ?, ?,?)");
	$insid = $ins1Stmt->execute(array($idcan, $iddis, date("Y-m-d"),$num)) or die(mysql_error());
		 //create user account
		 
		 if($insid)
		 {
			 
			 return  true;
			 
		}
		else
		{
			return false;
		}
	}
	function del($id)
	{
		global $conn;
		$id = (int) $id;
        $del = $conn->query("DELETE FROM articles WHERE id = $id");
		if ($del)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}

?>